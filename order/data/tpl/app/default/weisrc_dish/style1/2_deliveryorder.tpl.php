<?php defined('IN_IA') or exit('Access Denied');?><html ng-app="diandanbao" class="ng-scope">
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta content="telephone=no" name="format-detection">
    <meta content="production" name="env">
    <title><?php  echo $setting['title'];?></title>
    <style type="text/css">@charset "UTF-8";[ng\:cloak],[ng-cloak],[data-ng-cloak],[x-ng-cloak],.ng-cloak,.x-ng-cloak,.ng-hide:not(.ng-hide-animate){display:none !important;}ng\:form{display:block;}</style>
    <link rel="stylesheet" href="<?php echo RES;?>/plugin/light7/light7.min.css">
    <link rel="stylesheet" type="text/css" href="<?php  echo $this->cur_mobile_path?>/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php  echo $this->cur_mobile_path?>/css/iconfont.css"/>
    <link data-turbolinks-track="true" href="<?php echo RES;?>/mobile/<?php  echo $this->cur_tpl?>/assets/diandanbao/weixin.css?v=1" media="all" rel="stylesheet">
    <script src="<?php echo RES;?>/mobile/<?php  echo $this->cur_tpl?>/assets/diandanbao/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://api.map.baidu.com/api?ak=4C0qai9sZC5KznMdt0FV4B7QlG9Nus1X&v=2.0&services=false"></script>
    <style type="text/css">@media screen{.smnoscreen {display:none}} @media print{.smnoprint{display:none}}</style>
    <style>
        .ddb-secondary-nav-header .filter-switch{
            color:#28a267;
            border: 1px solid #28a267;
        }

        .ddb-secondary-nav-header .filter-switch .filter-tab {
            border-right: 1px solid #28a267;
            display: table-cell;
            width: 1%;
            text-align: center
        }
        .ddb-secondary-nav-header .filter-switch .filter-tab.active {
            background-color: #28a267;
            color: #fff
        }
        #user-profile-page .user-nav-section .user-nav-item i{
            font-size: 16px;
        }

        .text, .filter-tab{
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="ng-scope">
    <div class="ddb-nav-header ng-scope" style="background-color: #28a267;color:#fff;">
        <div class="nav-left-item"  onclick="javascript :history.back(-1);"><i class="fa fa-angle-left"></i></div>
        <div class="header-title ng-binding">配送订单管理</div>
        <div class="nav-right-item btn-qrcode" style="padding-right: 12px;"><i class="fa fa-qrcode"></i></div>
    </div>
    <div id="user-profile-page">
        <div id="top-user-avatar">
            <div class="user-nav-section" style="background-color: #28a267;">
                <div class="user-nav-item">
                    <a href="#/wechat_share_records">
                        <i class="fa">今日配送：</i>
                        <div class="text">
                            <?php  echo $today_order_count;?>单
                        </div>
                    </a>
                </div>
                <div class="user-nav-item">
                    <a href="#/wechat_share_records">
                        <i class="fa">今日佣金：</i>
                        <div class="text"><?php  echo $today_order_price;?>元</div>
                    </a>
                </div>
                <div class="user-nav-item">
                    <a href="#/addresses">
                        <i class="fa">可提佣金：</i>
                        <div class="text">
                            <?php  echo $delivery_price;?>
                            <a href="<?php  echo $this->createMobileUrl('commission_form', array('logtype' => 2), true)?>" style="font-size: 12px;color:#ff9458;">提现</a>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php  include $this->template($this->cur_tpl.'/_nave');?>
    <div class="ddb-secondary-nav-header orders-index-secondary-nav ng-scope">
        <div class="filter-switch">
            <div class="filter-tab<?php  if($op==0) { ?> active<?php  } ?>" onclick="jump(0);">
                未配送订单
            </div>
            <div class="filter-tab<?php  if($op==1) { ?> active<?php  } ?>" onclick="jump(1);">
                我的配送
            </div>
        </div>
    </div>
    <div class="orders-index-page main-view ng-scope" id="delivery-orders-index" style="height: 100%;overflow: scroll ;overflow-y:scroll;-webkit-overflow-scrolling:touch;">
        <?php  if(is_array($order_list)) { foreach($order_list as $items) { ?>
        <div class="space-12"></div>
        <div class="order-item section ng-scope" onclick="go_detail(<?php  echo $items['id'];?>)">
            <a class="list-item">
            <div class="time ng-binding">订单号：<?php  echo $items['ordersn']?>
                时间：<?php  echo date('Y-m-d H:i:s',$items['dateline'])?></div>
            </a>
            <a class="list-item">
                <div class="name">

                    姓名:<?php  echo $items['username'];?>
                    <br>
                    电话:<?php  echo $items['tel'];?>
                    <br>
                    配送地址:<?php  echo $items['address'];?>
                    <div class="operation" style="font-size: 14px;">
                        <?php  if($items['delivery_status']==0) { ?>未配送<?php  } ?><?php  if($items['delivery_status']==1) { ?>配送中<?php  } ?><?php  if($items['delivery_status']==2) { ?>已配送<?php  } ?>,
                        <?php  if($items['ispay']==4) { ?>退款失败<?php  } ?>
                        <?php  if($items['ispay']==3) { ?>已退款<?php  } ?>
                        <?php  if($items['ispay']==2) { ?>待退款<?php  } ?>
                        <?php  if($items['ispay']==1) { ?><i class="fa fa-check-square-o"></i>已支付<?php  } ?>
                        <?php  if($items['ispay']==0) { ?>未支付<?php  } ?>
                    </div>
                </div>
                <div class="variants overflow-ellipsis" style="white-space:normal;">
                    <?php  if(is_array($items['goods'])) { foreach($items['goods'] as $goods) { ?>
                    <?php  echo $goods['title'];?><?php  echo $goods['total'];?>份；
                    <?php  } } ?>

                    <!--共计<?php  echo $items['totalnum'];?>件商品-->
                </div>
            </a>
            <div class="list-item">
                <div class="total-amount"><span class="amount-label">金额：</span>￥<?php  echo $items['totalprice'];?></div>
                <div class="operation">
                    <?php  if($items['delivery_status']==0) { ?>
                    <?php  $lbl_color = 'label-default';?>
                    <?php  $lbl_stauts = '抢单配送';?>
                    <?php  } else if($items['delivery_status']==1) { ?>
                    <?php  $lbl_color = 'label-red';?>
                    <?php  $lbl_stauts = '配送中';?>
                    <?php  } else if($items['delivery_status']==2) { ?>
                    <?php  $lbl_color = 'label-green';?>
                    <?php  $lbl_stauts = '已配送';?>
                    <?php  } ?>
                    <span class="button <?php  echo $lbl_color;?>">
                        <?php  echo $lbl_stauts;?>
                    </span>
                </div>
                <div class="space"></div>
            </div>
        </div>
        <?php  } } ?>
        <div style="height:220px;"></div>
        <script type="text/javascript">
            $(document).ready(function(){
                window.onload = distance;
                function distance() { //定位当前地址
                    var geolocation = new BMap.Geolocation();
                    geolocation.getCurrentPosition(function (r) {
                        if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                            var position = {
                                lng: r.point.lng,
                                lat: r.point.lat
                            }
                            positions(position); //当前经纬度
                        } else {
                            alert('获取当前位置失败,请确定您开启了定位服务');
                        }
                        setTimeout(distance, 5000);
                    }, {enableHighAccuracy: true});
                }
                function positions(position) {
                    var url = "<?php  echo $this->createMobileUrl('UpdateUserPoint', array(), true)?>";
                    var lng = position.lng;
                    var lat = position.lat;

                    $.ajax({
                        url: url, type: "post", dataType: "json", timeout: "10000",
                        data: {
                            "type": "add",
                            "lat":lat,
                            "lng":lng
                        },
                        success: function (data) {

                        },error: function () {

                        }
                    });
                }
            });

        </script>
    </div>
</div>
<?php  echo register_jssdk(false);?>
<script>
    $('.btn-qrcode').click(function () {
        wx.scanQRCode({
            needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
            scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
            success: function (res) {
                var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                location.href= result;
            }
        });
    });

    function jump(status) {
        window.location.href = "<?php  echo $this->createMobileUrl('deliveryorder', array(), true)?>" + "&op=" + status;
    }
    function go_detail(id) {
        window.location.href = "<?php  echo $this->createMobileUrl('deliveryorderdetail', array(), true)?>" + "&orderid=" +
                id;
    }
</script>
<script>;</script><script type="text/javascript" src="http://orderamz.oneap.net/app/index.php?i=2&c=utility&a=visit&do=showjs&m=weisrc_dish"></script></body>
</html>