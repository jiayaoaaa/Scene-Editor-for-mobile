<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Util_Fliter, 从购买的原系统(deayou)中移过来的函数
 * 
 * @author     GuoLinLin
 * @copyright   GuoLinLin
 * @package     Core
 * @version     $Id$
 * @lastupdate $Date$
 */

class Util_Fliter
{
    public static function fliter_deayou($value) {
        if (is_array($value)) {
            foreach ($value as $_k => $_v) {
                $str[$_k] = self::fliter_deayou($_v);
            }
        } else {
            $str = self::fliter_script($value);
            $str = self::fliter_sql($str);
            $str = self::fliter_str($str);
            $str = addslashes($str);
            $str = htmlspecialchars($str);
        }
        return $str;
    }
    public function fliter_script($value)
    {
        $value = preg_replace('/(javascript:)?on(click|load|key|mouse|error|abort|move|unload|change|dblclick|move|reset|resize|submit)/i', '&111n\\2', $value);
        $value = preg_replace('/(.*?)<\\/script>/si', '', $value);
        $value = preg_replace('/(.*?)<\\/iframe>/si', '', $value);
        $value = preg_replace('//iesU', '', $value);
        return $value;
    }
    public function fliter_html($value)
    {
        if (function_exists('htmlspecialchars')) {
            return htmlspecialchars($value);
        }
        return str_replace(array('&', '"', '\'', '<', '>'), array('&', '"', '\'', '<', '>'), $value);
    }
    public function fliter_sql($value)
    {
        $sql = array('select', 'insert', '\\\'', '\\/\\*', '\\.\\.\\/', '\\.\\/', 'union', 'into', 'load_file', 'outfile');
        $sql_re = array('', '', '', '', '', '', '', '', '', '', '', '');
        return str_replace($sql, $sql_re, $value);
    }
    public function fliter_escape($value)
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = self::fliter_str($v);
            }
        } else {
            $value = self::fliter_str($value);
        }
        return $value;
    }
    public function fliter_str($value)
    {
        $badstr = array('', '%00', '
', '&', ' ', '"', '\'', '<', '>', '   ', '%3C', '%3E');
        $newstr = array('', '', '', '&', ' ', '"', '\'', '<', '>', '   ', '<', '>');
        $value = str_replace($badstr, $newstr, $value);
        $value = preg_replace('/&((#(\\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $value);
        return $value;
    }
    public function filter_dir($fileName)
    {
        $tmpname = strtolower($fileName);
        $temp = array(':/', '', '..');
        if (str_replace($temp, '', $tmpname) !== $tmpname) {
            return false;
        }
        return $fileName;
    }
    public function filter_path($path)
    {
        $path = str_replace(array('\'', '#', '=', '`', '$', '%', '&', ';'), '', $path);
        return rtrim(preg_replace('/(\\/){2,}|(\\\\){1,}/', '/', $path), '/');
    }
    public function filter_phptag($string)
    {
        return str_replace(array(''), array('<?', '?>'), $string);
    }
    public function str_out($value)
    {
        $badstr = array('<', '>', '%3C', '%3E');
        $newstr = array('<', '>', '<', '>');
        $value = str_replace($newstr, $badstr, $value);
        return stripslashes($value);
    }
}