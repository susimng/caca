<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\App;
use think\exception\ValidateException;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * 登录信息
     * @var array
     */
    protected $admin;

    /**
     * 当前控制器名称
     * @var string
     */
    protected $controller = '';

    /**
     * 当前方法名称
     * @var string
     */
    protected $action     = '';

    /**
     * 当前路由uri
     * @var string
     */
    protected $routeUri   = '';

    /**
     * 登录验证白名单
     * @var array
     */
    protected $allowAllAction = [
        'passport/login',
    ];

    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;
    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {}

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                list($validate, $scene) = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }

    /**
     * 返回封装后的API数据到客户端
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return array
     */
    protected function renderJson($code, $msg = '', $data = [])
    {
        return compact('code', 'msg', 'data');
    }

    /**
     * 返回操作成功json
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return array
     */
    protected function renderSuccess($code = 0, $msg = 'success',$data = [])
    {
        return $this->renderJson($code, $msg, $data);
    }

    /**
     * 返回操作失败json
     * @param int $code
     * @param string $msg
     * @param array $data
     * @return array
     */
    protected function renderError($code = 1, $msg = 'error', $data = [])
    {
        return $this->renderJson($code, $msg, $data);
    }


}
