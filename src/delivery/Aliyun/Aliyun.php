<?php
// +----------------------------------------------------------------------
// | A3Mall
// +----------------------------------------------------------------------
// | Copyright (c) 2020 http://www.a3-mall.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xzncit <158373108@qq.com>
// +----------------------------------------------------------------------

namespace xzncit\delivery\Aliyun;

use xzncit\core\App;
use xzncit\core\Service;

class Aliyun extends App {

    private $host = "https://wuliu.market.alicloudapi.com"; //api访问链接
    public $errorInfo = [
        201 => "快递单号错误",
        203 => "快递公司不存在",
        204 => "快递公司识别失败",
        205 => "没有信息",
        207 => "IP限制",
        0   => "正常"
    ];

    public function __construct(Service $app){
        parent::__construct($app);
        if(empty($app->config["AppKey"])){
            throw new \Exception("参数AppKey不能为空",0);
        }else if(empty($app->config["AppSecret"])){
            throw new \Exception("参数AppSecret不能为空",0);
        }else if(empty($app->config["AppCode"])){
            throw new \Exception("参数AppCode不能为空",0);
        }
    }

    public function query($numberNo="",$type=""){
        if(empty($numberNo)){
            throw new \Exception("物流单号不能为空",0);
        }

        $headers = [];
        array_push($headers, "Authorization:APPCODE " . $this->app->config["AppCode"]);
        $querys = "no=".$numberNo;
        if(!empty($type)){
            $querys .= "&type=" . $type;
        }

        $url = $this->host . "/kdi" . "?" . $querys;
        $result = $this->get($url,$headers);
        list($header, $body) = explode("\r\n\r\n", $result["data"], 2);
        if ($result["code"] == 200) {
            $array = json_decode($body,true);
            $res = $array["result"]??[];
            return [
                "expName"=>$res["expName"], // 快递公司名称
                "expSite"=>$res["expSite"], // 快递公司官网
                "expPhone"=>$res["expPhone"], // 快递公司电话
                "courier"=>$res["courier"], // 快递员 或 快递站(没有则为空)
                "courierPhone"=>$res["courierPhone"], // 快递员电话
                "logo"=>$res["logo"], // 快递公司LOGO
                "number"=>$res["number"], // 快递单号
                "takeTime"=>$res["takeTime"], // 发货到收货消耗时长 (截止最新轨迹)
                "updateTime"=>$res["updateTime"], // 快递轨迹信息最新时间
                "status"=>$res["deliverystatus"]??0, /* 0：快递收件(揽件)1.在途中 2.正在派件 3.已签收 4.派送失败 5.疑难件 6.退件签收  */
                "issign"=>$res["issign"], // 是否签收
                "list"=>$res["list"]
            ];
        } else {
            if ($result["code"] == 400 && strpos($header, "Invalid Param Location") !== false) {
                throw new \Exception("参数错误",$result["code"]);
            } elseif ($result["code"] == 400 && strpos($header, "Invalid AppCode") !== false) {
                throw new \Exception("AppCode错误",$result["code"]);
            } elseif ($result["code"] == 400 && strpos($header, "Invalid Url") !== false) {
                throw new \Exception("请求的 Method、Path 或者环境错误",$result["code"]);
            } elseif ($result["code"] == 403 && strpos($header, "Unauthorized") !== false) {
                throw new \Exception("服务未被授权（或URL和Path不正确）",$result["code"]);
            } elseif ($result["code"] == 403 && strpos($header, "Quota Exhausted") !== false) {
                throw new \Exception("套餐包次数用完",$result["code"]);
            } elseif ($result["code"] == 500) {
                throw new \Exception("API网关错误",$result["code"]);
            } elseif ($result["code"] == 0) {
                throw new \Exception("URL错误",$result["code"]);
            } else {
                throw new \Exception("参数名错误 或 其他错误",$result["code"]);
            }
        }
    }

    public function get($url,$headers){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$" . $this->host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }

        $data = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        return [ "data"=>$data, "code"=>$httpCode ];
    }

}