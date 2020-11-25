<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::any('{prefix?}/{info?}', function(Request $request) {
	$curl = curl_init();
	$token = $request->header('Authorization');
	curl_setopt_array($curl, array(
		CURLOPT_URL => env('USER_URL') . '/' . $request->path(),
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => $request->method(),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 3000,
		CURLOPT_POSTFIELDS => $request->all(),
		CURLOPT_HTTPHEADER => [
			"Authorization: $token",
		],
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
});
