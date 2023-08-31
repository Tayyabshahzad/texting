<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * Twilio statusCallBack webhook
 * is-twilio-request middleware makes sure only twilio has access to this route
 */
Route::any('/twilio/webhook/status-changed', [App\Http\Controllers\ActionController::class, 'statusChanged'])->middleware(['is-twilio-request'])->name('api.twilio.status-changed');
