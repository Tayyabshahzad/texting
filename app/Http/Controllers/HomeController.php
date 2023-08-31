<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Twilio\Rest\Client;
use App\Models\CustomerDetail;
use App\Models\User;
use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Models\CouponList;
use App\Models\Coupon;
use App\Models\PricingPlan;
use App\Models\TwilioSms;
use App\Models\Sms;
use App\Models\CustomerGroup;
use App\Models\CustomerSurvey;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionOption;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['liveSignup']]);
    }

    public function show(Request $request)
    {
        if (Auth::user()->userPhoneVerified()) {
            return redirect()->route('home');
        } else {
            return view('phoneverify.show');
        }
    }

    public function resend(Request $request)
    {

        return view('phoneverify.resend');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $customerDetails = CustomerDetail::where('user_id', $user->id)->first();
        $isUser = $user->hasRole('User');
        $isCustomer = $user->hasRole('Customer');
        $groups = CustomerGroup::where('user_id', $user->id)->get();
        if ($isUser) {
            $available = CustomerDetail::all();
            $couponList = CouponList::with('coupon')
                ->where('coupons_list.user_id', $user->id)
                ->where('coupons.expiry', '>=', now())
                ->join('coupons', 'coupons_list.coupon_id', '=', 'coupons.id')
                ->join('customer_details', 'coupons.created_by_id', '=', 'customer_details.user_id')
                ->get();
            return view('home', ['available' => $available, 'couponList' => $couponList]);
        } else if ($isCustomer) {

            $cdid = CustomerDetail::where('user_id', $user->id)->first();
            // Remaining SMSes for the month

            // Customer Pricing Plan
            $c = Subscription::where('user_id', $user->id)
                ->whereNull('ends_at')
                ->orWhere('ends_at', '<=', Carbon::now())
                ->first();
            $currentPlan = PricingPlan::where('stripe_plan', $c->name)->first();

            //Count number of smses sent for coupons owned by current customer
            $couponIds = Coupon::where('created_by_id', $user->id)->whereMonth('created_at', Carbon::now()->month)->pluck('id')->toArray();
            $sentTotal = TwilioSms::whereIn('coupon_id', $couponIds)->whereMonth('created_at', Carbon::now()->month)->count();

            // Sub stats
            $customerDetailsId = $customerDetails->id;

            $totalSubscribers = UserSubscription::where('customer_details_id', $customerDetailsId)->count();
            $monthlySubscribers =  UserSubscription::where('customer_details_id', $customerDetailsId)->whereMonth('created_at', Carbon::now()->month)->count();

            $currentYear = date('Y'); // Get the current year
            $yearlySubscribers = UserSubscription::where('customer_details_id', $customerDetailsId)
            ->whereYear('created_at', $currentYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();


            $subStats = UserSubscription::where('customer_details_id', $customerDetailsId)
                ->selectRaw('DATE(created_at) as created_date')
                ->selectRaw('COUNT(user_id) as count_user_id')
                ->selectRaw('COUNT(CASE WHEN unsubbed_at IS NOT NULL THEN user_id END) as count_unsubscribed')
                ->selectRaw('created_at, updated_at, unsubbed_at')
                ->groupBy('customer_details_id', 'created_date', 'created_at', 'updated_at', 'unsubbed_at')
                ->orderBy('customer_details_id')
                ->orderBy('created_date')
                ->get();

            $dates = $cumulativeCounts = [];
            $cumulativeCount = 0;

            foreach ($subStats as $stat) {
                $date = Carbon::parse($stat->created_date)->format('m/d/Y');
                $count = $stat->count_user_id - $stat->count_unsubscribed;
                $cumulativeCount += $count;

                // check if this date already exists in the array
                $key = array_search($date, $dates);
                if ($key === false) {
                    // if not, add the date and the count
                    $dates[] = $date;
                    $cumulativeCounts[] = $cumulativeCount;
                } else {
                    // if it does, update the count for that date
                    $cumulativeCounts[$key] = $cumulativeCount;
                }
            }

            $subscriptionStats = new \stdClass();
            $subscriptionStats->date = $dates;
            $subscriptionStats->count = $cumulativeCounts;

            // Coupons stats
            $couponStats = DB::table('coupons')
                ->select(
                    'coupons.code AS coupon_code',
                    DB::raw('COUNT(CASE WHEN twilio_sms.status = "delivered" THEN 1 END) AS delivered_count'),
                    DB::raw('COUNT(CASE WHEN twilio_sms.status = "sent" THEN 1 END) AS sent_count'),
                    DB::raw('COUNT(CASE WHEN twilio_sms.status = "failed" THEN 1 END) AS failed_count')
                )
                ->join('twilio_sms', 'twilio_sms.coupon_id', '=', 'coupons.id')
                ->where('coupons.created_by_id', Auth::user()->id)
                ->whereMonth('coupons.created_at', Carbon::now()->month)
                ->where('coupons.type', 1)
                ->groupBy('coupons.code')
                ->get();

            $couponCodes = $couponStats->pluck('coupon_code')->toArray();

            $statusCounts = [
                ['name' => 'delivered', 'data' => []],
                ['name' => 'sent', 'data' => []],
                ['name' => 'failed', 'data' => []]
            ];

            foreach ($couponStats as $stats) {
                $statusCounts[0]['data'][] = $stats->delivered_count;
                $statusCounts[1]['data'][] = $stats->sent_count;
                $statusCounts[2]['data'][] = $stats->failed_count;
            }

            $couponStats = new \stdClass();
            $couponStats->coupons = $couponCodes;
            $couponStats->stats = $statusCounts;

            // Redeemed/Sent --------------------------------

            $redeemed = DB::table('coupons_list')
                ->join('coupons', 'coupons.id', '=', 'coupons_list.coupon_id')
                ->join('users', 'users.id', '=', 'coupons.created_by_id')
                ->where('coupons.created_by_id', Auth::user()->id)
                ->select(
                    'coupon_id',
                    'coupons.code',
                    DB::raw('SUM(redeemed = 1) AS redeemed_count'),
                    DB::raw('SUM(redeemed = 0) AS unredeemed_count'),
                )
                ->groupBy('coupon_id')
                ->get();

            $ratioCounts = [
                ['name' => 'undereemed', 'data' => []],
                ['name' => 'redeemed', 'data' => []]
            ];

            foreach ($redeemed as $redeem) {
                $ratioCounts[0]['data'][] = (int)$redeem->unredeemed_count;
                $ratioCounts[1]['data'][] = (int)$redeem->redeemed_count;
            }

            $redeemedRatio = new \stdClass();
            $redeemedRatio->coupons = $couponCodes;
            $redeemedRatio->stats = $ratioCounts;

            // Subscribers
            $s = UserSubscription::where('customer_details_id', $cdid->id)
                ->pluck('user_id')
                ->toArray();

            $subscribers = User::select('users.id', 'users.name', 'users.phone', DB::raw('COUNT(coupons_list.id) as redeemed_count'))
                ->leftJoin(DB::raw('(SELECT * FROM coupons_list WHERE redeemed = 1) as coupons_list'), 'users.id', '=', 'coupons_list.user_id')
                ->whereIn('users.id', $s)
                ->groupBy('users.id')
                ->orderBy('redeemed_count', 'DESC')
                ->get();
            // User::select('name', 'phone')
            // ->whereIn('users.id', $s)
            // ->join('coupons_list', 'users.id', '=', 'coupons_list.user_id')
            // ->groupBy('coupons_list')
            // ->get();


            $birthdayCoupon = Coupon::where('created_by_id', $user->id)->where('type', 3)->get();
            $userUserCoupon = Coupon::where('created_by_id', $user->id)->where('type', 2)->get();

            $survey = CustomerSurvey::where('user_id', $user->id)->first();


            if ($survey !== null) {
                $arr = [$survey->survey_question_id_1, $survey->survey_question_id_2, $survey->survey_question_id_3];

                $ss = DB::table('survey_questions')
                    ->select(
                        'survey_questions.id as question_id',
                        'survey_questions.question',
                        'survey_question_options.id as option_id',
                        'survey_question_options.survey_question_option',
                        DB::raw('COUNT(survey_answers.id) as count')
                    )
                    ->join('survey_question_options', 'survey_questions.id', '=', 'survey_question_options.survey_question_id')
                    ->leftJoin('survey_answers', 'survey_question_options.id', '=', 'survey_answers.survey_question_option_id')
                    ->whereIn('survey_questions.id', $arr)
                    ->groupBy('survey_questions.id', 'survey_question_options.id')
                    ->get();

                $surveyResults = [];

                foreach ($ss as $data) {
                    $questionId = $data->question_id;
                    $question = $data->question;
                    $optionId = $data->option_id;
                    $option = $data->survey_question_option;
                    $count = $data->count;

                    if (!isset($surveyResults[$questionId])) {
                        $surveyResults[$questionId] = [
                            'question' => $question,
                            'options' => [
                                'option' => [],
                                'count' => [],
                            ],
                        ];
                    }

                    $surveyResults[$questionId]['options']['option'][] = $option;
                    $surveyResults[$questionId]['options']['count'][] = $count;
                }

                $surveyCounts = new \stdClass();
                $surveyCounts->questions = array_values($surveyResults);
            } else {
                $surveyCounts = new \stdClass();
                $surveyCounts->type = ['no-data'];
                $surveyCounts->count = [1];
            }


          //  dd(Auth::user()->customerCoupons);
            return view('home', [
                'liveurl' => $customerDetails->liveurl,
                'subscribers' => $subscribers,
                'customerdetails' => $cdid,
                'subscriberstats' => $subscriptionStats,
                'couponstats' => json_encode($couponStats),
                'redeemedratio' => $redeemedRatio,
                'savedNewuserCoupon' => $userUserCoupon,
                'savedBirthdayCoupon' => $birthdayCoupon,
                'sentTotal' => $sentTotal,
                'currentPlan' => $currentPlan,
                'totalSubscribers' => $totalSubscribers,
                'monthlySubscribers' => $monthlySubscribers,
                'groups' => $groups,
                'survey' => $survey,
                'yearlySubscribers'=>$yearlySubscribers,
                'surveyCounts' => json_encode($surveyCounts)
            ]);
        }

        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view('dashboard');
    }

    public function qrcode($tag)
    {
        return view('qrcode', ['tag' => $tag]);
    }

    public function qrcodeDownload($tag)
    {
        $image = QrCode::size(500)->format('png')
            ->generate('https://dashboard.textingdiscounts.com/live-signup/' . $tag);
        $output_file = 'code.png';
        Storage::disk('local')->put($output_file, $image);

        return response()->download(
            storage_path('app/' . $output_file)
        );
    }

    public function signupSurvey($liveurl)
    {
        $details = CustomerDetail::where('liveurl', $liveurl)->first();

        $survey = CustomerSurvey::where('user_id', $details->user_id)->first();
        $q1 = SurveyQuestion::find($survey->survey_question_id_1);
        $q2 = SurveyQuestion::find($survey->survey_question_id_2);
        $q3 = SurveyQuestion::find($survey->survey_question_id_3);
        $opts1 = SurveyQuestionOption::where('survey_question_id', $q1->id)->get();
        $opts2 = SurveyQuestionOption::where('survey_question_id', $q2->id)->get();
        $opts3 = SurveyQuestionOption::where('survey_question_id', $q3->id)->get();

        return view('signupSurvey', ['details' => $details, 'survey' => $survey, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'opts1' => $opts1, 'opts2' => $opts2, 'opts3' => $opts3]);
    }

    public function liveSignup($liveurl)
    {
        $details = CustomerDetail::where('liveurl', $liveurl)->first();
        return view('liveSignup', ['details' => $details]);
    }

    public function terms($liveurl)
    {
        $details = CustomerDetail::where('liveurl', $liveurl)->first();
        return view('terms', ['details' => $details]);
    }

    public function redeem($couponId)
    {
        $coupon = Coupon::find($couponId);
        $place = CustomerDetail::find($coupon->customer_details_id);
        $isRedeemed = CouponList::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->pluck('redeemed')->first();
        return view('redeem', ['coupon' => $coupon, 'place' => $place, 'redeemed' => $isRedeemed]);
    }

    public function adminTools()
    {

        $sms = Sms::find(1);

        // User > Cust > Total counts
        $counts = array();
        $total = User::all()->count();
        $customers = CustomerDetail::all()->count();
        $custIds = CustomerDetail::all()->pluck('user_id');
        $users = User::all()->whereNotIn('id', $custIds)->count();

        $counts['total'] = $total;
        $counts['customers'] = $customers;
        $counts['users'] = $users;

        // User counts per day
        $uc = DB::table('users')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->whereNotIn('id', $custIds)
            ->groupBy('date')
            ->get();

        $cc = DB::table('customer_details')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->get();

        $data = [];
        $categories = [];

        foreach ($uc as $count) {
            $data[] = $count->count;
            $categories[] = $count->date;
        }

        $data2 = [];
        $categories2 = [];

        foreach ($cc as $count) {
            $data2[] = $count->count;
            $categories2[] = $count->date;
        }

        $series =
            [
                [
                    'name' => 'Users',
                    'data' => $data
                ],
                [
                    'name' => 'Customers',
                    'data' => $data2
                ]
            ];

        $xaxis = [
            'categories' => $categories
        ];

        $xaxis2 = [
            'categories' => $categories2
        ];

        $xfinal = array_merge($xaxis, $xaxis2);

        $userCounts['series'] = $series;
        $userCounts['xaxis'] = $xfinal;
        $counts['userCounts'] = $userCounts;

        return view('admintools', ['sms' => $sms, 'counts' => $counts]);
    }

    public function viewCustomerSurvey()
    {
        $user = Auth::user();
        $survey = CustomerSurvey::where('user_id', $user->id)->first();
        $q1 = SurveyQuestion::find($survey->survey_question_id_1);
        $q2 = SurveyQuestion::find($survey->survey_question_id_2);
        $q3 = SurveyQuestion::find($survey->survey_question_id_3);
        $opts1 = SurveyQuestionOption::where('survey_question_id', $q1->id)->get();
        $opts2 = SurveyQuestionOption::where('survey_question_id', $q2->id)->get();
        $opts3 = SurveyQuestionOption::where('survey_question_id', $q3->id)->get();
        return view('admin.survey', ['survey' => $survey, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'opts1' => $opts1, 'opts2' => $opts2, 'opts3' => $opts3]);
        // return view('customerSurvey', ['survey' => $survey, 'q1' => $q1, 'q2' => $q2, 'q3' => $q3, 'opts1' => $opts1, 'opts2' => $opts2, 'opts3' => $opts3]);
    }
    public function coupons(){
        $coupons = Auth::user()->customerCoupons->where('type', 1);
        $today_date = Carbon::now()->format('Y-m-d');
        $coupons_expires = Auth::user()->customerCoupons->where('type', 1)->where('expiry','<=',Carbon::now());
        $coupons_redeem = Auth::user()->customerCoupons->where('type', 1);
        return view('admin.coupons',compact('coupons','coupons_expires'));
    }

    public function subscriptions(){
        $user = Auth::user();
        $cdid = CustomerDetail::where('user_id', $user->id)->first();
        $s = UserSubscription::where('customer_details_id', $cdid->id)->pluck('user_id')->toArray();
        $subscribers = User::select('users.id', 'users.name', 'users.phone', DB::raw('COUNT(coupons_list.id) as redeemed_count'))
                ->leftJoin(DB::raw('(SELECT * FROM coupons_list WHERE redeemed = 1) as coupons_list'), 'users.id', '=', 'coupons_list.user_id')
                ->whereIn('users.id', $s)
                ->groupBy('users.id')
                ->orderBy('redeemed_count', 'DESC')
                ->get();
                $groups = CustomerGroup::where('user_id', $user->id)->get();
        //dd($subscribers);
        return view('admin.subscriptions',compact('subscribers','groups'));
    }
    public function settings(){
        $user = Auth::user();
        $customerDetails = CustomerDetail::where('user_id', $user->id)->first();
        $survey = CustomerSurvey::where('user_id', $user->id)->first();
        return view('admin.settings',compact('customerDetails','survey'));
    }
}
