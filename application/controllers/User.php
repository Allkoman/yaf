<?php

/**
 * @name IndexController
 * @author zhangchao
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class UserController extends Yaf_Controller_Abstract
{

    public function indexAction()
    {
        return $this->loginAction();
    }

    public function loginAction()
    {

    }

    public function registerAction()
    {
        $uName = $this->getRequest()->getPost("uName", false);
        $pwd = $this->getRequest()->getPost("pwd", false);
        if (!$uName || !$pwd) {
            echo json_encode(array("errNo" => -1002, "errMsg" => "用户名和密码必须传递"));
            return FALSE;
        }

        $model = new UserModel();
        if ($model->register(trim($uName), trim($pwd))) {
            echo json_encode(array(
                "errNo" => 0,
                "errMsg" => "",
                "data" => array("name" => $uName)
            ));
        } else {
            echo json_encode(array(
                "errNo" => $model->errNo,
                "errMsg" => $model->errMsg
            ));
        }
        return TRUE;
    }


}
