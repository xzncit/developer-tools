<?php
// +----------------------------------------------------------------------
// | A3Mall
// +----------------------------------------------------------------------
// | Copyright (c) 2020 http://www.a3-mall.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xzncit <158373108@qq.com>
// +----------------------------------------------------------------------

namespace xzncit\mini;

use xzncit\core\Config;
use xzncit\core\Service;
use xzncit\core\exception\ConfigNotFoundException;

/**
 * class MiniProgram
 *
 * @property \xzncit\mini\OAuth\OAuth                                         $oauth
 * @property \xzncit\mini\Analysis\Analysis                                   $analysis
 * @property \xzncit\mini\Online\Online                                       $online
 * @property \xzncit\mini\PluginManager\PluginManager                         $plugin_manager
 * @property \xzncit\mini\UniformMessage\UniformMessage                       $uniform_message
 * @property \xzncit\mini\UpdatableMessage\UpdatableMessage                   $updatable_message
 * @property \xzncit\mini\NearbyPoi\NearbyPoi                                 $nearby_poi
 * @property \xzncit\mini\QRCode\QRCode                                       $qrcode
 * @property \xzncit\mini\URLScheme\URLScheme                                 $urlscheme
 * @property \xzncit\mini\Security\Security                                   $security
 * @property \xzncit\mini\CloudBase\CloudBase                                 $cloudbase
 * @property \xzncit\mini\Img\Img                                             $img
 * @property \xzncit\mini\OCR\OCR                                             $ocr
 * @property \xzncit\mini\Operation\Operation                                 $operation
 * @property \xzncit\mini\RiskControl\RiskControl                             $risk_control
 * @property \xzncit\mini\Search\Search                                       $search
 * @property \xzncit\mini\ServiceMarket\ServiceMarket                         $service_market
 * @property \xzncit\mini\Soter\Soter                                         $soter
 * @property \xzncit\mini\SubscribeMessage\SubscribeMessage                   $subscribe_message
 * @property \xzncit\mini\ImmediateDelivery\ImmediateDelivery                 $immediate_delivery
 * @property \xzncit\mini\Live\Live                                           $live
 * @property \xzncit\mini\Live\Goods\Goods                                    $goods
 * @property \xzncit\mini\Live\LivePlayer\LivePlayer                          $live_player
 * @property \xzncit\mini\Live\Role\Role                                      $role
 * @property \xzncit\mini\Live\Subscribe\Subscribe                            $subscribe
 * @property \xzncit\mini\Face\Face                                           $face
 * @property \xzncit\mini\Server\Server                                       $server
 * @property \xzncit\mini\Shipping\Shipping                                   $shipping
 * @property \xzncit\mini\Express\Express                                     $express
 */
class MiniProgram extends Service{

    /**
     * @var string[]
     */
    protected $providers = [
        "oauth"                  =>      OAuth\ProviderService::class,
        "face"                   =>      Face\ProviderService::class,
        "analysis"               =>      Analysis\ProviderService::class,
        "online"                 =>      Online\ProviderService::class,
        "plugin_manager"         =>      PluginManager\ProviderService::class,
        "uniform_message"        =>      UniformMessage\ProviderService::class,
        "updatable_message"      =>      UpdatableMessage\ProviderService::class,
        "nearby_poi"             =>      NearbyPoi\ProviderService::class,
        "qrcode"                 =>      QRCode\ProviderService::class,
        "urlscheme"              =>      URLScheme\ProviderService::class,
        "security"               =>      Security\ProviderService::class,
        "cloudbase"              =>      CloudBase\ProviderService::class,
        "img"                    =>      Img\ProviderService::class,
        "ocr"                    =>      OCR\ProviderService::class,
        "operation"              =>      Operation\ProviderService::class,
        "risk_control"           =>      RiskControl\ProviderService::class,
        "search"                 =>      Search\ProviderService::class,
        "service_market"         =>      ServiceMarket\ProviderService::class,
        "soter"                  =>      Soter\ProviderService::class,
        "subscribe_message"      =>      SubscribeMessage\ProviderService::class,
        "immediate_delivery"     =>      ImmediateDelivery\ProviderService::class,
        "live"                   =>      Live\ProviderService::class,
        "goods"                  =>      Live\Goods\ProviderService::class,
        "live_player"            =>      Live\LivePlayer\ProviderService::class,
        "role"                   =>      Live\Role\ProviderService::class,
        "subscribe"              =>      Live\Subscribe\ProviderService::class,
        "server"                 =>      server\ProviderService::class,
        "shipping"               =>      shipping\ProviderService::class,
        "express"                =>      Express\ProviderService::class
    ];

    /**
     * Wechat constructor.
     * @param array $config
     * @throws ConfigNotFoundException
     */
    public function __construct(array $config){
        if(empty($config["appid"])){
            throw new ConfigNotFoundException("Missing Config - appid",0);
        }

        if(empty($config["appsecret"])){
            throw new ConfigNotFoundException("Missing Config - appsecret",0);
        }

        parent::__construct($config);
        Config::set($config);
    }

}