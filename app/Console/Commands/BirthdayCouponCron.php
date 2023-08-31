<?php

namespace App\Console\Commands;

use App\Models\Coupon;
use App\Models\CustomerDetail;
use App\Models\CouponList;
use Twilio\Rest\Client;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;
use App\Models\TwilioSms;
use App\Models\TwilioSmsLog;

class BirthdayCouponCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function log($data)
    {
        try {
            if (empty($data)) {
                throw new Exception('Invalid log data');
            }

            $logData = [
                'twilio_sms_id' => $data['twilio_sms_id'] ?? null,
                'sms_sid' => $data['sms_sid'] ?? null,
                'sms_message_sid' => $data['sms_sid'] ?? null,
                'event' => $data['event'] ?? 'generic_error',
                'new_status' => $data['new_status'] ?? null,
                'details' => json_encode(($data['details'] ?? [])),
            ];

            TwilioSmsLog::create($logData);
        } catch (Exception $ex) {
            // NOTICE: Should probably create a log channel just for Twilio
            Log::channel('single')->error($ex->getFile() . ' :: ' . $ex->getLine() . ' :: ' . $ex->getMessage());
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // Get coupons of type = birthday
        $currentDate = Carbon::today()->format('m-d');

        Log::info("Running birthday chron for - " . $currentDate);
        // Get customer birthdays for today
        $usersWithBirthdayToday = User::whereRaw("DATE_FORMAT(birthday, '%m-%d') = ?", [$currentDate])->get();
        Log::info("Users with birthdays today: " . $usersWithBirthdayToday);

        foreach ($usersWithBirthdayToday as $user) {
            // print_r($user);
            // Get the user subscriptions and check if any of those customer details have active birthday coupons
            $userSubscriptions = UserSubscription::where('user_id', $user->id)->get();

            foreach ($userSubscriptions as $subscription) {
                //Send SMS for each subscription with birthday coupons active

                $coupons = UserSubscription::where('user_id', $user->id)
                    ->join('coupons', 'user_subscriptions.customer_details_id', '=', 'coupons.customer_details_id')
                    ->where('coupons.type', 3)
                    ->get();


                if ($coupons !== null) {
                    foreach ($coupons as $coupon) {
                        // Send coupon
                        // Get welcome SMS
                        $r = CustomerDetail::find($coupon->customer_details_id)->first();

                        // Save to coupon_list
                        $userCoupon = new CouponList();
                        $userCoupon->coupon_id = $coupon->id;
                        $userCoupon->user_id = $user->id;
                        $userCoupon->save();

                        // Send SMS
                        try {
                            $account_sid = env('TWILIO_SID');
                            $auth_token = env('TWILIO_TOKEN');
                            $twilio_number = env('TWILIO_FROM');
                            $bin_url = route('api.twilio.status-changed');
                            $client = new Client($account_sid, $auth_token);
                            $coupon_url = env("COUPON_URL");
                            $url = $coupon_url . "/redeem/" . $coupon->id;
                            $bodyTxt = 'NEW COUPON from ' . $r->name . '. Please visit: ' . $url . ' ' . $coupon->description;

                            if ($user->phone == '27713400456') {
                                $phone = '+' . $user->phone;
                            } else {
                                $phone = '+1' . $user->phone;
                            }

                            $apiResponse = $client->messages->create(
                                $phone, // to
                                [
                                    "body" => $bodyTxt,
                                    "from" => $twilio_number,
                                    "statusCallback" => $bin_url
                                ]
                            );

                            $result['data'] = $apiResponse->toArray();
                            $result['success'] = true;
                            $result['message'] = 'SMS request success';

                            $createdSms = TwilioSms::create([
                                'sid' => $result['data']['sid'],
                                'direction' => 'sent',
                                'from' => $result['data']['from'],
                                'to' => $result['data']['to'],
                                'status' => $result['data']['status'],
                                'body' => $result['data']['body'],
                                'to_user_id' => $user->id,
                                'coupon_id' => $coupon->id,
                            ]);

                            $result['twilio_sms_id'] = $createdSms->id ?? null;

                            $this->log([
                                'twilio_sms_id' => $createdSms->id ?? null,
                                'sms_sid' => $result['data']['sid'] ?? null,
                                'event' => 'send_sms_request',
                                'new_status' => $result['data']['status'] ?? null,
                                'details' => $result['data'],
                            ]);
                        } catch (Exception $e) {
                            $result['success'] = false;
                            $result['message'] = $e->getMessage();
                            $result['data']['error_message'] = $result['message'];
                            $this->log([
                                'twilio_sms_id' => null,
                                'sms_sid' => $result['data']['sid'] ?? null,
                                'event' => 'send_sms_request_error',
                                'new_status' => $result['data']['status'] ?? null,
                                'details' => $result['data'] ?? [],
                            ]);

                            print_r($result['message']);
                            return response()->json(['message' => $result['message']]);
                        }
                    }
                }
            }
        }
    }
}
