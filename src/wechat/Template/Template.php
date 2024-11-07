<?php
// +----------------------------------------------------------------------
// | A3Mall
// +----------------------------------------------------------------------
// | Copyright (c) 2020 http://www.a3-mall.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xzncit <158373108@qq.com>
// +----------------------------------------------------------------------
namespace xzncit\wechat\Template;

use xzncit\core\App;
use xzncit\core\http\HttpClient;

class Template extends App {

    /**
     * 设置所属行业
     * 设置行业可在微信公众平台后台完成，每月可修改行业1次，账号仅可使用所属行业中相关的模板，为方便第三方开发者，提供通过接口调用的方式来修改账号所属行业
     * @param $industry_id1 公众号模板消息所属行业编号
     * @param $industry_id2 公众号模板消息所属行业编号
     * @return array
     * @throws \Exception
     */
    public function setIndustry($industry_id1,$industry_id2){
        return HttpClient::create()->postJson("cgi-bin/template/api_set_industry?access_token=ACCESS_TOKEN",[
            "industry_id1"=>$industry_id1,
            "industry_id2"=>$industry_id2
        ])->toArray();
    }

    /**
     * 获取设置的行业信息
     * @return array
     * @throws \Exception
     */
    public function getIndustry(){
        return HttpClient::create()->postJson("cgi-bin/template/get_industry?access_token=ACCESS_TOKEN")->toArray();
    }

    /**
     * 获得模板ID
     * 从行业模板库选择模板到账号后台，获得模板ID的过程可在微信公众平台后台完成。为方便第三方开发者，提供通过接口调用的方式来获取模板ID
     * @param $template_id_short 模板库中模板的编号，有“TM**”和“OPENTMTM**”等形式,对于类目模板，为纯数字ID
     * @param $keyword_name_list 选用的类目模板的关键词,按顺序传入,如果为空，或者关键词不在模板库中，会返回40246错误码
     * @return array
     * @throws \Exception
     */
    public function addTemplate($template_id_short,$keyword_name_list){
        return HttpClient::create()->postJson("cgi-bin/template/get_industry?access_token=ACCESS_TOKEN",[
            "template_id_short"=>$template_id_short,
            "keyword_name_list"=>$keyword_name_list
        ])->toArray();
    }

    /**
     * 获取模板列表
     * 获取已添加至账号下所有模板列表，包括类目模板，可在微信公众平台后台中查看模板列表信息。为方便第三方开发者，提供通过接口调用的方式来获取账号下所有模板信息
     * @return array
     * @throws \Exception
     */
    public function getAllPrivateTemplate(){
        return HttpClient::create()->postJson("cgi-bin/template/get_all_private_template?access_token=ACCESS_TOKEN")->toArray();
    }

    /**
     * 删除模板
     * 删除模板可在微信公众平台后台完成，为方便第三方开发者，提供通过接口调用的方式来删除某账号下的模板
     * @param $template_id
     * @return array
     * @throws \Exception
     */
    public function delPrivateTemplate($template_id){
        return HttpClient::create()->postJson("cgi-bin/template/del_private_template?access_token=ACCESS_TOKEN",[
            "template_id"=>$template_id
        ])->toArray();
    }

    /**
     * 发送模板消息
     * 注意: URL置空，则在发送后，点击模版消息会进入一个空白页面（ios），或无法点击（android）。
     * @param $openid
     * @param $template_id
     * @param $url
     * @param $data
     * @param $topcolor
     * @return array
     * @throws \Exception
     */
    public function send($openid,$template_id,$url,$data,$topcolor){
        $params = [
            "touser"=>$openid,
            "template_id"=>$template_id,
            "url"=>$url,
            "topcolor"=>$topcolor,
            "data"=>$data
        ];

        return HttpClient::create()->postJson("cgi-bin/message/template/send?access_token=ACCESS_TOKEN",$params)->toArray();
    }

}