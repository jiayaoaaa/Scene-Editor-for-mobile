<?PHP

/* vim: set expandtab tabstop=4 shiftwidth=4: */

// $Id$

/**
 * Request: 处理 HTTP 请求相关
 *
 */
class Request
{
    /**
     * Instance parameters
     * @var array
     */
    protected $_ini;

    /**
     * Instance parameters
     * @var array
     */
    protected $_params = array();

    /**
     * Instance parameters
     * @var array
     */
    protected $_user = null;

    /**
     * Instance parameters
     * @var array
     */
    private $_is_mobile = null;

    /**
     * Instance parameters
     * @var array
     */
    private $_is_https = null;

    /**
     * constructor
     *
     * @return void
     */
    protected function __construct($option = array())
    {
        $this->_ini = $option;
        $this->_params['CLIENT_IP'] = $this->getIp();
        $this->_params['CLIENT_AGENT'] = $this->getAgent();
        $this->_params['REQUEST_TIME'] = isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time();
        $this->_params['HTTP_REFERER'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    }

    /**
     * return current singleton self
     *
     * @return object
     */
    public static function current($option = array())
    {
        static $_current;
        if ($_current === null) $_current = new self($option);
        return $_current;
    }

    /**
     * 返回相关参数
     *
     * @param string $key
     * @return void
     */
    public function __get($key)
    {
        switch (true) {
            case array_key_exists($key, $this->_params):
                return htmlspecialchars($this->_params[$key]);
            case array_key_exists($key, $_GET):
                return $this->getOption('trim')
                    ? trim($_GET[$key])
                    : htmlspecialchars($_GET[$key]);
            case array_key_exists($key, $_POST):
                return $this->getOption('trim')
                    ? trim($_POST[$key])
                    : htmlspecialchars($_POST[$key]);
            case array_key_exists($key, $_COOKIE):
                return $_COOKIE[$key];
            case array_key_exists($key, $_SERVER):
                return $_SERVER[$key];
            case array_key_exists($key, $_ENV):
                return $_ENV[$key];
            default:
                return null;
        }
    }

    /**
     * Alias to __get
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->__get($key);
    }

    /**
     * function description
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        $key = (string)$key;

        if ((null === $value) && isset($this->_params[$key])) {
            unset($this->_params[$key]);
        } elseif (null !== $value) {
            $this->_params[$key] = $value;
        }

    }

    /**
     * Alias to __set()
     *
     * @param string $key
     * @param mixed $value
     * @return object
     */
    public function set($key, $value)
    {
        $this->__set($key, $value);
        return $this;
    }

    /**
     * setOption
     *
     * @param string $key
     * @return void
     */
    public function setOption($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->_ini[$k] = $v;
            }
        } elseif (is_string($key)) {
            $this->_ini[$key] = $value;
        }
        return $this;
    }

    /**
     * getOption
     *
     * @param string $key
     * @return void
     */
    public function getOption($key, $dft = null)
    {
        if (isset($this->_ini[$key])) return $this->_ini[$key];
        return $dft;
    }

    /**
     * 取得用户属性
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * 设置用户属性
     *
     * @param mixed $user
     * @return void
     */
    public function setUser($user)
    {
        $this->_user = $user;
        return $this;
    }

    /**
     * 是否是POST
     *
     * @return boolean
     */
    public function isPost()
    {
        return isset($_POST) && 'POST' === $_SERVER['REQUEST_METHOD'];
    }

    /**
     * 返回浏览器信息
     *
     * @return boolean
     */
    public function getAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }

    /**
     * 判断是否是旧的浏览器，如IE6
     *
     * @return boolean
     */
    public function isAncient()
    {
        $user_agent = $this->getAgent();
        if (!empty($user_agent) && preg_match("#(MSIE [1-7]\.|Firefox [1-2]\.)#i", $user_agent)) {
            return true;
        }
        return false;
    }

    /**
     * 取得访问者IP
     *
     * @return string
     */
    public function getIp()
    {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
            return $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["REMOTE_ADDR"])) {
            return $_SERVER["REMOTE_ADDR"];
        }
        return '';
    }

    /**
     * 检测并返回可以支持多个域名的cookie domain
     * 需要提交定义 COOKIE_DOMAIN_SUPPORT
     * 如： define('COOKIE_DOMAIN_SUPPORT', '.aaa.cc .bbb.cc' );
     *
     *
     * @return string
     */
    public static function genCookieDomain()
    {
        if (defined('COOKIE_DOMAIN_SUPPORT') && isset($_SERVER['HTTP_HOST'])) // 可以支持多个域名
        {
            foreach (explode(' ', COOKIE_DOMAIN_SUPPORT) as $domain) {
                $len = strlen($domain);
                if (substr($_SERVER['HTTP_HOST'], strlen($_SERVER['HTTP_HOST']) - $len) == $domain) {
                    return $domain;
                    break;
                }
            }
        }

        return '';
    }

    /**
     * 解码被js escape或 htmlentities 编码的字符
     * 注意： js escape 编码的内容总是 UTF-8
     *
     * @param string $str
     * @param string $charset
     * @return string
     */
    public static function decode($str, $charset = 'UTF-8', $from_url = false)
    {
        $from_url && $str = urldecode($str);
        $str = preg_replace("/%u([0-9a-f]{3,4})/i", "&#x\\1;", $str);
        return html_entity_decode($str, null, $charset);
    }

    /**
     * 处理日期输入
     *
     * @param mixed $date
     * @param int $stamp
     * @return string
     */
    public static function checkDate($date, & $stamp = 0)
    {
        if (is_string($date) && $stamp = strtotime($date)) {
            return $date;
        }
        $stamp = is_int($date) ? $date : time();
        return date("Y-m-d", $stamp);
    }


    /**
     * check browser is mobile
     *
     * @return boolean
     */
    public function isMobile()
    {
        if (!is_null($this->_is_mobile)) return $this->_is_mobile;

        $ua = strtolower($this->getAgent());
        $ac = strtolower(isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '');
        $op = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE'] : '');

        $this->_is_mobile = strpos($ac, 'application/vnd.wap.xhtml+xml') !== false
            || $op != ''
            || strpos($ua, 'iphone') !== false
            || strpos($ua, 'ipad') !== false
            || strpos($ua, 'blackberry') !== false
            || strpos($ua, 'nokia') !== false
            || strpos($ua, 'sony') !== false
            || strpos($ua, 'symbian') !== false
            || strpos($ua, 'samsung') !== false
            || strpos($ua, 'mobile') !== false
            || strpos($ua, 'windows ce') !== false
            || strpos($ua, 'epoc') !== false
            || strpos($ua, 'opera mini') !== false
            || strpos($ua, 'nitro') !== false
            || strpos($ua, 'j2me') !== false
            || strpos($ua, 'midp-') !== false
            || strpos($ua, 'cldc-') !== false
            || strpos($ua, 'netfront') !== false
            || strpos($ua, 'mot') !== false
            || strpos($ua, 'up.browser') !== false
            || strpos($ua, 'up.link') !== false
            || strpos($ua, 'audiovox') !== false
            || strpos($ua, 'ericsson,') !== false
            || strpos($ua, 'panasonic') !== false
            || strpos($ua, 'philips') !== false
            || strpos($ua, 'sanyo') !== false
            || strpos($ua, 'sharp') !== false
            || strpos($ua, 'sie-') !== false
            || strpos($ua, 'portalmmm') !== false
            || strpos($ua, 'blazer') !== false
            || strpos($ua, 'avantgo') !== false
            || strpos($ua, 'danger') !== false
            || strpos($ua, 'palm') !== false
            || strpos($ua, 'series60') !== false
            || strpos($ua, 'palmsource') !== false
            || strpos($ua, 'pocketpc') !== false
            || strpos($ua, 'smartphone') !== false
            || strpos($ua, 'rover') !== false
            || strpos($ua, 'ipaq') !== false
            || strpos($ua, 'au-mic,') !== false
            || strpos($ua, 'alcatel') !== false
            || strpos($ua, 'ericy') !== false
            || strpos($ua, 'up.link') !== false
            || strpos($ua, 'vodafone/') !== false
            || strpos($ua, 'wap1.') !== false
            || strpos($ua, 'wap2.') !== false;
        return $this->_is_mobile;
    }

    /**
     * check schema is https
     *
     * @return boolean
     */
    public function isHttps()
    {
        if (!is_null($this->_is_https)) return $this->_is_https;
        $this->_is_https = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on';
        return $this->_is_https;
    }


}
