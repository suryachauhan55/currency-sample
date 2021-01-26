<?php

namespace Sample\Src\Http\Controllers;

use Illuminate\Http\Request;


class MainController extends Controller {
	public function getCurrencyList(Request $request) {
		$url = 'https://api.exchangeratesapi.io/latest?base=INR';
		$data = $this->getCurlData($url);
		dd($data);
		// $data['channelinfo'] = $basicDetail;
        return $this->response($data, 'Success');
	}

	private function getCurlData($url) {
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
        return $result;
	}
}