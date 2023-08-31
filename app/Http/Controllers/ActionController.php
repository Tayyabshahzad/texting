<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Models\Coupon;
use App\Models\Subscription;
use App\Models\CustomerDetail;
use App\Models\CouponList;
use App\Models\PricingPlan;
use App\Models\User;
use App\Models\Sms;
use Illuminate\Support\Facades\Auth;
use Exception;
use Twilio\Rest\Client;
use App\Models\TwilioSms;
use App\Models\TwilioSmsLog;
use App\Models\CustomerGroup;
use App\Models\CustomerGroupMember;
use App\Models\CustomerSurvey;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionOption;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
{
    // Coupon 1 = Regular
    // Coupon 2 = New Subscriber
    // Coupon 3 = Birthday
    public function updateSubs(Request $request)
    {

        $user = Auth::user();
        $subs = UserSubscription::where('user_id', Auth::id())->where('unsubbed_at', NULL)->pluck('customer_details_id')->toArray();

        $newSubIds = $request->subs;
        $removedIds = array_diff($subs, $newSubIds);
        $addedIds = array_diff($newSubIds, $subs);
        try {
            // Unsub:
            foreach ($removedIds as $item) {
                UserSubscription::where('user_id', $user->id)
                    ->where('customer_details_id', $item)
                    ->update(['unsubbed_at' => now()]);
            }

            // Check if user has a signup coupon and if a welcome coupon is set
            $hasSignupCoupon = CouponList::where('user_id', $user->id)
                ->join('coupons', 'coupons_list.coupon_id', '=', 'coupons.id')
                ->where('coupons.type', 2)
                ->get();

            // Sub
            foreach ($addedIds as $item) {
                $add = new UserSubscription;
                $add->user_id = $user->id;
                $add->customer_details_id = $item;
                $add->created_at = now();
                $add->updated_at = now();
                $add->save();

                //Check if user is a new subscriber of this customer
                $existingSubber = UserSubscription::whereNotNull('unsubbed_at')->where('user_id', $user->id)->first();

                //Send welcome coupon if no existing unsubscription record exists and signup coupon is null
                if ($existingSubber == null && $hasSignupCoupon !== null) {
                    //First Time subber, send welcome SMS

                    // Get welcome SMS
                    $coupon = Coupon::where('customer_details_id', $item)->where('type', 2)->first();
                    $r = CustomerDetail::find($coupon->customer_details_id)->first();


                    // Save coupon and send sms


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

            return response()->json(['message' => 'Success']);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            response()->json(['error' => 'Something went wrong...', 'message' => $e->getMessage()], 401);
        }
    }

    public function createCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|max:10',
            'description' => 'required'
        ]);
        $recipientGroup = $request->recipient_group;
        $customerDetails = CustomerDetail::with('user')->get();
        //Get Business User Details
        $cdid = CustomerDetail::where('user_id', Auth::user()->id)->first();
        $expiry = $request->expiry_date . ' ' . $request->expiry_time;


        // Create the coupon
        try {
            // Send Coupon if type = 1 (Normal coupon)
            $coupon = new Coupon();
            $coupon->code = $request->code;
            $coupon->description = $request->description;
            $coupon->expiry = $expiry;
            $coupon->type = $request->type;
            $coupon->created_by_id = Auth::user()->id;
            $coupon->customer_details_id = $cdid->id;
            $coupon->created_at = now();
            $coupon->save();
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            response()->json(['error' => 'Something went wrong...', 'message' => $e->getMessage()], 401);
        }
        switch ($recipientGroup) {
            case $recipientGroup == 'all':
                // Send to all subscribers
                $subs = UserSubscription::where('customer_details_id', $cdid->id)->whereNull('unsubbed_at')->pluck('user_id')->toArray();
                $subscribers = User::select('id', 'name', 'phone')->whereIn('id', $subs)->get();
                $this->sendCoupons($subscribers, $coupon->id);
                return response()->json(['message' => 'Success']);
                break;
            case $recipientGroup == 'group':
                // Send to members of group id
                $groupId = $request->selected_recipient_group_id;
                $groupMembers = CustomerGroupMember::where('customer_group_id', $groupId)->pluck('user_id')->toArray();
                $subscribers = User::select('id', 'name', 'phone')->whereIn('id', $groupMembers)->get();

                $this->sendCoupons($subscribers, $coupon->id);
                return response()->json(['message' => 'Success']);
                break;
            case $recipientGroup == 'subset':
                // Send to top percentage of users
                $percentage = $request->selected_recipient_percentage;

                $subs = UserSubscription::where('customer_details_id', $cdid->id)->whereNull('unsubbed_at')->pluck('user_id')->toArray();
                $subscribersArray = User::select('id', 'name', 'phone')->whereIn('id', $subs)->pluck('id')->toArray();
                $noOfUsers = $percentage * count($subscribersArray) / 100;

                $subscribers = User::select('users.id', 'users.name', 'users.phone', DB::raw('COUNT(coupons_list.id) as redeemed_count'))
                    ->leftJoin(DB::raw('(SELECT * FROM coupons_list WHERE redeemed = 1) as coupons_list'), 'users.id', '=', 'coupons_list.user_id')
                    ->whereIn('users.id', $subs)
                    ->groupBy('users.id')
                    ->orderBy('redeemed_count', 'DESC')
                    ->get();

                $this->sendCoupons($subscribers, $coupon->id);
                return response()->json(['message' => 'Success']);

                break;
            default:
                response()->json(['error' => 'Something went wrong...', 'message' => 'Error sending coupons'], 401);
        }
    }

    // Check if birthday or newuser coupon exists. If not then create it.
    public function updateStaticCoupons(Request $request)
    {
        $cdid = CustomerDetail::with('user')->first();
        $found = Coupon::find($request->coupon_id);

        if ($request->active == true) {
            if ($found) {
                $found->code = $request->code;
                $found->description = $request->description;
                $found->updated_at = now();
                $found->save();

                return response()->json(['message' => 'Success']);
            } else {
                $coupon = new Coupon();
                $coupon->code = $request->code;
                $coupon->description = $request->description;
                $coupon->type = $request->type;
                $coupon->created_by_id = Auth::user()->id;
                $coupon->customer_details_id = $cdid->id;
                $coupon->created_at = now();
                $coupon->save();

                return response()->json(['message' => 'Success']);
            }
        } else if ($request->active == false) {
            $found->delete();
            return response()->json(['message' => 'Success']);
        }

        return response()->json(['error' => 'Something went wrong...', 'message' => 'Something went wrong...'], 401);
    }

    public function sendCoupons($subscribers, $couponId)
    {
        $user = Auth::user();
        // Check if customer has active subscription
        $customerSubscription = Subscription::where('user_id', $user->id)
            ->whereNull('ends_at')
            ->orWhere('ends_at', '<=', Carbon::now())
            ->first();
        if ($customerSubscription !== null) {
            // Check if SMS limit is not hit
            $customerPlan = PricingPlan::where('stripe_plan', $customerSubscription->name)
                ->where('stripe_price', $customerSubscription->stripe_price)
                ->first(); // e.g customer select 500 sms packege
            //Count number of smses sent for coupons owned by current customer
            $couponIds = Coupon::where('created_by_id', $user->id)->whereMonth('created_at', Carbon::now()->month)->pluck('id')->toArray();
            $sentTotal = TwilioSms::whereIn('coupon_id', $couponIds)->whereMonth('created_at', Carbon::now()->month)->count(); //e.g 20
            // Check if sentTotla < Customer plan limit
            if ($customerPlan->max_smses - $sentTotal > 0) {
                // Starte sending smses
                // Send SMSE
                $result         = ['success' => false, 'data' => [], 'message' => '', 'twilio_sms_id' => null];

                $account_sid    = env("TWILIO_SID");
                $auth_token     = env("TWILIO_TOKEN");
                $twilio_number  = env("TWILIO_FROM");
                $coupon_url     = env("COUPON_URL");
                $bin_url        = route('api.twilio.status-changed');
                $client         = new Client($account_sid, $auth_token);
                $url            = $coupon_url . "/redeem/" . $couponId;
                // Send different text based on coupon type 1/2/3
                $dbText         = SMS::find(1);
                $content        = $dbText->content;
                $nameReplace    = 'dct-comp-name';
                $urlReplace     = 'dct-url';
                $coupon         = Coupon::find($couponId);
                $creator        = CustomerDetail::where('user_id', $coupon->created_by_id)->first();
                $bodyTxt        = str_replace($nameReplace, $creator->name, $content);
                $bodyTxt        = str_replace($urlReplace, $url, $bodyTxt);
                $bodyTxt        = $bodyTxt . ' ' . $coupon->description;


                foreach ($subscribers as $item) {
                    if ($item->phone == '27713400456') {
                        $phone = '+27713400456';
                    } else {
                        $phone = '+1' . $item->phone;
                    }
                    // Save to coupon_list
                    $userCoupon = new CouponList();
                    $userCoupon->coupon_id = $couponId;
                    $userCoupon->user_id = $item->id;
                    $userCoupon->save();
                    // Send SMS

                    try {
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
                            'to_user_id' => $item->id,
                            'coupon_id' => $couponId,
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
            } else {
                return response()->json(['message' => 'Error, sms cap reached']);
            }
        } else {
            return response()->json(['message' => 'Error, user has no active subscription']);
        }

        return response()->json(['message' => 'Success']);
    }

    public function redeemCoupon(Request $request)
    {
        $user = Auth::user();
        $userCoupon = CouponList::where('coupon_id', $request->coupon_id)->where('user_id', $user->id)->first();
        $code = CustomerDetail::find($request->customer_id)->pluck('verification_code')->first();
        if ($request->verification_code !== $code) {
            return response()->json(['message' => 'Invalid Code'], 401);
        } else if ($request->verification_code == $code) {
            if ($userCoupon->redeemed !== 1) {
                $userCoupon->update(['redeemed' => 1, 'redeemed_at', now()]);
            }

            return response()->json(['message' => 'Success']);
        }
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

    public function statusChanged(Request $request)
    {
        // Create log
        try {
            $logData = [
                'sms_sid' => $request['SmsSid'] ?? null,
                'sms_message_sid' => $request['MessageSid'] ?? null,
                'twilio_sms_id' => null,
                'event' => 'not_categorized',
                'new_status' => $request['MessageStatus'] ?? null,
                'details' => json_encode(($request->all() ?? [])),
            ];

            try {
                if (!isset($request['SmsSid'])) {
                    $logData['event'] = 'invalid_request_sid_not_defined';
                    throw new Exception('Sid not defined. Could not match with system sms.');
                }

                $twilioSms = TwilioSms::select('id', 'sid', 'status')->where('sid', $request['SmsSid'])->first();

                if (empty($twilioSms->id)) {
                    $logData['event'] = 'twilio_sms_not_found';
                    throw new Exception('Twilio sms sid: ' . $request['SmsSid'] . ' was not found.');
                }

                $logData['twilio_sms_id'] = $twilioSms->id;
                $logData['event'] = 'partial_status_changed';

                if (isset($request['SmsStatus']) && $twilioSms->status != $request['SmsStatus']) {
                    $logData['event'] = 'status_changed';
                    $twilioSms->status = $request['SmsStatus'];
                    $twilioSms->save();
                }
            } catch (Exception $ex2) {
                Log::channel('twilio')->error($ex2->getFile() . ' :: ' . $ex2->getMessage() . ' :: ' . json_encode(($request->all() ?? [])));
            }

            TwilioSmsLog::create($logData);
        } catch (Exception $ex) {
            Log::channel('twilio')->error($ex->getFile() . ' :: ' . $ex->getMessage() . ' :: ' . json_encode(($request->all() ?? [])));
        }

        return response(['success' => true], 200);
    }

    public function updateSettings(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $request->validate([
            'type' => 'required|in:password,info,logo',
        ]);
        if($request->type == 'logo'){
            $request->validate([
                'logo' => 'required|file|max:2048',
            ]);
            if ($request->hasFile('logo')) {
                $file_name = time() . '_' . $request->logo->getClientOriginalName();
                $request->logo->move(public_path('public'), $file_name);
                $file_path = '/public/' . $file_name;
                $user->customerDetails->logo_location = $file_path;
                $user->customerDetails->save();
                return redirect()->back()->withErrors(['current_password' => '1'])->with('active_tab', 'logo')->with('success', 'Logo has been updated');
            }else{
                return redirect()->back()->withErrors(['current_password' => '0'])->with('active_tab', 'logo')->with('success', 'Error while updating logo');
            }

        }elseif($request->type == 'password'){
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);
            $current_password = $request->current_password;
            $newPassword = $request->password;
            if(Hash::check($current_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($newPassword)
                ]);
                return redirect()->back()->with('active_tab', 'password')->with('success', 'The Password has been updated');
            }else{
                return redirect()->back()->withErrors(['current_password' => 'The old password is incorrect.'])->with('active_tab', 'password')->with('error', 'The old password is incorrect');
            }
        }else {
            $request->validate([
                'type' => 'required',
                'name' => 'required',
                'birthday'=>'date',
                'phone'=>'required|max:10|min:10',
                'description' => 'string',
                'map_url' => 'url',
            ]);
        }
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->birthday = $request->birthday;
        $user->save();
        $user->customerDetails->description = $request->description;
        $user->customerDetails->verification_code = $request->verification_code;
        $user->customerDetails->map_url = $request->map_url;
        $user->customerDetails->save();
        if ($request->hasFile('file')) {
            $validator = Validator::make($request->all(), [
                'file' => 'max:500000',
            ]);
            if ($validator->fails()) {
                return response()->json(['message' => $validator]);
            }
            $file_name = time() . '_' . $request['file']->getClientOriginalName();
            $request['file']->move(public_path('public'), $file_name);
            $file_path = '/public/' . $file_name;
            $user->customerDetails->logo_location = $file_path;
        }
        $user->customerDetails->save();
        return redirect()->back()->with('success','Profile has been updated')->with('active_tab', 'info');



        if ($request->type == 'customer') {
            $customerDetails = CustomerDetail::where('user_id', $user->id)->first();


            if ($data['name'] !== "") {
                $customerDetails->name = $data['name'];
                $user->name = $data['name'];
            }

            if ($data['description'] !== "") {
                $customerDetails->description = $data['description'];
            }
            if ($data['map_url'] !== "") {
                $customerDetails->map_url = $data['map_url'];
            }
            if ($request->hasFile('file')) {

                $validator = Validator::make($request->all(), [
                    'file' => 'max:500000',
                ]);

                if ($validator->fails()) {
                    return response()->json(['message' => $validator]);
                }

                $file_name = time() . '_' . $request['file']->getClientOriginalName();
                $request['file']->move(public_path('public'), $file_name);

                $file_path = '/public/' . $file_name;

                $customerDetails->logo_location = $file_path;
            }
            if ($data['theme'] !== "" && $data['theme'] !== '#FFFFF0FF') {
                $customerDetails->theme = $data['theme'];
            }
            if ($data['verification_code'] !== "") {
                $customerDetails->verification_code = $data['verification_code'];
            }

            if ($data['current_pass'] !== "" && $data['new_pass'] !== "") {
                if (!Hash::check($data['current_pass'], $user->password)) {
                    $user->password = Hash::make($data['new_pass']);
                } else {
                    return response()->json(['message' => 'Error']);
                }
            }

            $customerDetails->save();
            $user->save();

            return response()->json(['message' => 'Success']);
        }
    }

    public function updateUserSettings(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if (isset($request['data']['name'])) {
            $user->name = $request['data']['name'];
        }
        if (isset($request['data']['dob'])) {
            $user->birthday = $request['data']['dob'];
        }
        if (isset($request['data']['phone'])) {
            $user->phone = ['data']['phone'];
        }

        if (isset($request['data']['current_pass']) && isset($request['data']['new_pass'])) {
            if (!Hash::check($request['data']['current_pass'], $user->password)) {
                $user->password = Hash::make($request['data']['new_pass']);
            } else {
                return response()->json(['message' => 'Error']);
            }
        }
        $user->save();

        return response()->json(['message' => 'Success']);
    }

    public function updateSms(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('Super-Admin')) {
            try {
                $sms = Sms::find(1);
                $sms->content = $request->data;
                $sms->save();

                return response()->json(['message' => 'Success']);
            } catch (Exception $e) {
                echo 'Message: ' . $e->getMessage();
                response()->json(['error' => 'Something went wrong...', 'message' => $e->getMessage()], 401);
            }
        } else {
            response()->json(['error' => 'Insufficient roles'], 401);
        }
    }

    public function verify(Request $request)
    {
        if ($request->user()->verification_code !== $request->code) {
            return back()->withErrors(['Invalid Code Please Try Again!']);
        }

        if ($request->user()->userPhoneVerified()) {
            return redirect()->route('home');
        }

        $request->user()->phoneVerifiedAt();

        $sub = UserSubscription::where('user_id', Auth::user()->id)->first();

        if ($sub !== null) {

            $cdid = CustomerDetail::find($sub['customer_details_id']);
            $survey = CustomerSurvey::where('user_id', $cdid['user_id'])->first();

            if ($survey !== null) {
                return redirect()->route('signup-survey', [$cdid->liveurl])->with('status', 'Your phone was successfully verified!');
            }
        } else {
            return redirect()->route('home')->with('status', 'Your phone was successfully verified!');
        }
    }

    public function resendSms(Request $request)
    {
        $user = Auth::user();

        if ($user->phone_verified_at == NULL) {

            $account_sid = env('TWILIO_SID');
            $auth_token = env('TWILIO_TOKEN');
            $twilio_number = env('TWILIO_FROM');
            $client = new Client($account_sid, $auth_token);


            $bodyTxt = "Your verification code is: " . $user->verification_code;

            if ($request->user()->phone == '27713400456') {
                $phone = '+' . $user->phone;
            } else {
                $phone = '+1' . $user->phone;
            }

            $apiResponse = $client->messages->create(
                $phone, // to
                [
                    "body" => $bodyTxt,
                    "from" => $twilio_number
                ]
            );
        }



        return redirect()->route('phoneverification.show')->with('status', 'SMS Sent');
    }

    public function createGroup(Request $request)
    {

        $request->validate([
            'group_name' => 'required',
            'subscribers.*' => 'required'
        ]);

        try {
            $group = new CustomerGroup();
            $group->name = $request->group_name;
            $group->user_id = Auth::user()->id;
            $group->created_at = now();
            $group->save();

            foreach ($request->subscribers as $value) {
                $groupMember = new CustomerGroupMember();
                $groupMember->customer_group_id = $group->id;
                $groupMember->user_id = $value;
                $groupMember->created_at = now();
                $groupMember->save();
            }
            return redirect()->back()->with('success','Group Created');

        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            return redirect()->back()->with('success','Error While Creating Group');
            //response()->json(['error' => 'Something went wrong...', 'message' => $e->getMessage()], 401);
        }
    }

    public function getGroup($id)
    {

        try {
            $groupMembers = CustomerGroupMember::where('customer_group_id', $id)->pluck('user_id');

            return response()->json(['message' => 'Success', 'data' => $groupMembers]);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            response()->json(['error' => 'Something went wrong...', 'message' => $e->getMessage()], 401);
        }
    }

    public function deleteGroup($id)
    {

        try {
            $group = CustomerGroup::find($id)->delete();

            return response()->json(['message' => 'Success']);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            response()->json(['error' => 'Something went wrong...', 'message' => $e->getMessage()], 401);
        }
    }

    public function deleteGroupV2(Request $request)
    {
        $request->validate([
            'group_id' => 'required',
        ]);

        try {
            $group = CustomerGroup::find($request->group_id)->delete();
            return redirect()->back()->with('success','Group Deleted');
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            return redirect()->back()->with('success','Error while deleting group');
        }
    }

    public function saveSurvey(Request $request)
    {

        // dd($request->q1);
        // $request->validate([
        //     'q1' => 'required',
        // ]);

        $validator = Validator::make($request->all(), [
            'questions.*' => 'required|string|max:255',
            'options.*.*' => 'required|string|max:255',
            'best_options.*.*' => 'sometimes|numeric', // Assuming best options are numeric indices
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $questions = $request->input('questions');
        $customerSurvey = new CustomerSurvey();
        $customerSurvey->user_id = Auth::user()->id;
        $customerSurvey->survey_question_id_1 = 0;
        $customerSurvey->survey_question_id_2 = 0;
        $customerSurvey->survey_question_id_3 = 0;
        $customerSurvey->save();
        $counter = 0;
        foreach ($questions as $index => $questionText) {
            $counter++;
            $SurveyQuestion = SurveyQuestion::create([
                'question' => $questionText,
            ]);
            $s = 'survey_question_id_' . $counter;
            $survey = CustomerSurvey::find($customerSurvey->id);
            $survey->$s = $SurveyQuestion->id;
            $survey->save();
            $optionsArray = $request->input("options.$index", []);

            foreach ($optionsArray as $optionIndex => $optionText) {
                    $bestOption = in_array($optionText, $request->input("best_options.$index", []));
                    SurveyQuestionOption::create([
                        'survey_question_id' => $SurveyQuestion->id,
                        'survey_question_option' => $optionText,
                    ]);
            }
        }
        return redirect()->back()->with('success','Survey Created');


    }

    public function saveSurveyResponse(Request $request)
    {

        try {
            foreach ($request->a1 as $value) {
                $surveyAnswer = new SurveyAnswer();
                $surveyAnswer->user_id = Auth::user()->id;
                $surveyAnswer->survey_question_id = $request->q1;
                $surveyAnswer->survey_question_option_id = $value;
                $surveyAnswer->save();
            }

            foreach ($request->a2 as $value) {
                $surveyAnswer = new SurveyAnswer();
                $surveyAnswer->user_id = Auth::user()->id;
                $surveyAnswer->survey_question_id = $request->q2;
                $surveyAnswer->survey_question_option_id = $value;
                $surveyAnswer->save();
            }

            foreach ($request->a3 as $value) {
                $surveyAnswer = new SurveyAnswer();
                $surveyAnswer->user_id = Auth::user()->id;
                $surveyAnswer->survey_question_id = $request->q3;
                $surveyAnswer->survey_question_option_id = $value;
                $surveyAnswer->save();
            }
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            response()->json(['error' => 'Something went wrong...', 'message' => $e->getMessage()], 401);
        }

        return response()->json(['message' => 'Success']);
    }
}
