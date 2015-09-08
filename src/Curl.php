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
 * cURL Class
 *
 * This class is used to provide an object wrapper around cURL
 * 
 * @codeCoverageIgnore
 */
class Curl{

	/**
	 * A cURL handle created when the object is constructed
	 * @var resource
	 */
	private $_ch = null;

	/**
	 * Constructs the cURL object wrapper
	 * @param  string $url If provided, the **CURLOPT_URL** option will be set to its value. You can manually set this using the `setopt()` method.
	 * @throws \Communique\CommuniqueRESTConnectionException
	 */
	public function __construct($url = null){
		if(!extension_loaded('curl')){
			throw new \Communique\CommuniqueRESTConnectionException('cURL Error: ' . $this->curl->error() . ' cURL Error Code: ' . $this->curl->errno());
		} else {
			$this->_ch = curl_init();
		}
	}

	/**
	 * Called when the object is garbage collected. This method basically just closes the cURL handle.
	 */
	public function __destruct(){
		if($this->_ch !== null){
			curl_close($this->_ch);
		}
	}

	/**
	 * Called when the object is copied using the `clone` operator.
	 * 
	 * Copies the current cURL handle and sets the value returned from `curl_copy_handle()` as the value of `$this->_ch` 
	 */
	public function __clone(){
		$this->_ch = curl_copy_handle($this->_ch);
	}

	/**
	 * Converts a string containing multiple headers into an array that can be used programatically.
	 * @param  string $headerContent A header string
	 * @return array An indexable array of headers
	 */
	private static function headers_to_array($headerContent){
	    $headers = array();
	    $arrRequests = explode("\r\n\r\n", $headerContent);
        foreach(explode("\r\n", $arrRequests[0]) as $i => $line){
            if($i === 0){
                $headers['http_code'] = $line;
            } else {
                list($key, $value) = explode(': ', $line);
                $headers[$key] = $value;
            }
        }
	    return $headers;
	}

	/**
	 * Gets cURL version information
	 * @see  http://php.net/manual/en/function.curl-version.php Official PHP documentation for curl_version()
	 * @param  int $age 
	 * @return array Returns an asociative array with information regarding the version of cURL in question
	 */
	public static function version($age = CURLVERSION_NOW){
		return curl_version($age);
	}

	/**
	 * Return string describing the given error code
	 * @see  http://php.net/manual/en/function.curl-strerror.php Official PHP documentation for curl_strerror()
	 * @param  int $errornum One of the [cURL error codes](http://curl.haxx.se/libcurl/c/libcurl-errors.html) constants
	 * @return string Returns error description or NULL for invalid error code.
	 */
	public static function strerror($errornum){
		return curl_strerror($errornum);
	}

	/**
	 * Create a CURLFile object
	 * @see  http://php.net/manual/en/function.curl-file-create.php Official PHP documentation for curl_file_create()
	 * @param  string $filename Path to the file which will be uploaded
	 * @param  string $mimetype Mimetype of the file
	 * @param  string $postname Name of the file to be used in the upload data
	 * @return \CURLFile           Returns a CURLFile object
	 */
	public static function file_create($filename, $mimetype = '', $postname = ''){
		return curl_file_create($filename, $mimetype, $postname);
	}

	/**
	 * Return the last error number
	 * @see  http://php.net/manual/en/function.curl-errno.php Official PHP documentation for curl_errno()
	 * @return int Returns the error number or 0 (zero) if no error ocurred.
	 */
	public function errno(){
		return curl_errno($this->_ch);
	}

	/**
	 * Return a a string containing the last error for the current session
	 * @see  http://php.net/manual/en/function.curl-error.php Official PHP documentation for curl_error()
	 * @return string Returns the error message or "" (the empty string) if no error ocurred
	 */
	public function error(){
		return curl_error($this->_ch);
	}

	/**
	 * URL encodes the given string
	 * @see http://php.net/manual/en/function.curl-escape.php Official PHP documentation for curl_escape()
	 * @param  string $str The string to be encoded
	 * @return string|boolean Returns escaped string or **FALSE** on failiure
	 */
	public function escape($str){
		return curl_escape($this->_ch, $str);
	}

	/**
	 * This function should be called after initializing a cURL session and all the options for the session are set
	 * @see http://php.net/manual/en/function.curl-exec.php Official PHP documentation for curl_exec()
	 * @return boolean|mixed     Returns **TRUE** on success or **FALSE** on failiure. However, if the **CURLOPT_RETURNTANSFER** option is set, it will return the result on success, **FALSE** on failiure	 
	 */
	public function exec(){
		if($response = curl_exec($this->_ch)){
			$header_size = $this->getinfo(CURLINFO_HEADER_SIZE);
			return array(
				'http_status_code' => $this->getinfo(CURLINFO_HTTP_CODE),
				'body' => substr($response, $header_size),
				'headers' => self::headers_to_array(substr($response, 0, $header_size))
			);
		} else {
			return false;
		}
	}

	/**
	 * Get information regarding a specific transfer
	 * @see  http://php.net/manual/en/function.curl-getinfo.php Official PHP documentation for curl_getinfo()
	 * @param  integer $opt This may be one of the following constants:
	 * 1. **CURLINFO_EFFECTIVE_URL** - Last effective URL
	 * 1. **CURLINFO_HTTP_CODE** - Last received HTTP code
	 * 1. **CURLINFO_FILETIME** - Remote time of the retrieved document, if -1 is returned the time of the document is unknown
	 * 1. **CURLINFO_TOTAL_TIME** - Total transaction time in seconds for last transfer
	 * 1. **CURLINFO_NAMELOOKUP_TIME** - Time in seconds until name resolving was complete
	 * 1. **CURLINFO_CONNECT_TIME** - Time in seconds it took to establish the connection
	 * 1. **CURLINFO_PRETRANSFER_TIME** - Time in seconds from start until just before file transfer begins
	 * 1. **CURLINFO_STARTTRANSFER_TIME** - Time in seconds until the first byte is about to be transferred
	 * 1. **CURLINFO_REDIRECT_COUNT** - Number of redirects, with the CURLOPT_FOLLOWLOCATION option enabled
	 * 1. **CURLINFO_REDIRECT_TIME** - Time in seconds of all redirection steps before final transaction was started, with the CURLOPT_FOLLOWLOCATION option enabled
	 * 1. **CURLINFO_REDIRECT_URL** - With the CURLOPT_FOLLOWLOCATION option disabled: redirect URL found in the last transaction, that should be requested manually next. With the CURLOPT_FOLLOWLOCATION option enabled: this is empty. The redirect URL in this case is available in CURLINFO_EFFECTIVE_URL
	 * 1. **CURLINFO_PRIMARY_IP** - IP address of the most recent connection
	 * 1. **CURLINFO_PRIMARY_PORT** - Destination port of the most recent connection
	 * 1. **CURLINFO_LOCAL_IP** - Local (source) IP address of the most recent connection
	 * 1. **CURLINFO_LOCAL_PORT** - Local (source) port of the most recent connection
	 * 1. **CURLINFO_SIZE_UPLOAD** - Total number of bytes uploaded
	 * 1. **CURLINFO_SIZE_DOWNLOAD** - Total number of bytes downloaded
	 * 1. **CURLINFO_SPEED_DOWNLOAD** - Average download speed
	 * 1. **CURLINFO_SPEED_UPLOAD** - Average upload speed
	 * 1. **CURLINFO_HEADER_SIZE** - Total size of all headers received
	 * 1. **CURLINFO_HEADER_OUT** - The request string sent. For this to work, add the CURLINFO_HEADER_OUT option to the handle by calling setopt()
	 * 1. **CURLINFO_REQUEST_SIZE** - Total size of issued requests, currently only for HTTP requests
	 * 1. **CURLINFO_SSL_VERIFYRESULT** - Result of SSL certification verification requested by setting CURLOPT_SSL_VERIFYPEER
	 * 1. **CURLINFO_CONTENT_LENGTH_DOWNLOAD** - content-length of download, read from Content-Length: field
	 * 1. **CURLINFO_CONTENT_LENGTH_UPLOAD** - Specified size of upload
	 * 1. **CURLINFO_CONTENT_TYPE** - Content-Type: of the requested document, NULL indicates server did not send valid Content-Type: header
	 * 1. **CURLINFO_PRIVATE** - Private data associated with this cURL handle, previously set with the CURLOPT_PRIVATE option of setopt()
	 * @return mixed|array|boolean   If **opt** is given, returns it's value. Otherwise, returns an associative array with the following elements(which correspond to **opt**), or **FALSE** on failiure:  
	 * - "url"
	 * - "content_type"
	 * - "http_code"
	 * - "header_size"
	 * - "request_size"
	 * - "filetime"
	 * - "ssl_verify_result"
	 * - "redirect_count"
	 * - "total_time"
	 * - "namelookup_time"
	 * - "connect_time"
	 * - "pretransfer_time"
	 * - "size_upload"
	 * - "size_download"
	 * - "speed_download"
	 * - "speed_upload"
	 * - "download_content_length"
	 * - "upload_content_length"
	 * - "starttransfer_time"
	 * - "redirect_time"
	 * - "certinfo"
	 * - "primary_ip"
	 * - "primary_port"
	 * - "local_ip"
	 * - "local_port"
	 * - "redirect_url"
	 * - "request_header" (This is only set if the **CURLINFO_HEADER_OUT** is set by a previous call to setopt())
	 */
	public function getinfo($opt = 0){
		return curl_getinfo($this->_ch, $opt);
	}

	/**
	 * Pause and unpause a connection
	 * @see  http://php.net/manual/en/function.curl-pause.php Official PHP documentation for curl_pause()
	 * @param  int $bitmask One of the **CURLPAUSE_\*** constants
	 * @return int Returns an error code (**CURLE_OK** for no error)
	 */
	public function pause($bitmask){
		return curl_pause($this->_ch, $bitmask);
	}


	/**
	 * Set multiple options for a cURL transfer
	 * @see  http://php.net/manual/en/function.curl-setopt-array.php Official PHP documentation for curl_setopt_array()
	 * @param  array $options An array specifying which options to set and their values. The keys should be valid curl_setopt() constants or their integer equivalents.
	 * @return boolean Returns **TRUE** if all options were successfully set. If an option could not be successfully set, **FALSE** is immediately returned, ignoring any future options in the `$options` array.
	 */
	public function setopt_array($options){
		return curl_setopt_array($this->_ch, $options);
	}

	/**
	 * Set an option for a cURL transfer
	 * @see  http://php.net/manual/en/function.curl-setopt.php Official PHP documentation for curl_setopt()
	 * @param  int $option The **CURLOPT_XXX**
	 * @param  mixed $value The value to be set on option
	 * @return boolean Returns **TRUE** on success or **FALSE** on failure.
	 */
	public function setopt($option, $value){
		return curl_setopt($this->_ch, $option, $value);
	}

	/**
	 * Decodes the given URL encoded string
	 * @see  http://php.net/manual/en/function.curl-unescape.php Official PHP documentation for curl_unescape()
	 * @param  string $str The URL encoded string to be decoded
	 * @return string Returned decoded string or **FALSE** on failiure
	 */
	public function unescape($str){
		return curl_unescape($this->_ch, $str);
	}

	/**
	 * Reset all options of a libcurl session handle
	 */
	public function reset(){
		curl_reset($this->_ch);
	}
}