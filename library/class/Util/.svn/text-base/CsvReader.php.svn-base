<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Util_CsvReader
 *
 * 按Iterator接口读取CSV格式的数据
 *
 * @package    Lib
 * @author     liut
 * @version    $Id$
 * @created    16:25 2010-09-09
 */

/**
 * Util_CsvReader
 *
 * example:
 * $it = new Util_CsvReader('goods.csv');
 * foreach($it as $k => $v) echo $k, ': ', print_r($v, true), PHP_EOL;
 */
class Util_CsvReader implements Iterator
{
	private $_fp;
	private $_pos = 0;
	private $_curr;
	private $_opt;
	private $_isUtf8 = TRUE;

	public function __construct($filename, $option = null)
	{
		if (!is_string($filename) || empty($filename)) {
			throw new InvalidArgumentException('filename must be a string');
		}
		$this->_fp = fopen($filename, "r");
		if (!$this->_fp) {
			throw new InvalidArgumentException('file open error');
		}
		$buffer = fgets($this->_fp, 1024);
		if (!mb_check_encoding($buffer, 'UTF-8')) {
			$this->_isUtf8 = FALSE;
			setlocale(LC_ALL, array('zh_CN.GBK','zh_CN.GB2312','zh_CN.GB18030')); // 设置环境参数以影响fgetcsv解析正确的编码
		} else {
			setlocale(LC_ALL, 'zh_CN.UTF-8');
		}
		unset($buffer);

		$this->rewind();

		$this->_opt = $option;
	}

	public function __destruct()
	{
		if (is_resource($this->_fp)) {
			fclose($this->_fp);
		}
	}

	public function isUtf8()
	{
		return $this->_isUtf8;
	}

	public function rewind()
	{
		rewind($this->_fp);
		$this->_pos = 0;

		$this->_curr = $this->_readLine();

	}

	public function current()
	{
		return $this->_isUtf8 ? $this->_curr : array_map(function($value){
														 return iconv('GBK', 'UTF-8', $value); // //TRANSLIT//IGNORE
														 },$this->_curr);
	}

	public function key()
	{
		return $this->_pos;
	}

	public function next()
	{
		$this->_curr = $this->_readLine();
		if ($this->_curr) {
			++ $this->_pos;
			return TRUE;
		}
		return FALSE;
	}

	public function valid()
	{
		return empty($this->_curr) ? FALSE : TRUE;
	}

	private function _readLine()
	{
		if (is_array($this->_opt)) {
			extract($this->_opt, EXTR_SKIP);
		}
		isset($length) || $length = 8192;
		isset($delimiter) || $delimiter = ',';
		isset($enclosure) || $enclosure = '"';
		isset($escape) || $escape = '\\';

		return fgetcsv($this->_fp, $length, $delimiter, $enclosure, $escape);

	}

	public static function map($filename, $callback, $option = null)
	{
		$it = new self($filename, $option);
		while ($it->valid())
		{
			$key = $it->key();
			$value = $it->current();

			if (is_callable($callback)) {
				$ret = call_user_func($callback, $key, $value);
				if (!$ret) {
					break;
				}
			}

			$it->next();
		}
		//$it->__destruct();
		unset($it);
	}
}




