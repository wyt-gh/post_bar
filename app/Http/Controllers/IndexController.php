<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    //
    public function index() {
        $data = array();
        $Redis = new Redis();

        //redis字符串类型
        Redis::set('haha','hell1o');
        $data['字符串'] = Redis::get('haha');

        //redis哈希类型
        Redis::hmset('gird:haird', [1 => 'white', 2 => 'black']);
        $data['哈希'] = Redis::hgetall('gird:haird');

        //redis链表
        Redis::lTrim('list1', -1, 0);
        Redis::lTrim('list2', -1, 0);
        //栈-先进后出
        Redis::lpush('list1', 'zhangsan');
        Redis::lpush('list1', 'lisi');
        Redis::lpush('list1', 'wangwu');
        //队列-先进先出
        Redis::rpush('list2', 'zhangsan');
        Redis::rpush('list2', 'lisi');
        Redis::rpush('list2', 'wangwu');
        $data['链表-栈'] = Redis::lrange('list1', 0, -1);
        $data['链表-队列'] = Redis::lrange('list2', 0, -1);
        //pop弹出栈和队列元素
        $data['链表-栈-pop'] = Redis::lpop('list1');
        $data['链表-队列-pop'] = Redis::lpop('list2');

        //redis无序集合
        Redis::sadd('arr3', ['老虎', '狮子', '大象']);
        Redis::sadd('arr4', ['牛', '狮子', '亚洲']);
        $data['无序-arr3'] = Redis::smembers('arr3');
        $data['无序-arr4'] = Redis::smembers('arr4');
        $data['无序-并集'] = Redis::sunion('arr3', 'arr4');
        $data['无序-交集'] = Redis::sinter('arr3', 'arr4');
        $data['无序-arr3差集arr4'] = Redis::sdiff('arr3', 'arr4');
        $data['无序-arr4差集arr3'] = Redis::sdiff('arr4', 'arr3');

        //redis有序集合
        Redis::zadd('jihe', 15, '15号');
        Redis::zadd('jihe', 2, '2号');
        Redis::zadd('jihe', 151, '151号');
        $data['有序-zrange'] = Redis::zrange('jihe', 0, -1); //顺序
        $data['有序-zrevrange'] = Redis::zrevrange('jihe', 0, -1); //倒序

        $data = var_export($data, true);
        dd($data);
    }

    public function indexGet() {
        $data = Redis::get('haha');
        echo $data;
    }
}
