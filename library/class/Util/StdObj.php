<?php

/**
 * Create by zzr
 * Class Util_StdObj
 */
Class Util_StdObj
{
    /**
     * 将对象数据转成纯数组
     *
     * @param $stdobj
     * @return array
     */
    public static function stdObj2Array($stdobj)
    {
        if (is_object($stdobj)) {
            $stdobj = (array)$stdobj;
        }
        if (is_array($stdobj)) {
            foreach ($stdobj as $key => $value) {
                $stdobj[$key] = self::stdObj2Array($value);
            }
        }
        return $stdobj;
    }


}