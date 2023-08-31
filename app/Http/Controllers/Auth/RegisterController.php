<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\CustomerDetail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSubscription;
use App\Http\Controllers\ActionController;
use App\Models\Coupon;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Exception;
use App\Models\CouponList;
use App\Models\TwilioSms;
use Illuminate\Support\Facades\Log;
use App\Models\TwilioSmsLog;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendTest()
    {
        $user = 'Sanushen';
        $text = "Dear " . $user . ",

Thank you for signing up with Texting Discounts! We're thrilled to have you on board and look forward to helping you connect with your customers in new and innovative ways.
As promised, we're sending you a receipt for your subscription along with some helpful resources to get you started with our platform.

Below are some best practices to ensure your success with Texting Discounts:

Promote your new texting service to your customers. Use the flyer templates and graphics we've included in this email to help spread the word. Place QR codes in-store, on menus, or social media to make signing up easy.
Incentivize sign-ups. Offer exclusive discounts or rewards for customers who opt-in to your texting program. The more value you offer, the more likely they'll be to sign up and remain engaged.
Be consistent. Set a regular cadence for sending out text promotions and stick to it. Consistency builds trust and ensures your customers won't forget about your business.
Use data to optimize your strategy. Our platform provides detailed analytics and reporting on your campaign performance. Use this data to improve your promotions and tailor your messaging to your customers' preferences.
Engage with your customers. Our platform allows for personalized offers and segmentation. Use this feature to target specific customer groups and make them feel valued.
We hope these best practices help you make the most of our platform. If you have any questions or need further assistance, don't hesitate to reach out to our customer support team at admin@textingdiscounts.com.

Thank you again for choosing Texting Discounts as your digital marketing partner. We're excited to see your business thrive with our platform!

Best regards,
The Texting Discounts Team";

        try {
            Mail::raw($text, function ($message) {
                $message->from('mailer@dashboard.textingdiscounts.com', 'Texting Discounts');
                $message->to('sanushen@gmail.com');
                $message->subject('Texting Discounts');
            });


            return 'sent';
        } catch (\Exception $e) {


            return $e;
        }
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

      return  Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'size:10', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'phone.size' => 'Phone number must be 10 digits',
            'phone.max' => 'Phone number must be 10 digits',
        ]);


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {


        $verificationCode  = mt_rand(1000, 9000);
        $account_sid = env('TWILIO_SID');
        $auth_token = env('TWILIO_TOKEN');
        $twilio_number = env('TWILIO_FROM');
        $client = new Client($account_sid, $auth_token);



        $user =  User::create([
            'name' => $data['name'],
            'verification_code' => $verificationCode,
            'phone_verified_at' => null,
            'phone' => $data['phone'],
            'birthday' => $data['dob'],
            'password' => Hash::make($data['password'])
        ]);
        $user->assignRole('User');
        //dd(1);
        // Your Account SID and Auth Token from twilio.com/console


        try{
            $client = new Client($account_sid, $auth_token);
            if ($data['phone'] == '27713400456') {
                $phone = '+' . $data['phone'];
            } else {
                $phone = '+1' . $data['phone'];
            }
              // }
            $phone = '+923275127298';
            $bodyTxt = "Your verification code is: " . $verificationCode;
            $apiResponse = $client->messages->create(
                $phone, // to
                [
                    "body" => $bodyTxt,
                    "from" => $twilio_number
                ]
            );
        }catch(Exception $api_error){

        }
        return $user;


        // Send SMS
        // try {
        //     $apiResponse = $client->messages->create(
        //         $phone, // to
        //         [
        //             "body" => $bodyTxt,
        //             "from" => $twilio_number
        //         ]
        //     );
        // } catch (Exception $e) {
        //     $result['success'] = false;
        //     $result['message'] = $e->getMessage();
        //     $result['data']['error_message'] = $result['message'];

        //     return response()->json(['message' => $result['message']]);
        // }




    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\Models\User
     */
    protected function registerNewCustomer(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'size:10', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'description' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors($validator) // Pass the validation errors to the view
            ->withInput(['error_for'=> 'business']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);


        $user->assignRole('Customer');
        $liveUrl = preg_replace("/[^a-zA-Z0-9]+/", "-", $request->name);

        CustomerDetail::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'description' => $request->description,
            'logo_location' => null,
            'theme' => '#FFFFF',
            'liveurl' => $liveUrl,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //Auth User
        $credentials = $request->only('phone', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();

        // Send welcome email
        $text = "Dear " . $request->name . ",

Thank you for signing up with Texting Discounts! We're thrilled to have you on board and look forward to helping you connect with your customers in new and innovative ways.
As promised, we're sending you a receipt for your subscription along with some helpful resources to get you started with our platform.

Below are some best practices to ensure your success with Texting Discounts:

Promote your new texting service to your customers. Use the flyer templates and graphics we've included in this email to help spread the word. Place QR codes in-store, on menus, or social media to make signing up easy.
Incentivize sign-ups. Offer exclusive discounts or rewards for customers who opt-in to your texting program. The more value you offer, the more likely they'll be to sign up and remain engaged.
Be consistent. Set a regular cadence for sending out text promotions and stick to it. Consistency builds trust and ensures your customers won't forget about your business.
Use data to optimize your strategy. Our platform provides detailed analytics and reporting on your campaign performance. Use this data to improve your promotions and tailor your messaging to your customers' preferences.
Engage with your customers. Our platform allows for personalized offers and segmentation. Use this feature to target specific customer groups and make them feel valued.
We hope these best practices help you make the most of our platform. If you have any questions or need further assistance, don't hesitate to reach out to our customer support team at admin@textingdiscounts.com.

Thank you again for choosing Texting Discounts as your digital marketing partner. We're excited to see your business thrive with our platform!

Best regards,
The Texting Discounts Team";

        Mail::raw($text, function ($message) use ($request) {
            $message->from('mailer@dashboard.textingdiscounts.com', 'Texting Discounts');
            $message->to($request->email);
            $message->subject('Texting Discounts');
        });


        return redirect()->route('purchase-plan')->withSuccess('You have successfully registered & logged in!');
    }

    /**
     * Live Signups.
     *
     * @return \App\Models\User
     */
    protected function doLiveSignup(Request $request)
    {

        // $messages = [
        //     'required' => 'The :attribute field is required',
        //     'numeric'    => 'The :attribute should be numbers only',
        //     'size' => 'The :attribute should be 10 characters',
        //     'max'      => 'The :attribute must have a maximum length of :max',
        // ];

        // $validated = $request->validate([
        //     'name' => 'required|max:50',
        //     'phone' => 'required|digits:10|numeric',
        //     'password' => 'required|confirmed|min:6',
        // ], $messages);

        $customerId = $request->customer_id;
        $customerUserId = $request->customer_user_id;
        $r = CustomerDetail::where('user_id', $customerUserId)->first();
        $coupon = Coupon::where('created_by_id', $customerUserId)->where('type', 2)->first(); // Type 2 = signup coupon
        $liveUrl = $r->liveurl;

        // Send verification code
        $verificationCode  = mt_rand(1000, 9000);
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'birthday' => $request->dob,
            'verification_code' => $verificationCode,
            'phone_verified_at' => null,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('User');
        $credentials = $request->only('phone', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();

        // Send verification sms
        // Your Account SID and Auth Token from twilio.com/console

        $account_sid = env('TWILIO_SID');
        $auth_token = env('TWILIO_TOKEN');
        $twilio_number = env('TWILIO_FROM');
        $bin_url = route('api.twilio.status-changed');
        $client = new Client($account_sid, $auth_token);
        if ($request->phone == '2771340045') {
            $phone = '+27713400456';
        } else {
            $phone = '+1' . $request->phone;
        }

        $bodyTxt = "Your verification code is: " . $verificationCode;
        $apiResponse = $client->messages->create(
            $phone, // to
            [
                "body" => $bodyTxt,
                "from" => $twilio_number
            ]
        );


        if ($coupon !== null) {
            // Subscribe new user to customer
            $forCustomer = CustomerDetail::where('user_id', $customerUserId)->first();

            $subscription = new UserSubscription();
            $subscription->user_id = $user->id;
            $subscription->customer_details_id = $forCustomer->id;
            $subscription->created_at = now();
            $subscription->save();

            // Send signup SMS and add to coupons list.
            // $result = (new ActionController)->sendCoupons([$user], $coupon->id);

            // Add to user
            $userCoupon = new CouponList();
            $userCoupon->coupon_id = $coupon->id;
            $userCoupon->user_id = $user->id;
            $userCoupon->save();
            // Send SMS
            try {
                $coupon_url = env("COUPON_URL");
                $url = $coupon_url . "/redeem/" . $coupon->id;
                $bodyTxt = 'NEW COUPON from ' . $r->name . '. Please visit: ' . $url . ' ' . $coupon->description;

                $apiResponse = $client->messages->create(
                    $phone, // to
                    [
                        "body" => $bodyTxt,
                        "from" => $twilio_number,
                        // "statusCallback" => $bin_url
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

            return redirect()->route('home')->withSuccess('You have successfully registered & logged in!');
        } else {
            return view('error')->withErrors('Signup coupon not active');
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
}
