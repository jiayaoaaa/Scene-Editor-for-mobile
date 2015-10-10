<?PHP

// $Id$


/**
 * 生成邀请码
 * 
 * @param string $str
 * @return string
 */
function generate_code( $length = 6 ) {
    // 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $password = '';
    for ( $i = 0; $i < $length; $i++ ) 
    {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    }
    return $password;
 }