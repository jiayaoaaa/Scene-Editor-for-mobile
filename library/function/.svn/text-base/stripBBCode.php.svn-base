<?PHP



/**
 * 清除文本中的 BBCode 标签
 * 
 * @param string $text_to_search
 * @return string
 */
function stripBBCode($text_to_search) {
	$pattern = '|[[\/\!]*?[^\[\]]*?]|si';
	$replace = '';
	return preg_replace($pattern, $replace, $text_to_search);
}
