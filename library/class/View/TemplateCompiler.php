<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * View_TemplateCompiler
 *
 * 支持 Discuz 语法风格的模板编译器，主要改动在 template和language方法的调用
 *
 * @package    Forum
 * @author     liut
 * @copyright  =yy-inc.com=
 * @version    $Id$
 */


/**
 * View_TemplateCompiler
 *
 */

final class View_TemplateCompiler
{
	private $_root = '';

	public function __construct($root)
	{
		$this->_root = $root;
	}

	public function parse($file, $theme_id, $tpl_dir) 
	{
		global $language;

		$nest = 5;
		$tpl_file = $this->_root."$tpl_dir/$file.htm";
		$obj_file = $this->_root."forumdata/templates/{$theme_id}_$file.tpl.php";

		$template = @file_get_contents($tpl_file);
		if(!$template) {
			exit("Current template file '$tpl_dir/$file.htm' not found or have no access!");
		} elseif($language['_lang'] != 'templates' && !include $this->language('templates', $theme_id, $tpl_dir)) {
			exit("<br />Current template pack do not have a necessary language file 'templates.lang.php' or have syntax error!");
		}


		$var_regexp = "((\\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)(\[[a-zA-Z0-9_\-\.\"\'\[\]\$\x7f-\xff]+\])*)";
		$const_regexp = "([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)";

		//$template = preg_replace("/([\n\r]+)\t+/s", "\\1", $template);
		$template = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template);
		$template = preg_replace("/\{lang\s+(.+?)\}/ies", "languagevar('\\1')", $template);
		//$template = preg_replace("/\{faq\s+(.+?)\}/ies", "faqvar('\\1')", $template);
		$template = str_replace("{LF}", "<?=\"\\n\"?>", $template);

		$template = preg_replace("/\{(\\\$[a-zA-Z0-9_\[\]\'\"\$\.\x7f-\xff]+)\}/s", "<?=\\1?>", $template);
		$template = preg_replace("/$var_regexp/es", "addquote('<?=\\1?>')", $template);
		$template = preg_replace("/\<\?\=\<\?\=$var_regexp\?\>\?\>/es", "addquote('<?=\\1?>')", $template);

		$template = "<? if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>\n$template";
		$template = preg_replace("/[\n\r\t]*\{template\s+([a-z0-9_]+)\}[\n\r\t]*/is", "\n<? include \$this->template('\\1'); ?>\n", $template);
		$template = preg_replace("/[\n\r\t]*\{template\s+(.+?)\}[\n\r\t]*/is", "\n<? include \$this->template(\\1); ?>\n", $template);
		$template = preg_replace("/[\n\r\t]*\{eval\s+(.+?)\}[\n\r\t]*/ies", "stripvtags('<? \\1 ?>','')", $template);
		$template = preg_replace("/[\n\r\t]*\{echo\s+(.+?)\}[\n\r\t]*/ies", "stripvtags('<? echo \\1; ?>','')", $template);
		$template = preg_replace("/([\n\r\t]*)\{elseif\s+(.+?)\}([\n\r\t]*)/ies", "stripvtags('\\1<? } elseif(\\2) { ?>\\3','')", $template);
		$template = preg_replace("/([\n\r\t]*)\{else\}([\n\r\t]*)/is", "\\1<? } else { ?>\\2", $template);

		for($i = 0; $i < $nest; $i++) {
			$template = preg_replace("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\}[\n\r]*(.+?)[\n\r]*\{\/loop\}[\n\r\t]*/ies", "stripvtags('<? if(is_array(\\1)) { foreach(\\1 as \\2) { ?>','\\3<? } } ?>')", $template);
			$template = preg_replace("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}[\n\r\t]*(.+?)[\n\r\t]*\{\/loop\}[\n\r\t]*/ies", "stripvtags('<? if(is_array(\\1)) { foreach(\\1 as \\2 => \\3) { ?>','\\4<? } } ?>')", $template);
			$template = preg_replace("/([\n\r\t]*)\{if\s+(.+?)\}([\n\r]*)(.+?)([\n\r]*)\{\/if\}([\n\r\t]*)/ies", "stripvtags('\\1<? if(\\2) { ?>\\3','\\4\\5<? } ?>\\6')", $template);
		}

		$template = preg_replace("/\{$const_regexp\}/s", "<?=\\1?>", $template);
		$template = preg_replace("/ \?\>[\n\r]*\<\? /s", " ", $template);

		$template = preg_replace("/\"(http)?[\w\.\/:]+\?[^\"]+?&[^\"]+?\"/e", "transamp('\\0')", $template);
		$template = preg_replace("/\<script[^\>]*?src=\"(.+?)\".*?\>\s*\<\/script\>/ise", "stripscriptamp('\\1')", $template);

		$template = preg_replace("/[\n\r\t]*\{block\s+([a-zA-Z0-9_]+)\}(.+?)\{\/block\}/ies", "stripblock('\\1', '\\2')", $template);

		file_put_contents($obj_file, $template, LOCK_EX);

	}

	function language($file, $templateid = 0, $tpldir = '') {
		$tpldir = $tpldir ? $tpldir : TPLDIR;
		$templateid = $templateid ? $templateid : TEMPLATEID;

		$languagepack = $this->_root.'./'.$tpldir.'/'.$file.'.lang.php';var_dump($languagepack);
		if(file_exists($languagepack)) {
			return $languagepack;
		} elseif($templateid != 1 && $tpldir != './templates/default') {
			return language($file, 1, './templates/default');
		} else {
			return FALSE;
		}
	}


}


// 下面的方法为了兼容，先这么写，有时间再改
function transamp($str) {
	$str = str_replace('&', '&amp;', $str);
	$str = str_replace('&amp;amp;', '&amp;', $str);
	$str = str_replace('\"', '"', $str);
	return $str;
}

function addquote($var) {
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}

function stripvtags($expr, $statement) {
	$expr = str_replace("\\\"", "\"", preg_replace("/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr));
	$statement = str_replace("\\\"", "\"", $statement);
	return $expr.$statement;
}

function languagevar($var) {
	if(isset($GLOBALS['language'][$var])) {
		return $GLOBALS['language'][$var];
	} else {
		return "!$var!";
	}
}

function stripscriptamp($s) {
	$s = str_replace('&amp;', '&', $s);
	return "<script src=\"$s\" type=\"text/javascript\"></script>";
}

function stripblock($var, $s) {
	$s = str_replace('\\"', '"', $s);
	$s = preg_replace("/<\?=\\\$(.+?)\?>/", "{\$\\1}", $s);
	preg_match_all("/<\?=(.+?)\?>/e", $s, $constary);
	$constadd = '';
	$constary[1] = array_unique($constary[1]);
	foreach($constary[1] as $const) {
		$constadd .= '$__'.$const.' = '.$const.';';
	}
	$s = preg_replace("/<\?=(.+?)\?>/", "{\$__\\1}", $s);
	$s = str_replace('?>', "\n\$$var .= <<<EOF\n", $s);
	$s = str_replace('<?', "\nEOF;\n", $s);
	return "<?\n$constadd\$$var = <<<EOF\n".$s."\nEOF;\n?>";
}