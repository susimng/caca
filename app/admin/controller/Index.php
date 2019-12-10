<?php
/**
 * Created by PhpStorm.
 * User: susu
 * Date: 2019-12-10
 * Time: 14:42
 */

namespace app\admin\controller;


use think\facade\View;

/**
 * 起始页
 * Class Index
 * @package app\admin\controller
 */
class Index extends BaseController
{
    /**
     * 默认首页
     * @return string
     * @throws \Exception
     */
    public function index(){
        return View::fetch('index/index');
    }

    /**
     * 控制台
     * @return string
     * @throws \Exception
     */
    public function console(){
        return View::fetch('index/console');
    }


}