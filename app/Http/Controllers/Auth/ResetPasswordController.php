<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Exception;
use App\Models\SmsPasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function resetPasswordPhone()
    {
        return view('resetPhone');
    }

    // public function sendResetSms(Request $request)
    // {
    //     $account_sid = env("TWILIO_SID");
    //     $auth_token = env("TWILIO_TOKEN");
    //     $twilio_number = env("TWILIO_FROM");
    //     $client = new Client($account_sid, $auth_token);

    //     if ($request->phone == '27713400456') {
    //         $phone = '+' . $request->phone;
    //     } else {
    //         $phone = '+1' . $request->phone;
    //     }

    //     $token = time();

    //     $smsPass = new SmsPasswordReset();
    //     $smsPass->phone = $request->phone;
    //     $smsPass->complete = false;
    //     $smsPass->token = $token;
    //     $smsPass->created_at = now();
    //     $smsPass->save();

    //     $resetUrl = 'https://dashboard.textingdiscounts.com/reset/' . $token;
    //     $bodyTxt = 'Texting Discounts: - You have requested a password reset request, visit ' . $resetUrl;

    //     try {
    //         $apiResponse = $client->messages->create(
    //             $phone, // to
    //             [
    //                 "body" => $bodyTxt,
    //                 "from" => $twilio_number
    //             ]
    //         );

    //         $result['data'] = $apiResponse->toArray();
    //         $result['success'] = true;

    //         return response()->json(['message' => 'Success']);
    //     } catch (Exception $e) {
    //         $result['success'] = false;
    //         $result['message'] = $e->getMessage();
    //         $result['data']['error_message'] = $result['message'];

    //         return response()->json(['message' => $result['message']]);
    //     }
    // }

    public function handleReset(Request $request)
    {
        $s = SmsPasswordReset::where('token', $request->token)->first();

        if ($request->token === null || $s === null || $s->complete == 1) {
            return response()->json(['message' => 'Error']);
        } else {
            $user = User::where('phone', $s->phone)->first();

            try {
                $user->password = Hash::make($request->password);
                $user->save();

                $s->complete = 1;
                $s->save();

                return response()->json(['message' => 'Success']);
            } catch (Exception $e) {
                $result['success'] = false;
                $result['message'] = $e->getMessage();
                $result['data']['error_message'] = $result['message'];

                return response()->json(['message' => $result['message']]);
            }
        }
    }
}
