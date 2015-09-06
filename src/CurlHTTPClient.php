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
 */
class CurlHTTPClient implements HTTPClient {
	/**
	 * A reference to the cURL wrapper we're using
	 * @var Object
	 */
	private $curl;

	/**
	 * Constructs the Curl HTTP adapter
	 * @param \Communique\Curl $curl A cURL object wrapper
	 */
	public function __construct(\Communique\Curl $curl = null){
		if($curl){
			$this->curl = $curl;
		} else {
			//@codeCoverageIgnoreStart
			$this->curl = new \Communique\Curl();
			//@codeCoverageIgnoreEnd
		}
	}

	/**
	 * Make an HTTP request
	 * @param  \Communique\RESTClientRequest  $request  Request object
	 * @return \Communique\RESTClientResponse $response Response object
	 */
	public function request(\Communique\RESTClientRequest $request) {
		$this->curl->set_opt_array(array(
			CURLOPT_URL => $request->url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => true
		));

		//Set the cURL user agent
		$this->curl->set_opt(CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

		switch($request->method){
			case 'POST':
			break;

			case 'PUT':
			break;

			case 'DELETE':
			break;

			default:
			case 'GET':

			break;
		}

	}
}