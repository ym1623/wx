<?php

/*
    File: index.php
    Author: felix021@gmail.com
    Date: 2012.11.29
    Usage: 公众平台的请求入口 + 示例(验证+消息)
 */

define("DEBUG", true);
define("TOKEN", "ym1623");

require_once(dirname(__FILE__) . "/wechat.php");

$w = new Wechat(TOKEN, DEBUG);

//首次验证，验证过以后可以删掉
if (isset($_GET['echostr'])) {
    $w->valid();
    exit();
}

//回复用户
$w->reply("reply_cb");

//后续必要的处理...
/* TODO */
exit();

function reply_cb($request, $w)
{
    if ($w->get_msg_type() == "location") {
        return sprintf("你的位置：(%s, %s), 地址：%s",
                $request['Location_X'], $request['Location_Y'], $request['Label']);
    }
    else if ($w->get_msg_type() == "image") { //echo back url
        $PicUrl = $request['PicUrl'];
        return "图片url：" . $PicUrl;
    }
    //else: Text

    $content = trim($request['Content']);
    if ($content === "Hello2BizUser") { //貌似第一次加入会发送这个
        return "你好!";
    }

    if ($content !== "url") //发纯文本
    {
        //$w->set_funcflag(); //如果有必要的话，加星标，方便在web处理
        if(!empty($content))
            return "回复: " . $content;
        else
            return "请说点什么...";
    }
    else //发图文消息
    {
        //* 单个图文
        return array(
            "title" =>  "hello",
            "description" =>  "world",
            "pic" =>  "http://www.felix021.com/mm/pic/x.jpg",
            "url" =>  "http://www.felix021.com/mm/test.php",
        );
        // */
        /* 多个图文，并加星标
        $w->set_funcflag();
        return array(
            array(
                "title" =>  "a1",
                "description" =>  "a1",
                "pic" =>  "http://www.felix021.com/mm/pic/x.jpg",
                "url" =>  "http://www.felix021.com/mm/test.php",
            ),
            array(
                "title" =>  "a2",
                "description" =>  "a2",
                "pic" =>  "http://www.felix021.com/mm/pic/fm.jpg",
                "url" =>  "http://www.felix021.com/mm/test.php",
            ),
        );
        // */
    }
}

?>
