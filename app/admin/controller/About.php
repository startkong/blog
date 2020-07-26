<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\admin\Controller;
use think\admin\service\SystemService;

/**
 * 系统参数配置
 * Class About
 * @package app\admin\controller
 */
class About extends Controller
{
    /**
     * 系统参数配置
     * @auth true
     * @menu true
     */
    public function index()
    {
        $this->title = '系统参数配置';
        $this->_applyFormToken();
        if ($this->request->isGet()) {
            $this->title = '修改系统参数';
            $this->fetch();
        } else {
            if ($xpath = $this->request->post('xpath')) {
                if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]+$/', $xpath)) {
                    $this->error('后台入口名称需要是由英文字母开头！');
                }
                if ($xpath !== 'admin' && file_exists($this->app->getBasePath() . $xpath)) {
                    $this->error("后台入口名称{$xpath}已经存在应用！");
                }
                SystemService::instance()->setRuntime([$xpath => 'admin']);
            }
            foreach ($this->request->post() as $name => $value) sysconf($name, $value);
            $this->success('修改系统参数成功！');
        }

        $this->fetch();
    }

    /**
     * 修改系统参数
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function system()
    {
        $this->_applyFormToken();
        if ($this->request->isGet()) {
            $this->title = '修改系统参数';
            $this->fetch();
        } else {
            if ($xpath = $this->request->post('xpath')) {
                if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]+$/', $xpath)) {
                    $this->error('后台入口名称需要是由英文字母开头！');
                }
                if ($xpath !== 'admin' && file_exists($this->app->getBasePath() . $xpath)) {
                    $this->error("后台入口名称{$xpath}已经存在应用！");
                }
                SystemService::instance()->setRuntime([$xpath => 'admin']);
            }
            foreach ($this->request->post() as $name => $value) sysconf($name, $value);
            $this->success('修改系统参数成功！', sysuri("{$xpath}/index/index") . '#' . url("{$xpath}/config/index"));
        }
    }

    /**
     * 修改文件存储
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function storage()
    {
        $this->_applyFormToken();
        if ($this->request->isGet()) {
            $this->type = input('type', 'local');
            $this->fetch("storage-{$this->type}");
        } else {
            $post = $this->request->post();
            if (!empty($post['storage']['allow_exts'])) {
                $exts = array_unique(explode(',', strtolower($post['storage']['allow_exts'])));
                if (sort($exts) && in_array('php', $exts)) $this->error('禁止上传可执行的文件！');
                $post['storage']['allow_exts'] = join(',', $exts);
            }
            foreach ($post as $name => $value) sysconf($name, $value);
            $this->success('修改文件存储成功！');
        }
    }

}
