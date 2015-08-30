<?php

/**
 * This file is part of Communique.
 * 
 * @author Robert Main
 * @package Communique
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Communique;

use \Curl;

/**
 * CurlHTTP Client
 *
 * This class is used internally by the main client library for performing HTTP requests using cURl. This
 * HTTP client may be swapped out for another by passing a third argument to the library constructor.
 * 
 */
class CurlHTTPClient implements HTTPClient {

	/**
	 * Make an HTTP request
	 * @param  \Communique\RESTClientRequest  $request  Request object
	 * @return \Communique\RESTClientResponse $response Response object
	 */
	public function request(\Communique\RESTClientRequest $request) {
		$curl = new \Curl\Curl();
		foreach ($request->headers as $headerKey => $headerValue) {
			$curl->setHeader($headerKey, $headerValue);
		}
		$curl->{$request->method}($request->url, $request->payload);

		if (gettype($curl->response_headers) == 'array') {
			$headers = $curl->response_headers;
		} else {
			$headers = array();
		}
		$response = new \Communique\RESTClientResponse($curl->error_code, $curl->response, $headers);
		$curl->close();
		return $response;
	}
}