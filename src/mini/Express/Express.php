<?php
// +----------------------------------------------------------------------
// | A3Mall
// +----------------------------------------------------------------------
// | Copyright (c) 2020 http://www.a3-mall.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xzncit <158373108@qq.com>
// +----------------------------------------------------------------------

namespace xzncit\mini\Express;

use xzncit\core\App;
use xzncit\core\http\HttpClient;

class Express extends App {

    /**
     * 获取运力id列表get_delivery_list
     * 商户使用此接口获取所有运力id的列表
     * @return array
     * @throws \Exception
     */
    public function getDeliveryList(){
        return HttpClient::create()->postJson("cgi-bin/express/delivery/open_msg/get_delivery_list?access_token=ACCESS_TOKEN")->toArray();
    }

}