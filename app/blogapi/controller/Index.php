<?php
/**
 * Created by PhpStorm.
 * User: xuheng
 * Date: 2020/7/20
 * Time: 下午11:35
 */

namespace app\blogapi\controller;



use app\blogapi\controller\api\BasicApi;
use think\Exception;
use think\facade\Db;
use think\Model;
use think\Validate;

class Index extends BasicApi
{

    public function get_index()
    {
        $config_base = array_column((array)Db::table('system_config')->where(['type' => 'base'])->select()->toArray(), 'value', 'name');


        $this->success('获取首页信息', [
            'index_logo_img'    => isset($config_base['index_logo_img'])?$config_base['index_logo_img']:'',
            'index_header_img'  => isset($config_base['index_header_img'])?$config_base['index_header_img']:'',
            'about_author_info' => isset($config_base['about_author_info'])?$config_base['about_author_info']:'',
            'about_author_img'  => isset($config_base['about_author_img'])?$config_base['about_author_img']:'',
            'new_product' => Db::table('blog_works')->field('id, title, number_sales look_count, logo img')->order('sort')->limit(6)->select()->toArray()
        ]);
    }

    public function get_header_list()
    {
        $config_base = array_column((array)Db::table('system_config')->where(['type' => 'base'])->select()->toArray(), 'value', 'name');

        $this->success('获取列表页信息', [
            'index_logo_img' => isset($config_base['index_logo_img'])?$config_base['index_logo_img']:'',
            'lunbo_list' => Db::table('blog_works_img')->where(['status' => 1])->order('sort')->column('logo'),
            'cate_list' => Db::table('blog_works_cate')->field('id, title cat_name')->where(['status' => 1, 'is_deleted' => 0])->order('sort')->select()->toArray()
        ]);
    }

    public function get_data_list()
    {
        $cat_id     = input('post.cat_id/d', 0);
        $page       = input('post.page/d', 1);
        $page_size  = input('post.page_size/d', 10);

        $this->success('获取列表页数据', [
            'sum_count' => Db::table('blog_works')->where(['cate_id' => $cat_id])->count(),
            'cur_page' => $page,
            'page_size' => $page_size,
            'data_list' => Db::table('blog_works')->field('id, title, number_sales look_count, logo img')->where(['cate_id' => $cat_id])->limit(max(0, ($page - 1) * $page_size), $page_size)->select()->toArray()
        ]);
    }

    public function get_detail()
    {

        $id = input('post.cat_id/d', 0);
        $config_base = array_column((array)Db::table('system_config')->where(['type' => 'base'])->select()->toArray(), 'value', 'name');
        $info = Db::table('blog_works')->field('id, title, send_time, number_sales, content')->where(['id' => $id])->find();
        if($info) {
            Db::table('blog_works')->where(['id' => $id])->save(['number_sales' => $info['number_sales']+1]);
        }
        $this->success('获取详情页页信息', [
                'id'            => isset($info['id'])?$info['id']:'',
                'title'         => isset($info['title'])?$info['title']:'',
                'send_time'     => isset($info['send_time'])?$info['send_time']:'',
                'look_count'    => isset($info['number_sales'])?$info['number_sales']:'',
                'detail'        => isset($info['content'])?$info['content']:'',
                'detail_header_img' => isset($config_base['detail_header_img'])?$config_base['detail_header_img']:''
            ]
        );
    }

    public function add_message()
    {
        try{
            $data = [
                'name'       => input('post.name/s', 'fds'),
                'email'      => input('post.email/s', 'fsd'),
                'master_item'=> input('post.master_item/s', 'fdsa'),
                'message'    => input('post.message/s', 'fds'),
            ];
            $vali = [
                'name'  => 'require|length:2,100',
                'email' => 'require|email',
                'master_item' => 'require|length:1,100',
                'message'    => 'require|length:1,10000',
            ];
            $vali_msg = [
                'name.require'   => '名字不能为空',
                'name.length'    => '名字只能是2-100字之间',
                'email.require'  => '邮箱不能为空',
                'email.email'   => '邮箱格式错误',
                'master_item.require'  => '主题不能为空',
                'master_item.length'   => '主题只能是1-100字之间',
                'message.require'     => '留言信息不能为空',
                'message.length'      => '留言信息只能是1-10000字之间',
            ];
            $validate = new Validate($vali, $vali_msg);
            $result = $validate->check($data);
            if(!$result) {
                throw new Exception($validate->getError());
            }
            if(!Db::table('blog_message')->insert([
                'name' => $data['name'],
                'email' => $data['email'],
                'master_item' => $data['master_item'],
                'message' => $data['message'],
                'ip' => $this->request->ip(),
            ])) {
                throw new Exception('添加数据失败');
            }


            $this->success('提交成功', []);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
