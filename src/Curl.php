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
 * @codeCoverageIgnore This file is ignored by PHPUnit code coverage
 */

class Curl{

	/**
	 * Constructs the cURL object wrapper
	 * @throws \ErrorException
	 */
	public function __construct(){
		if(!extension_loaded('curl')){
			throw new \ErrorException('cURL is not currently installed');
		}
	}

	/**
	 * Copy a cURL handle along with all of it's preferences
	 * @see  http://php.net/manual/en/function.curl-copy-handle.php Official PHP documentation for curl_copy_handle
	 * @param  resource $ch A cURL handle returned by curl_init()
	 * @return resource     Returns a new cURL handle.
	 */
	public function copy_handle($ch){
		return curl_copy_handle($ch);
	}

	/**
	 * Return the last error number
	 * @see  http://php.net/manual/en/function.curl-errno.php Official PHP documentation for curl_errno
	 * @param  resource $ch A cURL handle returned by curl_init()
	 * @return resource     Returns the error number or 0 (zero) if no error ocurred.
	 */
	public function errno($ch){
		return curl_errno($ch);
	}

	/**
	 * Return a a string containing the last error for the current session
	 * @see  http://php.net/manual/en/function.curl-error.php Official PHP documentation for curl_error
	 * @param  resource $ch A cURL handle returned by curl_init()
	 * @return resource     Returns the error message or "" (the empty string) if no error ocurred
	 */
	public function error($ch){
		return curl_error($ch);
	}

	/**
	 * URL encodes the given string
	 * @see http://php.net/manual/en/function.curl-escape.php Official PHP documentation for curl_escape
	 * @param  resource $ch  A cURL handle returned by curl_init()
	 * @param  string $str The string to be encoded
	 * @return string|boolean      Returns escaped string or **FALSE** on failiure
	 */
	public function escape($ch, $str){
		return curl_escape($ch, $str);
	}

	/**
	 * This function should be called after initializing a cURL session and all the options for the session are set
	 * @see http://php.net/manual/en/function.curl-exec.php Official PHP documentation for curl_exec
	 * @param  resource $ch A cURL handle returned by curl_init()
	 * @return boolean|mixed     Returns **TRUE** on success or **FALSE** on failiure. However, if the **CURLOPT_RETURNTANSFER** option is set, it will return the result on success, **FALSE** on failiure	 */
	public function exec($ch){
		return curl_exect($ch);
	}

	/**
	 * Create a CURLFile object
	 * @see  http://php.net/manual/en/function.curl-file-create.php Official PHP documentation for curl_file_create
	 * @param  string $filename Path to the file which will be uploaded
	 * @param  string $mimetype Mimetype of the file
	 * @param  string $postname Name of the file to be used in the upload data
	 * @return \CURLFile           Returns a CURLFile object
	 */
	public function file_create($filename, $mimetype = '', $postname = ''){
		return curl_file_create($filename, $mimetype, $postname);
	}

	/**
	 * Get information regarding a specific transfer
	 * @see  http://php.net/manual/en/function.curl-getinfo.php Official PHP documentation for curl_getinfo
	 * @param  resource  $ch  A cURL handle returned by curl_init()
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
	public function getinfo($ch, $opt = 0){
		return curl_getinfo($ch, $opt);
	}

	/**
	 * Initialize a cURL session
	 * @see  http://php.net/manual/en/function.curl-init.php Official PHP documentation for curl_init
	 * @param  string $url If provided, the **CURLOPT_URL** option will be set to its value. You can manually set this using the setopt method
	 * @return resource|boolean 	Returns a cURL handle on success, **FALSE** on errors.
	 */
	public function init($url = null){
		return curl_init($url);
	}

	/**
	 * Add a normal cURL handle to a cURL mutli handle
	 * @see  http://php.net/manual/en/function.curl-multi-add-handle.php Official PHP documentation for curl_multi_add_handle
	 * @param  resource $mh a cURL multi handle returned by multi_init()
	 * @param  resource $ch A cURL handle returned by init()
	 * @return int     Returns 0 on success, or one of the **CURLM_XX** error codes.
	 */
	public function multi_add_handle($mh, $ch){
		return curl_multi_add_handle($mh, $ch);
	}

	/**
	 * Close a set of cURL handles
	 * @see  http://php.net/manual/en/function.curl-multi-close.php Official PHP documentation for curl_multi_close
	 * @param  resource $mh A cURL multi handle returned by init_multi()
	 * @return void     No value is returned
	 */
	public function multi_close($mh){
		curl_multi_close($mh);
	}

	/**
	 * Run Run the sub-connections of the current cURL handle
	 * @see  http://php.net/manual/en/function.curl-multi-exec.php Official PHP documentation for curl_multi_exec()
	 * @param  resource $mh A cURL handle returned by multi_init()
	 * @param  int &$still_running A reference to a flag to tell whether the operations are still running
	 * @return int 	A cURL code defined in the cURL [Predefined Constants](http://php.net/manual/en/curl.constants.php).
	 */
	public function multi_exec($mh, &$still_running){
		return curl_multi_exec($mh, &$still_running);
	}

	/**
	 * Return the content of a cURL handle if **CURLOPT_RETURNTRANSFER** is set
	 * @see  http://php.net/manual/en/function.curl-multi-getcontent.php Official PHP documentation for curl_multi_getcontent()
	 * @param  resource $ch A cURL handle returned by init()
	 * @return mixed Return the content of a cURL handle if **CURLOPT_RETURNTRANSFER** is set.
	 */
	public function multi_getcontent($ch){
		return curl_multi_getcontent($ch);
	}

	/**
	 * Get information about the current transfers
	 * @see  http://php.net/manual/en/function.curl-multi-info-read.php Official PHP documentation for curl_multi_info_read()
	 * @param  resource $mh A cURL multi handle returned by multi_init()
	 * @param  int &$msgs_in_queue Number of messages that are still in the queue
	 * @return array|boolean On success, returns an asociative array for the message, **FALSE** on failiure.
	 */
	public function mutli_info_read($mh, &$msgs_in_queue = null){
		return curl_multi_info_read($mh, &$msgs_in_queue);
	}

	/**
	 * Returns a new cURL multi handle
	 * @see  http://php.net/manual/en/function.curl-multi-init.php Offical PHP documentation for curl_multi_init()
	 * @return resource|int Returns a cURL multi handle resource on success, **FALSE** on failiure
	 */
	public function multi_init(){
		return curl_multi_init();
	}

	/**
	 * Remove a multi handle from a set of cURL handles
	 * @see http://php.net/manual/en/function.curl-multi-remove-handle.php Offical PHP documentation for curl_multi_remove_handle()
	 * @param  resource $mh A cURL multi handle returned by multi_init()
	 * @param  resource $ch A cURL handle returned by init()
	 * @return int Returns 0 on success, or one of the **CURLM_XXX** error codes.
	 */
	public function multi_remove_handle($mh, $ch){
		return curl_multi_remove_handle($mh, $ch);
	}

	/**
	 * Wait for activity on any curl_multi connection
	 * @see http://php.net/manual/en/function.curl-multi-select.php Official PHP documentation for curl_multi_select()
	 * @param  resource $mh A cURL multi handle returned by multi_init
	 * @param  float $timeout Time, in seconds to wait for a response
	 * @return int On success, returns the number of descriptors contained in the descriptor sets. This may be 0 if there was no activity on any of the descriptors. On failure, this function will return -1 on a select failure (from the underlying select system call).
	 */
	public function multi_select($mh, $timeout){
		return curl_multi_select($mh, $timeout);
	}

	/**
	 * Set an option for the cURL multi handle
	 * @see http://php.net/manual/en/function.curl-multi-setopt.php Official PHP documentation for curl_multi_setopt()
	 * @param  resource $mh  
	 * @param  int $option One of the **CURLMOPT_\* ** constants
	 * @param  mixed $value The value to be set on $option
	 * @return bool Returns **TRUE** on success or **FALSE** on failiure
	 */
	public function multi_setopt($mh, $option, $value){
		return curl_multi_setopt($mh, $option, $value);
	}

	/**
	 * Return string describing error code
	 * @see http://php.net/manual/en/function.curl-multi-strerror.php Official PHP documentation for curl_multi_strerror()
	 * @param  int $errornum One of the [CURLM error codes](http://curl.haxx.se/libcurl/c/libcurl-errors.html)
	 * @return string  Returns error strinb for valid error code, **NULL** otherwise.
	 */
	public function multi_strerror($errornum){
		return curl_multi_strerror($errornum);
	}

	/**
	 * Pause an unpause a connection
	 * @see  http://php.net/manual/en/function.curl-pause.php Official PHP documentation for curl_pause()
	 * @param  resource $ch A cURL handle returned by init()
	 * @param  int $bitmask One of the **CURLPAUSE_* ** constants
	 * @return int Returns an error code (**CURLE_OK** for no error)
	 */
	public function pause($ch, $bitmask){
		return curl_pause($ch, $bitmask);
	}


	/**
	 * Set multiple options for a cURL transfer
	 * @see  http://php.net/manual/en/function.curl-setopt-array.php Official PHP documentation for curl_setopt_array()
	 * @param  resource $ch  A cURL handle returned by init()
	 * @param  array $options An array specifying which options to set and their values. The keys should be valid curl_setopt() constants or their integer equivalents.
	 * @return boolean Returns **TRUE** if all options were successfully set. If an option could not be successfully set, **FALSE** is immediately returned, ignoring any future options in the `$options` array.
	 */
	public function setopt_array($ch, $options){
		return curl_setopt_array($ch, $options);
	}

	/**
	 * Reset all options of a libcurl session handle
	 * @see  http://php.net/manual/en/function.curl-reset.php Official PHP documentation for curl_reset()
	 * @param  resource $ch A cURL handle returned by init()
	 * @return void  No value is returned
	 */
	public function reset($ch){
		curl_reset($ch);
	}

	/**
	 * Set an option for a cURL transfer
	 * @see  http://php.net/manual/en/function.curl-setopt.php Official PHP documentation for curl_setopt()
	 * @param  resource $ch  A cURL handle returned by init()
	 * @param  int $option The **CURLOPT_XXX**
	 * @param  mixed $value The value to be set on option
	 * @return boolean Returns **TRUE** on success or **FALSE** on failure.
	 */
	public function setopt($ch, $option, $value){
		return curl_setopt($ch, $option, $value);
	}

	/**
	 * Close a cURL share handle
	 * @see  http://php.net/manual/en/function.curl-share-close.php Official PHP documentation for curl_share_close()
	 * @param  resource $ch A cURL share handle returned by share_init()
	 * @return void No value is returned.
	 */
	public function share_close($ch){
		curl_share_close($ch);
	}

	/**
	 * Initialize a cURL share handle
	 * @see  http://php.net/manual/en/function.curl-share-init.php Official PHP documentation for curl_share_init()
	 * @return resource Returns a resource of type "cURL Share Handle".
	 */
	public function share_init(){
		return curl_share_init();
	}

	/**
	 * Set an option for a cURL share handle
	 * @see  http://php.net/manual/en/function.curl-share-setopt.php Official PHP documentation for curl_share_setopt()
	 * @param  resource $sh A cURL share handle returned by curl_share_init()
	 * @param  int $option 
	 * @param  string $value  
	 * @return boolean  Returns **TRUE** on success or **FALSE** on failure.
	 */
	public function share_setopt($sh, $option, $value){
		return curl_share_setopt($sh, $option, $value);
	}

	/**
	 * Return string describing the given error code
	 * @see  http://php.net/manual/en/function.curl-strerror.php Official PHP documentation for curl_strerror()
	 * @param  int $errornum One of the [cURL error codes](http://curl.haxx.se/libcurl/c/libcurl-errors.html) constants
	 * @return string Returns error description or NULL for invalid error code.
	 */
	public function strerror($errornum){
		return curl_strerror($errornum);
	}

	/**
	 * Decodes the given URL encoded string
	 * @see  http://php.net/manual/en/function.curl-unescape.php Official PHP documentation for curl_unescape()
	 * @param  resource $ch  A cURL handle returned by init()
	 * @param  string $str The URL encoded string to be decoded
	 * @return string Returned decoded string or **FALSE** on failiure
	 */
	public function unescape($ch, $str){
		return curl_unescape($ch, $str);
	}


	/**
	 * Gets cURL version information
	 * @see  http://php.net/manual/en/function.curl-version.php Official PHP documentation for curl_version()
	 * @param  int $age 
	 * @return array Returns an asociative array with information regarding the version of cURL in question
	 */
	public function version($age = CURLVERSION_NOW){
		return curl_version($age);
	}
}