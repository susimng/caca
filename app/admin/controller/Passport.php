<?php
/**
 * Created by PhpStorm.
 * User: susu
 * Date: 2019-12-10
 * Time: 16:26
 */

namespace app\admin\controller;

use think\captcha\facade\Captcha;
use think\facade\View;

/**
 * 后台登录认证
 * Class Passport
 * @package app\admin\controller
 */
class Passport extends BaseController
{
    /**
     * 登录
     * @return string
     * @throws \Exception
     */
    public function login()
    {
        if($this->request->isAjax()){
            return $this->renderSuccess(0,'登录成功',[]);
        }
        return View::fetch('passport/login');
    }

    /**
     * 获取验证码
     * @return \think\Response
     */
    public function verify(){
        return Captcha::create();
    }






}