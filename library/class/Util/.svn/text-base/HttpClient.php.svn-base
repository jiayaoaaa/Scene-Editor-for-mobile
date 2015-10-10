<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Util_HttpClient
 *
 *
 *
 * @package    Lib
 * @author	liut
 * @version    $Id$
 * @created    16:20 2009-07-31
 */


/**
 * Util_HttpClient
 *
 */
class Util_HttpClient
{
	// vars
	protected $headers;
	protected $user_agent;
	protected $compression;
	protected $cookie_file;
	protected $proxy;
	protected $proxy_auth;
	protected $proxy_port;
	protected $proxy_type;
	protected $timeout = 0;
	protected $connect_timeout = 0;
	protected $return_transfer = 1;
	protected $follow_location = 1;
	protected $return_array = FALSE;

	private $_ch = NULL;

	private $_err = array();

	public function __construct($cookies = FALSE, $cookie = 'cookies.txt', $compression='gzip', $proxy='')
	{
		if(is_array($cookies)) extract($cookies);
		$this->headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg, text/html, application/xhtml+xml, application/xml, */*';
		$this->headers[] = 'Connection: Keep-Alive';
		$this->headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
		//$this->user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
		$this->user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.4) Gecko/20091007 Firefox/3.5.4 (.NET CLR 3.5.30729)';
		$this->compression = $compression;
		$this->proxy = $proxy;
		isset($timeout) && $this->timeout = $timeout;
		isset($proxy_auth) && $this->proxy_auth = $proxy_auth;
		isset($proxy_port) && $this->proxy_port = $proxy_port;
		isset($proxy_type) && $this->proxy_type = $proxy_type;
		$this->cookies = $cookies;
		if ($this->cookies === TRUE) $this->setCookieFile($cookie);
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public function setOption($name, $value)
	{
		if(isset($this->$name)) $this->$name = $value;
	}


	public function setCookieFile($cookie_file)
	{
		if (file_exists($cookie_file)) {
			$this->cookie_file=$cookie_file;
		} else {
			fopen($cookie_file,'w') or $this->error('The cookie file could not be opened. Make sure this directory has the correct permissions');
			$this->cookie_file=$cookie_file;
			fclose($this->cookie_file);
		}
	}

	protected function curl_prepare($url, $option = array())
	{
		if (isset($option['return_array'])) {
			$this->return_array = $option['return_array'];
		}
		$ch = curl_init($url);
		if (isset($option['httpheader']) && is_array($option['httpheader'])) { //
			$this->headers = array_merge($this->headers, $option['httpheader']);
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		if (isset($option['referer'])) curl_setopt ($ch, CURLOPT_REFERER, $option['referer'] );
		curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
		if ($this->cookies == TRUE) curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_file);
		if ($this->cookies == TRUE) curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_file);
		curl_setopt($ch, CURLOPT_ENCODING , $this->compression);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		if ($this->proxy_port) curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxy_port);
		if ($this->proxy_type) curl_setopt($ch, CURLOPT_PROXYTYPE, $this->proxy_type);
		if ($this->proxy) curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, $this->return_transfer);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $this->follow_location);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);
		return $ch;
	}

	public function get($url, $option = array())
	{
		$ch = $this->curl_prepare($url, $option);

		$ret = curl_exec($ch);

		$errno = curl_errno($ch);
		if ($errno) {
			$this->_err = array($errno, curl_error($ch), curl_getinfo($ch));
		}

		if ($this->return_array) {
			$ret = array('code'=>curl_getinfo($ch, CURLINFO_HTTP_CODE), 'body' => $ret);
		}

		curl_close($ch);
		return $ret;
	}

	public function pget($url, $option = array())
	{
		if (is_null($this->_ch) || !is_resource($this->_ch)) {
			$headers = array('Connection: Keep-Alive', 'Keep-Alive: 300');
			isset($option['httpheader']) && $option['httpheader'] = merge($option['httpheader'], $headers) || $option['httpheader'] = $headers;
			$this->_ch = $this->curl_prepare($url, $option);
		}

		$ret = curl_exec($this->_ch);

		$errno = curl_errno($this->_ch);
		if ($errno) {
			$this->_err = array($errno, curl_error($this->_ch), curl_getinfo($this->_ch));
		}

		if ($this->return_array) {
			$ret = array('code'=>curl_getinfo($this->_ch, CURLINFO_HTTP_CODE), 'body' => $ret);
		}

		return $ret;


	}

	public function close()
	{
		if (is_resource($this->_ch)) curl_close($this->_ch);
		$this->_ch = NULL;
	}

	function __destruct()
	{
		$this->close();
	}

	public function post($url, $data, $option = array())
	{

		$ch = $this->curl_prepare($url, $option);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_POST, 1);
		$ret = curl_exec($ch);
		$errno = curl_errno($ch);
		if ($errno) {
			$this->_err = array($errno, curl_error($ch), curl_getinfo($ch));
		}
		curl_close($ch);
		return $ret;
	}

	/**
	 * function description
	 *
	 * @param string $url
	 * @param string $file
	 * @return void
	 */
	public function download($url, $file, $option = array())
	{
		$fp = fopen($file, "w");
		if (!$fp) {
			trigger_error("open file $file failed", E_USER_ERROR);
			return FALSE;
		}
		$ch = $this->curl_prepare($url, $option);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$ret = curl_exec($ch);
		$errno = curl_errno($ch);
        $return_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		$this->_err = array($errno, curl_error($ch), $return_code);
		curl_close($ch);
		if ($fp) fclose($fp);
		return $ret;
	}

	function error($error)
	{
		echo "cURL Error: \n$error";
		exit;
	}

	public function getError()
	{
		return $this->_err;
	}
}

