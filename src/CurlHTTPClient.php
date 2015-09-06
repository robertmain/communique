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
	 * @throws \Communique\CommuniqueRESTConnectionException This is thrown if cURL is unable to connect (this could be because the server is not available or the DNS record is not resolvable)
	 * @throws \Communique\CommuniqueRESTSSLException REST SSL exception. This is thrown for things such as SSL certificate errors or SSL handshake errors.
	 */
	public function request(\Communique\RESTClientRequest $request) {
		$headers = array();
		foreach($request->headers as $header_key => $header_value){
			$headers[] = $header_key . ': ' . $header_value;
		}

		$this->curl->setopt_array(array(
			CURLOPT_URL => $request->url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => true,
			CURLOPT_HTTPHEADER => $headers
		));

		$this->curl->setopt(CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

		switch($request->method){
			case 'POST':
				$this->curl->setopt_array(
					array(
						CURLOPT_POST => true,
						CURLOPT_POSTFIELDS => $request->payload
					)
				);
			break;

			case 'PUT':
				$this->curl->setopt_array(
					array(
						CURLOPT_PUT => true,
						CURLOPT_POSTFIELDS => $request->payload
					)
				);
			break;

			case 'DELETE':
				if($payload = http_build_query($request->payload)){
					$payload = '?' . $payload;
				} else {
					$payload = '';
				}
				$this->curl->setopt_array(
					array(
						CURLOPT_CUSTOMREQUEST => 'DELETE',
						CURLOPT_URL => $request->url . $payload
					)
				);
			break;

			default:
			case 'GET':
				if($payload = http_build_query($request->payload)){
					$payload = '?' . $payload;
				} else {
					$payload = '';
				}
				$this->curl->setopt_array(
					array(
						CURLOPT_HTTPGET => true,
						CURLOPT_URL => $request->url . $payload
					)
				);
			break;
		}
		
		$raw_response = $this->curl->exec();

		if(!$raw_response){
			switch($this->curl->errno()){
				case CURLE_SSL_PEER_CERTIFICATE:
				case CURLE_SSL_ENGINE_NOTFOUND:
				case CURLE_SSL_ENGINE_SETFAILED:
				case CURLE_SSL_CERTPROBLEM:
				case CURLE_SSL_CIPHER:
				case CURLE_SSL_CACERT:
				case CURLE_SSL_CONNECT_ERROR:
					throw new \Communique\CommuniqueRESTSSLConnectionException('cURL SSL Error: ' . $this->curl->error() . ' cURL Error Code: ' . $this->curl->errno());
				break;

				case CURLE_UNSUPPORTED_PROTOCOL:
				case CURLE_COULDNT_CONNECT:
				case CURLE_COULDNT_RESOLVE_HOST:
					throw new \Communique\CommuniqueRESTConnectionException('cURL Error: ' . $this->curl->error() . ' cURL Error Code: ' . $this->curl->errno());
				break;

				default:
					throw new \Communique\CommuniqueRESTException('cURL Error: ' . $this->curl->error() . ' cURL Error Code: ' . $this->curl->errno());
				break;
			}
		} else {
			return new \Communique\RESTClientResponse(
				$raw_response['http_status_code'],
				$raw_response['body'],
				$raw_response['headers']
			);
		}
	}
}