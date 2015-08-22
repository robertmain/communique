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

/**
 * Response object
 *
 * This object is used to encapsulate the response from the API. Whilst it is used internally, it is also
 * made available to response interceptors for reading from and/or writing to.
 * 
 */
class CurlHTTPClient implements HTTPClient{

	/**
	 * Make an HTTP request
	 * @param  \Communique\RESTClientRequest  $request  Request object
	 * @return \Communique\RESTClientResponse $response Response object
	 */
	public function request(\Communique\RESTClientRequest $request){
		$curl = new Curl\Curl();
		foreach($request->headers as $headerKey => $headerValue){
			$curl->setHeader($headerKey, $headerValue);
		}
		$curl->{$request->method}($request->url);

		$curl->close();
		return new \Communique\RESTClientResponse($curl->error_code, $curl->response, $curl_response_headers);
	}
}