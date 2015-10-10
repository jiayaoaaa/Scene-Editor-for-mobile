<?php
/* 
 * editor by Carten 2015.7.31
 */

define('ROOT_PATH', __DIR__.'/../../');
include_once ROOT_PATH.'config/init.php';
Loader::import(WEB_ROOT . 'www/_class');

class User extends PHPUnit_Framework_TestCase  
{
    /**
     * @dataProvider additionProvider
     */
    public function testCheck($email, $mobile, $passwd,$confirm_passwd,$code,$expect)
    {
        $register = new User_Register;
        $return = $register->check($email, $mobile, $passwd,$confirm_passwd,$code,$expect);
        $this->assertEquals($expect,$return['status']);
        //$this->expectOutputString('1');
        //print "{$return['status']}";
        //$this->assertEquals($expected, $a + $b);
    }
    
    public function additionProvider(){
        //array(email,mobile,passwd,confirm_passwd,captcha,expect);
        return array(
            array('12163.com','18612848103','12345678','12345678','1234',-120),
            array('12@163.com','1861284810','12345678','12345678','123456',-121),
            array('12@163.com','18612848103','12345','12345','123456',-122),
            array('12@163.com','18612848103','ww123456789','123456','123456',-123),
            array('12@163.com','18612848103','ww123456789','ww123456789','123456',-124),
        );
    }
}

