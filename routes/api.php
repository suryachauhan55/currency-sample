<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/
Route::get('/list','MainController@getCurrencyList');
Route::get('/currency-list', function (Request $request) {
	$url = 'https://api.exchangeratesapi.io/latest?base=INR';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    $output = curl_exec($ch);
    if (curl_errno($ch)) {
        return array();
    }
    curl_close($ch);
    $result = json_decode($output, true);
    
    $data = array();
    if(!empty($result['rates'])) {
    	$i=0;
	    foreach ($result['rates'] as $key => $value) {
	    	$data[$i]['name'] = $key;
	    	$data[$i]['rate'] = $value;
	    	$i++;
	    }
	}
	return response()->json($data);
});


Route::get('/currency-convert/{base}/{to}', function ($base,$to) {
	$url = "https://api.exchangeratesapi.io/latest?base=$base&symbols=$to";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    $output = curl_exec($ch);
    if (curl_errno($ch)) {
        return array();
    }
    curl_close($ch);
    $result = json_decode($output, true);
    $data = array();
    if(!empty($result['rates'])) {
	    foreach ($result['rates'] as $key => $value) {
	    	$data['name'] = $key;
	    	$data['rate'] = $value;
	    }
	}
	return response()->json($data);
});
