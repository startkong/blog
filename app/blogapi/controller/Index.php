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
use think\Validate;

class Index extends BasicApi
{

    public function get_index()
    {
        $this->success('获取首页信息', [
            'index_logo_img' => 'https://file.yingshangyan.com/2.png',
            'index_header_img' => 'https://file.yingshangyan.com/1.png',
            'about_author_info' => '现在流行的设计过程注重以用户为中心。用户体验的概念从开发的最早期就开始进入整个流程，并贯穿始终。其目的就是保证（1）对用户体验有正确的预估（2）认识用户的真实期望和目的（3）在功能核心还能够以低廉成本加以修改的时候对设计进行修正（4）保证功能核心同人机界面之间的协调工作，减少BUG。 在具体的实施上，就包括了早期的focus group（焦点小组），contextual interview，和开发过程中的多次usability study（可用性实验），以及后期的user test（用户测试）。在设计--测试--修改这个反复循环的开发流程中，可用性实验为何时出离该循环提供了可量化的指标。',
            'about_author_img' => 'https://file.yingshangyan.com/3.png',
            'new_product' => [
                [
                    'id'        => 1,
                    'title'     => '名称后台配置前端极数',
                    'look_count'=> 2339,
                    'img'       => 'https://file.yingshangyan.com/WechatIMG13.png',
                ],
                [
                    'id'        => 2,
                    'title'     => '名称后台配置前端极数',
                    'look_count'=> 2339,
                    'img'       => 'https://file.yingshangyan.com/WechatIMG14.png',
                ],
                [
                    'id'        => 3,
                    'title'     => '名称后台配置前端极数',
                    'look_count'=> 2339,
                    'img'       => 'https://file.yingshangyan.com/WechatIMG15.png',
                ],
                [
                    'id'        => 4,
                    'title'     => '名称后台配置前端极数',
                    'look_count'=> 2339,
                    'img'       => 'https://file.yingshangyan.com/WechatIMG16.png',
                ],
                [
                    'id'        => 5,
                    'title'     => '名称后台配置前端极数',
                    'look_count'=> 2339,
                    'img'       => 'https://file.yingshangyan.com/WechatIMG17.png',
                ],
                [
                    'id'        => 6,
                    'title'     => '名称后台配置前端极数',
                    'look_count'=> 2339,
                    'img'       => 'https://file.yingshangyan.com/WechatIMG18.png',
                ]
            ]
        ]);
    }

    public function get_header_list()
    {
        $this->success('获取列表页信息', [
            'index_logo_img' => 'https://file.yingshangyan.com/2.png',
            'lunbo_list' => [
                'https://file.yingshangyan.com/WechatIMG19.png'
            ],
            'cate_list' => [
                [
                    'id' => 1,
                    'cat_name' => 'PC端',
                ],
                [
                    'id' => 2,
                    'cat_name' => '小程序',
                ],
                [
                    'id' => 3,
                    'cat_name' => 'APP',
                ],
                [
                    'id' => 4,
                    'cat_name' => '互动屏',
                ],
            ]
        ]);
    }

    public function get_data_list()
    {

        $this->success('获取列表页数据', [
            'sum_count' => 30,
            'cur_page' => 0,
            'page_size' => 10,
            'data_list' => [
                [
                    'id'        => 1,
                    'title'     => '名称后台配置前端极数',
                    'look_count'=> 2339,
                    'img'       => 'https://file.yingshangyan.com/WechatIMG13.png',
                ],
                [
                    'id'        => 2,
                    'title'     => '名称后台配置前端极数',
                    'look_count'=> 2339,
                    'img'       => 'https://file.yingshangyan.com/WechatIMG14.png',
                ],
                [
                    'id'        => 3,
                    'title'     => '名称后台配置前端极数',
                    'look_count'=> 2339,
                    'img'       => 'https://file.yingshangyan.com/WechatIMG15.png',
                ],
                [
                    'id'        => 4,
                    'title'     => '名称后台配置前端极数',
                    'look_count'=> 2339,
                    'img'       => 'https://file.yingshangyan.com/WechatIMG16.png',
                ],
                [
                    'id'        => 5,
                    'title'     => '名称后台配置前端极数',
                    'look_count'=> 2339,
                    'img'       => 'https://file.yingshangyan.com/WechatIMG17.png',
                ],
                [
                    'id'        => 6,
                    'title'     => '名称后台配置前端极数',
                    'look_count'=> 2339,
                    'img'       => 'https://file.yingshangyan.com/WechatIMG18.png',
                ]
            ]

        ]);
    }

    public function get_detail()
    {
        $this->success('获取详情页页信息', [
            'detail_header_img' => 'https://file.yingshangyan.com/WechatIMG20.png',
            'title' => '标题标题标题标题标题标题题标题标题标题标题题标题标题标',
            'send_time' => '2020-09-18',
            'look_count' => 9876,
            'detail' => '<img scr="https://file.yingshangyan.com/WechatIMG21.png" alt="个人博客"><br/><img src="https://file.yingshangyan.com/WechatIMG22.png" alt="个人博客">'
        ]);
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
