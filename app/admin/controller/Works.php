<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\admin\Controller;
use think\Db;

/**
 * 作品信息管理
 * Class Goods
 * @package app\admin\controller
 */
class Works extends Controller
{
    /**
     * 指定数据表
     * @var string
     */
    protected $table = 'BlogWorks';

    /**
     * 作品信息管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '作品信息管理';
        $query = $this->_query($this->table)->equal('status,cate_id')->like('title');
        $query->where(['is_deleted' => '0'])->order('sort desc,id desc')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _index_page_filter(&$data)
    {
        $this->clist = Db::name('BlogWorksCate')->where(['is_deleted' => '0', 'status' => '1'])->select();
//        $list = Db::name('StoreGoodsList')->where('status', '1')->whereIn('goods_id', array_unique(array_column($data, 'id')))->select();
        foreach ($data as &$vo) {
            list($vo['list'], $vo['cate']) = [[], []];
//            foreach ($list as $goods) if ($goods['goods_id'] === $vo['id']) array_push($vo['list'], $goods);
            foreach ($this->clist as $cate) if ($cate['id'] === $vo['cate_id']) $vo['cate'] = $cate;
        }
    }


    /**
     * 添加作品信息
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->title = '添加作品信息';
        $this->isAddMode = '1';
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑作品信息
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->title = '编辑作品信息';
        $this->isAddMode = '0';
        $this->_form($this->table, 'form');
    }

    /**
     * 表单数据处理
     * @param array $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _form_filter(&$data)
    {
        // 生成作品ID
        if (empty($data['id'])) $data['id'] = Data::uniqidNumberCode(14);
        if ($this->request->isGet()) {
//            $fields = 'goods_spec,goods_id,status,price_market market,price_selling selling,number_virtual `virtual`,number_express express';
//            $defaultValues = Db::name('StoreGoodsList')->where(['goods_id' => $data['id']])->column($fields);
//            $this->defaultValues = json_encode($defaultValues, JSON_UNESCAPED_UNICODE);
            $this->cates = Db::name('BlogWorksCate')->where(['is_deleted' => '0', 'status' => '1'])->order('sort desc,id desc')->select();
        } elseif ($this->request->isPost()) {
            if (empty($data['logo'])) $this->error('作品LOGO不能为空，请上传图片');
            if (empty($data['image'])) $this->error('作品展示图片不能为空，请上传图片');
            Db::name('StoreGoodsList')->where(['goods_id' => $data['id']])->update(['status' => '0']);
            foreach (json_decode($data['lists'], true) as $vo) Data::save('StoreGoodsList', [
                'goods_id'       => $data['id'],
                'goods_spec'     => $vo[0]['key'],
                'price_market'   => $vo[0]['market'],
                'price_selling'  => $vo[0]['selling'],
                'number_virtual' => $vo[0]['virtual'],
                'number_express' => $vo[0]['express'],
                'status'         => $vo[0]['status'] ? 1 : 0,
            ], 'goods_spec', ['goods_id' => $data['id']]);
        }
    }

    /**
     * 表单结果处理
     * @param boolean $result
     */
    protected function _form_result($result)
    {
        if ($result && $this->request->isPost()) {
            $this->success('作品编辑成功！', 'javascript:history.back()');
        }
    }

    /**
     * 禁用作品信息
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function forbid()
    {
        $this->_save($this->table, ['status' => '0']);
    }

    /**
     * 启用作品信息
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function resume()
    {
        $this->_save($this->table, ['status' => '1']);
    }

    /**
     * 删除作品信息
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}
