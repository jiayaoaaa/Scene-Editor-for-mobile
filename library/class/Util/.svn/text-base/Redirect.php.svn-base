<?php

/**
 * Create by zzr
 * Class Util_StdObj
 */
Class Util_Redirect
{
    const defaultUrl = '';


    /**
     * 跳转方法
     *
     * @param $url
     */
    public static function redirect($url = '')
    {
        $userInfo = Sp_Admin_User::getUser();
        $adminUserModel = new Sp_Admin_User();
        $default = $adminUserModel->adminuser_getAdminDefault($userInfo['id']);

        if ($url) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /" . $url);
            exit();
        }

        if (is_array($default) && count($default) > 0) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: /" . $default['url']);
            exit();
        }

        header("HTTP/1.1 301 Moved Permanently");
        header("Location: /" . self::defaultUrl);
        exit();
    }


}