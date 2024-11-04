<?php
// +----------------------------------------------------------------------
// | A3Mall
// +----------------------------------------------------------------------
// | Copyright (c) 2020 http://www.a3-mall.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xzncit <158373108@qq.com>
// +----------------------------------------------------------------------

namespace xzncit\mini\Shipping;

use xzncit\core\App;
use xzncit\core\http\HttpClient;

class Shipping extends App {

    /**
     * 发货信息录入接口
     * 用户交易后，默认资金将会进入冻结状态，开发者在发货后，需要在小程序平台录入相关发货信息，平台会将发货信息以消息的形式推送给购买的微信用户。
     * 如果你已经录入发货信息，在用户尚未确认收货的情况下可以通过该接口修改发货信息，但一个支付单只能更新一次发货信息，请谨慎操作。
     * 如暂时没有完成相关API的对接开发工作，你也可以登陆小程序的后台，通过发货信息管理页面手动录入发货信息。
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function uploadShippingInfo($data=[]){
        return HttpClient::create()->postJson("wxa/sec/order/upload_shipping_info?access_token=ACCESS_TOKEN",$data)->toArray();
    }

    /**
     * 发货信息合单录入接口
     * 用户交易后，默认资金将会进入冻结状态，开发者在发货后，需要在小程序平台录入相关发货信息，平台会将发货信息以消息的形式推送给购买的微信用户。
     * 如果你已经录入发货信息，在用户尚未确认收货的情况下可以通过该接口修改发货信息，但一个支付单只能更新一次发货信息，请谨慎操作。
     * 如暂时没有完成相关API的对接开发工作，你也可以登陆小程序的后台，通过发货信息录入页面手动录入发货信息。
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function uploadCombinedShippingInfo($data=[]){
        return HttpClient::create()->postJson("wxa/sec/order/upload_combined_shipping_info?access_token=ACCESS_TOKEN",$data)->toArray();
    }

    /**
     * 查询订单发货状态
     * 你可以通过交易单号或商户号+商户单号来查询该支付单的发货状态。
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function getOrder($data=[]){
        return HttpClient::create()->postJson("wxa/sec/order/get_order?access_token=ACCESS_TOKEN",$data)->toArray();
    }

    /**
     * 查询订单列表
     * 你可以通过支付时间、支付者openid或订单状态来查询订单列表。
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function getOrderList($data=[]){
        return HttpClient::create()->postJson("wxa/sec/order/get_order_list?access_token=ACCESS_TOKEN",$data)->toArray();
    }

    /**
     * 确认收货提醒接口
     * 如你已经从你的快递物流服务方获知到用户已经签收相关商品，可以通过该接口提醒用户及时确认收货，以提高资金结算效率，每个订单仅可调用一次。
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function notifyConfirmReceive($data=[]){
        return HttpClient::create()->postJson("wxa/sec/order/notify_confirm_receive?access_token=ACCESS_TOKEN",$data)->toArray();
    }

    /**
     * 消息跳转路径设置接口
     * 如你已经在小程序内接入平台提供的确认收货组件，可以通过该接口设置发货消息及确认收货消息的跳转动作，用户点击发货消息时会直接进入你的小程序订单列表页面或详情页面进行确认收货，进一步优化用户体验。
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function setMsgJumpPath($data=[]){
        return HttpClient::create()->postJson("wxa/sec/order/set_msg_jump_path?access_token=ACCESS_TOKEN",$data)->toArray();
    }

    /**
     * 查询小程序是否已开通发货信息管理服务
     * 调用该接口可查询小程序账号是否已开通小程序发货信息管理服务（已开通的小程序，可接入发货信息管理服务API进行发货管理）。
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function isTradeManaged($data=[]){
        return HttpClient::create()->postJson("wxa/sec/order/is_trade_managed?access_token=ACCESS_TOKEN",$data)->toArray();
    }

    /**
     * 查询小程序是否已完成交易结算管理确认
     * 调用该接口可查询小程序账号是否已完成交易结算管理确认（即对小程序已关联的所有商户号都完成了订单管理授权或解绑）。已完成订单管理授权的商户号，产生的订单均需要通过发货信息管理服务进行发货。
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function isTradeManagementConfirmationCompleted($data=[]){
        return HttpClient::create()->postJson("wxa/sec/order/is_trade_management_confirmation_completed?access_token=ACCESS_TOKEN",$data)->toArray();
    }

    /**
     * 特殊发货报备
     * 调用该接口可以对未发货的订单进行特殊发货报备，适用于预售商品订单和测试订单。发货时效超过15天的订单需报备为预售商品订单，报备后用户将收到预计发货时间的通知。测试订单报备后无需发货，资金会在一段时间内自动退回给用户。
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function opspecialorder($data=[]){
        return HttpClient::create()->postJson("wxa/sec/order/opspecialorder?access_token=ACCESS_TOKEN",$data)->toArray();
    }

}