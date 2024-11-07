<?php
// +----------------------------------------------------------------------
// | A3Mall
// +----------------------------------------------------------------------
// | Copyright (c) 2020 http://www.a3-mall.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xzncit <158373108@qq.com>
// +----------------------------------------------------------------------

namespace xzncit\mini\SubscribeMessage;

use xzncit\core\App;
use xzncit\core\http\HttpClient;

class SubscribeMessage extends App {

    /**
     * subscribeMessage.addTemplate
     * 组合模板并添加至帐号下的个人模板库
     * @param $tid          模板标题 id，可通过接口获取，也可登录小程序后台查看获取
     * @param $kidList      开发者自行组合好的模板关键词列表，关键词顺序可以自由搭配（例如 [3,5,4] 或 [4,5,3]），最多支持5个，最少2个关键词组合
     * @param $sceneDesc    服务场景描述，15个字以内
     * @return array
     * @throws \Exception
     */
    public function addTemplate($tid,$kidList,$sceneDesc){
        return HttpClient::create()->postJson("wxaapi/newtmpl/addtemplate?access_token=ACCESS_TOKEN",[
            "tid"=>$tid,"kidList"=>$kidList,"sceneDesc"=>$sceneDesc
        ])->toArray();
    }

    /**
     * subscribeMessage.deleteTemplate
     * 删除帐号下的个人模板
     * @param $priTmplId    要删除的模板id
     * @return array
     * @throws \Exception
     */
    public function deleteTemplate($priTmplId){
        return HttpClient::create()->postJson("wxaapi/newtmpl/deltemplate?access_token=ACCESS_TOKEN",[
            "priTmplId"=>$priTmplId
        ])->toArray();
    }

    /**
     * subscribeMessage.getCategory
     * 获取小程序账号的类目
     * @return array
     * @throws \Exception
     */
    public function getCategory(){
        return HttpClient::create()->get("wxaapi/newtmpl/getcategory?access_token=ACCESS_TOKEN")->toArray();
    }

    /**
     * subscribeMessage.getPubTemplateKeyWordsById
     * 获取模板标题下的关键词列表
     * @param $tid          模板标题 id，可通过接口获取
     * @return array
     * @throws \Exception
     */
    public function getPubTemplateKeyWordsById($tid){
        return HttpClient::create()->get("wxaapi/newtmpl/getpubtemplatekeywords?access_token=ACCESS_TOKEN",[
            "tid"=>$tid
        ])->toArray();
    }

    /**
     * subscribeMessage.getPubTemplateTitleList
     * 获取帐号所属类目下的公共模板标题
     * @param $ids          类目 id，多个用逗号隔开
     * @param $start        用于分页，表示从 start 开始。从 0 开始计数
     * @param $limit        用于分页，表示拉取 limit 条记录。最大为 30
     * @return array
     * @throws \Exception
     */
    public function getPubTemplateTitleList($ids,$start,$limit){
        return HttpClient::create()->get("wxaapi/newtmpl/getpubtemplatetitles?access_token=ACCESS_TOKEN",[
            "ids"=>$ids,"start"=>$start,"limit"=>$limit
        ])->toArray();
    }

    /**
     * subscribeMessage.getTemplateList
     * 获取当前帐号下的个人模板列表
     * @return array
     * @throws \Exception
     */
    public function getTemplateList(){
        return HttpClient::create()->get("wxaapi/newtmpl/gettemplate?access_token=ACCESS_TOKEN")->toArray();
    }

    /**
     * subscribeMessage.send
     * 发送订阅消息
     * @param $touser                   接收者（用户）的 openid
     * @param $template_id              所需下发的订阅模板id
     * @param $data                     模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
     * @param null $miniprogram_state   跳转小程序类型：developer为开发版；trial为体验版；formal为正式版；默认为正式版
     * @param null $page                点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
     * @param string $lang              进入小程序查看”的语言类型，支持zh_CN(简体中文)、en_US(英文)、zh_HK(繁体中文)、zh_TW(繁体中文)，默认为zh_CN
     * @return array
     * @throws \Exception
     */
    public function send($touser,$template_id,$data,$miniprogram_state=null,$page=null,$lang="zh_CN"){
        $array = ["touser"=>$touser,"template_id"=>$template_id,"data"=>$data];
        is_null($page) || $array["page"] = $page;
        is_null($miniprogram_state) || $array["miniprogram_state"] = $miniprogram_state;
        return HttpClient::create()->postJson("cgi-bin/message/subscribe/send?access_token=ACCESS_TOKEN",$array)->toArray();
    }

    /**
     * 激活与更新服务卡片
     * @param $openid 用户身份标识符。当使用微信支付订单号作为 code 时，需要与实际支付用户一致；当通过前端获取 code 时，需要与点击 button 的用户一致。
     * @param $notify_type 卡片id。可在文中（1.1）中查阅。
     * @param $notify_code 动态更新令牌。获取方式可在文中（1.3或1.4）中查阅。需要注意的是，微信支付订单号从生成到可被校验存在一定的时延可能，若收到报错为 notify_code 不存在，建议在1分钟后重试。
     * @param $content_json 卡片状态与状态相关字段，不同卡片的定义不同，可在文中（1.1中各模版定义链接）中查阅。
     * @param $check_json 微信支付订单号验证字段。当将微信支付订单号作为 notify_code 时，在激活时需要传入
     * @return array
     * @throws \Exception
     */
    public function setUserNotify($openid,$notify_type,$notify_code,$content_json,$check_json){
        return HttpClient::create()->postJson("wxa/set_user_notify?access_token=ACCESS_TOKEN",[
            "openid"=>$openid,
            "notify_type"=>$notify_type,
            "notify_code"=>$notify_code,
            "content_json"=>$content_json,
            "check_json"=>$check_json
        ])->toArray();
    }

    /**
     * 查询服务卡片状态
     * @param $openid 用户身份标识符
     * @param $notify_code 动态更新令牌
     * @param $notify_type 卡片id
     * @return array
     * @throws \Exception
     */
    public function getUserNotify($openid,$notify_code,$notify_type){
        return HttpClient::create()->postJson("wxa/set_user_notify?access_token=ACCESS_TOKEN",[
            "openid"=>$openid,
            "notify_code"=>$notify_code,
            "notify_type"=>$notify_type
        ])->toArray();
    }

    /**
     * 更新服务卡片扩展信息
     * @param $openid 用户身份标识符。当使用微信支付订单号作为 code 时，需要与实际支付用户一致；当通过前端获取 code 时，需要与点击 button 的用户一致。
     * @param $notify_type 卡片id。可在文中（1.1）中查阅。
     * @param $notify_code 动态更新令牌。获取方式可在文中（1.3或1.4）中查阅。需要注意的是，微信支付订单号从生成到可被校验存在一定的时延可能，若收到报错为 notify_code 不存在，建议在1分钟后重试。
     * @param $ext_json 扩展信息，不同卡片的定义不同，可在文中（1.1中各模版定义链接）中查阅。
     * @return array
     * @throws \Exception
     */
    public function setUserNotifyext($openid,$notify_type,$notify_code,$ext_json){
        return HttpClient::create()->postJson("wxa/set_user_notify?access_token=ACCESS_TOKEN",[
            "openid"=>$openid,
            "notify_type"=>$notify_type,
            "notify_code"=>$notify_code,
            "ext_json"=>$ext_json
        ])->toArray();
    }

}