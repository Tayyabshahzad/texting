<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhoneNumberVerifyController extends Controller
{
    public function show(Request $request)
    {
        if ($request->user->userPhoneVerified()) {
            return redirect()->route('home');
        } else {
            return view('phoneverify.show');
        }
    }

    public function verify(Request $request)
    {
        if ($request->user()->verification_code !== $request->code) {
            return back()->withErrors(['msg', 'Invalid Code Please Try Again!']);
        }

        if ($request->user()->userPhoneVerified()) {
            return redirect()->route('home');
        }

        $request->user()->phoneVerifiedAt();

        return redirect()->route('home')->with('status', 'Your phone was successfully verified!');
    }

    public function buildTwiMl($code)
    {
        $code = $this->formatCode($code);
        return response("Hello, This is your verification code. {$code}.", 200);
    }

    public function formatCode($code)
    {
        $collection = collect(str_split($code));
        return $collection->reduce(
            function ($carry, $item) {
                return "{$carry}. {$item}";
            }
        );
    }
}
