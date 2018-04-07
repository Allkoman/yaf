<?php

/**
 * @name UserModel
 * @desc 登录注册
 * @author zhangchao
 */
class UserModel
{
    public $errNo = 0;
    public $errMsg = "";
    private $_db = null;

    public function __construct()
    {
        $this->_db = new PDO("mysql:host=localhost;dbname=imooc;", "root", "themis");
    }

    public function register($uName, $pwd)
    {
        $query = $this->_db->prepare("select count(*) as c from `user` where `name` = ? ");
        $query->execute(array($uName));
        $count = $query->fetchAll();

        if ($count[0]['c'] != 0) {
            $this->errNo = -1005;
            $this->errMsg = "用户名已存在";
            return false;
        }

        if (strlen($pwd) < 8) {
            $this->errNo = -1006;
            $this->errMsg = "密码太短，请至少设置8位的密码";
            return false;
        } else {
            $password = $this->_password_generate($pwd);
        }

        $query = $this->_db->prepare("insert into `user` (`id`, `name`, `pwd`, `reg_time`) values (null, ?, ?, ?)");
        $ret = $query->execute(array($uName, $pwd, date("Y-m-d H:i:s")));
        if (!$ret) {
            $this->errNo = -1006;
            $this->errMsg = "注册失败，写入数据失败";
            return false;
        }
        return true;
    }

    private function _password_generate($password)
    {
        $pwd = md5("salt-xxxxxxxxxx-" . $password);
        return $pwd;
    }
}
