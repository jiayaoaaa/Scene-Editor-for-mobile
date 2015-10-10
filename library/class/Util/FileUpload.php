<?php

/**
 * Create by zzr
 * Class FileUploadCdgn
 */
class Util_FileUpload
{
    public static function upfile($path)
    {
        $api_secret = '8g/WnRdflVZlcJN2i0ewiLT4Cvo='; /// 表单 API 功能的密匙（请访问又拍云管理后台的空间管理页面获取
        $options['bucket'] = "eventdb"; /// 空间名
        $options['expiration'] = time() + 3600; /// 授权过期时间
        $options['save-key'] = $path; /// 文件名生成格式，请参阅 API 文档
        $options['allow-file-type'] = 'jpg,jpeg,gif,png'; /// 控制文件上传的类型，可选
        $options['content-length-range'] = '0,20971520'; /// 限制文件大小，可选(K)
        $options['image-width-range'] = '1,1024000'; /// 限制图片宽度，可选
        $options['image-height-range'] = '1,1024000'; /// 限制图片高度，可选
        //$options['return-url'] = 'http://localhost/form-test/return.php'; /// 页面跳转型回调地址
        //$options['notify-url'] = 'http://a.com/form-test/notify.php'; /// 服务端异步回调地址, 请注意该地址必须公网可以正常访问/* End of file site_url.php */
        $options['policy'] = base64_encode(json_encode($options));
        return array('api_secret' => $api_secret, 'options' => $options);
    }

    /**
     * 获取图片上传秘钥
     *
     * @return mixed
     */
    public static function getUpfileKey($baseUrl)
    {
        $upfile_info = self::upfile('/' . $baseUrl . '/{year}/{mon}/{day}/{random}{.suffix}');
        $ret['policy'] = $upfile_info['options']['policy'];
        $ret['bucket'] = $upfile_info['options']['bucket'];
        $ret['sign'] = md5($upfile_info['options']['policy'] . '&' . $upfile_info['api_secret']); // 表单 API 功能的密匙（请访问又拍云管理后台的空间管理页面获取）
        return $ret;
    }

}