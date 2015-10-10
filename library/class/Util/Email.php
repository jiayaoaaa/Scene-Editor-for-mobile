<?php

/**
 * 邮件平台函数
 */
class Util_Email
{
    /**
     *  发送邮件添加邮件记录
     * @param $condition
     */
    public function sendEmailAndInsertSmsReport($condition)
    {
        $spAdminUser = new Sp_Admin_User();
        $spAdminUser->adminuser_insertSmsReport($condition);

        $this->sendEmail($condition);
    }


    public function sendEmail($condition)
    {
        if (is_array($condition)) extract($condition, EXTR_SKIP);

        $host2url = array( // 邮箱域名对应的邮箱登录地址
            'qq.com' => 'http://mail.qq.com',
            'gmail.com' => 'http://mail.google.com',
            'sina.com' => 'http://mail.sina.com.cn',
            'sina.cn' => 'http://mail.sina.com.cn',
            '163.com' => 'http://mail.163.com',
            '126.com' => 'http://mail.126.com',
            'yeah.net' => 'http://www.yeah.net/',
            'sohu.com' => 'http://mail.sohu.com/',
            'tom.com' => 'http://mail.tom.com/',
            'sogou.com' => 'http://mail.sogou.com/',
            '139.com' => 'http://mail.10086.cn/',
            'hotmail.com' => 'http://www.hotmail.com',
            'live.com' => 'http://login.live.com/',
            'live.cn' => 'http://login.live.cn/',
            'live.com.cn' => 'http://login.live.com.cn',
            '189.com' => 'http://webmail16.189.cn/webmail/',
            'yahoo.com.cn' => 'http://mail.cn.yahoo.com/',
            'yahoo.cn' => 'http://mail.cn.yahoo.com/',
            'eyou.com' => 'http://www.eyou.com/',
            '21cn.com' => 'http://mail.21cn.com/',
            '188.com' => 'http://www.188.com/',
            'foxmail.coom' => 'http://www.foxmail.com'
        );

        preg_match('/(.*)@(.*)/', $email, $email_match);
        $email_url = $host2url[$email_match[2]];


        //间隔大于10分钟
        if ($istime) {
            if (time() - $last_time > 600) {
                $do = 1;
            } else {
                $do = 0;
            }
        } else {
            $do = 1;
        }

        if ($do == 1) {
            $mail = new Util_PhpMailer();
            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->SMTPDebug = 0;
            $mail->CharSet = 'utf-8';
            $mail->Host = "smtp.exmail.qq.com";
            $mail->SMTPAuth = true;
            $mail->Port = 25;
            $mail->Username = "mail@evtown.com";
            $mail->Password = "eventown1";
            $mail->SetFrom('mail@evtown.com', '会通短信通知');
            $mail->AddAddress($email);
            $mail->Subject = $title;
            $mail->MsgHTML($content);

            if (!$mail->Send()) {
                return 0;
            } else {
                return $email_url;
            }
        } else {
            return 1;
        }
    }
}


?>   

                         