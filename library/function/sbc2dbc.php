<?PHP

// $Id$


/**
 * 全角转半角 GBK 版本
 * 
 * 
 * @param string $str
 * @return string
 * 
 * 
 */
function sbc2dbcGBK($str)
{
	return preg_replace('/\xa3([\xa1-\xfe])/eu', 'chr(ord(\1)-0x80)', $str);
}

/**
 * 全角转半角 UTF-8 版本
 * 
 * 已知 ｛｝〜｜ 四个全角字符不支持
 * 如果有mbstring, 建议使用 mb_convert_kana(string, 'as')
 * 
 * @param string $str
 * @return string
 */
 function sbc2dbcUTF($str)
{
	return preg_replace_callback("#\xef\xbc([\x81-\xbe])#", create_function('$matches','return chr(ord($matches[1])-0x60);'), $str);
}

