Project home: http://code.google.com/p/mmsdk/
Author: felix021@gmail.com

例子见 index.php。

==== 注意 ====

1. 建议用md5创建一个TOKEN，填到公众平台

2. 公众平台中填的callback api目前(2012.11.30)仅支持80端口

==== 使用说明 ====

0. 初始化
    (1) 调试模式 $w = new Wechat(TOKEN, true);
        请求的数据会保存在当前目录的 request.txt
        回复的数据会保存在当前目录的 response.txt

    (2) 正常模式 $w = new Wechat(TOKEN);

1. 验证api的时候，调用$w->valid()

2. 处理用户请求，调用$w->valid(callback)

2.1 callback函数的参数
    (1) 数组，包含解析xml后得到的所有key, 同接口api文档，或参考后面的$req_keys
    (2) Wechat对象$w（用于分类星标）

2.2 判断请求类型： $w->get_msg_type()  //简单包装一下
    类型目前有3种: "text" "location" "image"
    详见样例.

2.3 分类为星标
    在callback函数中调用 $w->set_funcflag();

2.4 返回值（2种）
    (1) 字符串: 表示回复文本消息
          [例]
            function callback($request) {
                return "echo: " + $request['Content'];
            }
    (2) 数组: 表示回复图文消息
        每个图文消息是一个item，包含 title, description, pic, url 共4个key
        若只需要一个item，返回一个一维数组
          [例]
            return array("title" => "hello", "description" => "world",
                         "pic" => "http://host/x.jpg", "url" => "http://host/");
        若需要多个item，返回一个包含多个item的二维数组
          [例]
            return array(
                array("title" => "a1", "description" => "world",
                     "pic" => "http://host/a1.jpg", "url" => "http://host/"),
                array("title" => "a2", "description" => "world",
                     "pic" => "http://host/a2.jpg", "url" => "http://host/"),
            );

==== the end ====
