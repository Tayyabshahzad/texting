<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Twilio\Security\RequestValidator;

class TwilioRequestIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {

            $twilioToken = env("TWILIO_TOKEN");

            if (empty($twilioToken)) {
                throw new Exception('Token not found');
            }

            $requestValidator = new RequestValidator($twilioToken);

            $requestData = $request->toArray();

            // Switch to the body content if this is a JSON request.
            if (array_key_exists('bodySHA256', $requestData)) {
                $requestData = $request->getContent();
            }

            $isValid = $requestValidator->validate(
                $request->header('X-Twilio-Signature'),
                $request->fullUrl(),
                $requestData
            );

            if (!$isValid) {
                throw new Exception();
            }
        } catch (\Throwable $ex) {
            return new Response(['success' => false, 'message' => 'Failed Authentication'], 403);
        }

        return $next($request);
    }
}
