<?php
//----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
//use think\Route;

Route::group('api', function () {
    /**
     * @name 文件上传
     * @isshow 0
     */
    Route::group('file', function () {
        /**
         * @name 上传图片
         * @isshow 0
         */
        Route::post("pic", 'admin/File/Upfile');
        /**
         * @name 批量上传
         * @isshow 0
         */
        Route::post("databulk", "admin/File/Bulk");
        /**
         * @name 上传视频
         * @isshow 0
         */
        Route::post("video", 'admin/File/Video');
    })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
    /**
     * @menu 用户管理
     * @name 用户管理
     * @type menu
     * @isshow 1
     */
    Route::group('admin', function () {
        /**
         * @name 登录
         * @isshow 0
         */
        Route::post("login", 'admin/User/login')->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey,sessionId')->allowCrossDomain();
        /**
         * @name 添加用户
         * @prule 用户管理
         * @menu 用户管理
         * @isshow 1
         */
        Route::post("add", 'admin/User/AddOne')->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey,sessionId')->allowCrossDomain();
        /**
         * @name 修改用户
         * @prule 用户管理
         * @isshow 1
         */
        Route::post("change", 'admin/User/UpdateOne')->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey,sessionId')->allowCrossDomain();
        /**
         * @name 用户列表
         * @prule 用户管理
         * @menu 用户管理
         * @isshow 1
         */
        Route::post("getlist", 'admin/User/GetList')->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey,sessionId')->allowCrossDomain();
        /**
         * @name 获取单个用户
         * @prule 用户管理
         * @isshow 1
         */
        Route::post("getone", 'admin/User/GetOne')->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey,sessionId')->allowCrossDomain();
        /**
         * @name 删除用户
         * @menu 用户管理
         * @isshow 1
         */
        Route::post("delete", 'admin/User/DeleteOne')->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey,sessionId')->allowCrossDomain();
        /**
         * @name 退出登录
         * @isshow 0
         */
        Route::post("logout", 'admin/User/logout')->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @name 修改密码
         * @isshow 0
         */
        Route::post("uppwd", 'admin/User/UpPwd')->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @name 修改自己密码
         */
        Route::post("changeself", 'admin/User/ChangeSelf')->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @menu 垃圾管理
         * @name 垃圾分类管理
         * @type menu
         * @isshow 1
         */
        Route::group('garbage', function () {
            /**
             * @name 添加垃圾分类
             * @menu 垃圾分类管理
             */
            Route::post("add", 'admin/Garbage/AddOne');
            /**
             * @name 修改垃圾分类
             * @menu 垃圾分类管理
             */
            Route::post("change", 'admin/Garbage/UpdateOne');
            /**
             * @name 删除垃圾分类
             * @menu 垃圾分类管理
             */
            Route::post("delete", 'admin/Garbage/DeleteOne');
            /**
             * @name 获取单个垃圾分类
             * @menu 垃圾分类管理
             */
            Route::post("getone", 'admin/Garbage/GetOne');
            /**
             * @name 垃圾分类列表
             * @menu 垃圾分类管理
             */
            Route::post("getlist", 'admin/Garbage/GetList');
            /**
             * @name 所有垃圾分类
             * @menu 垃圾分类管理
             */
            Route::post("getalllist", 'admin/Garbage/GetAllList');
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @menu 垃圾管理
         * @name 垃圾报价管理
         * @type menu
         * @isshow 1
         */
        Route::group('garbageprice', function () {
            /**
             * @name 添加垃圾报价
             * @menu 垃圾报价管理
             */
            Route::post("add", 'admin/GarbagePrice/AddOne');
            /**
             * @name 修改垃圾报价
             * @menu 垃圾报价管理
             */
            Route::post("change", 'admin/GarbagePrice/UpdateOne');
            /**
             * @name 删除垃圾报价
             * @menu 垃圾报价管理
             */
            Route::post("delete", 'admin/GarbagePrice/DeleteOne');
            /**
             * @name 获得一个垃圾报价
             * @menu 垃圾报价管理
             */
            Route::post("getone", 'admin/GarbagePrice/GetOne');
            /**
             * @name 垃圾报价列表
             * @menu 垃圾报价管理
             */
            Route::post("getlist", 'admin/GarbagePrice/GetList');
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @menu 权限管理
         * @name 权限管理
         * @type menu
         * @isshow 1
         */
        Route::group('rule', function () {
            /**
             * @name 添加权限
             * @menu 权限管理
             */
            Route::post("add", 'admin/Rule/AddOne');
            /**
             * @name 修改权限
             * @menu 权限管理
             */
            Route::post("change", 'admin/Rule/UpdateOne');
            /**
             * @name 删除权限
             * @menu 权限管理
             */
            Route::post("delete", 'admin/Rule/DeleteOne');
            /**
             * @name 获得单个权限
             * @menu 权限管理
             */
            Route::post("getone", 'admin/Rule/GetOne');
            /**
             * @name 权限列表
             * @menu 权限管理
             */
            Route::post("getlist", 'admin/Rule/GetList');
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @menu 权限组管理
         * @name 权限组管理
         * @type menu
         * @isshow 1
         */
        Route::group('group', function () {
            /**
             * @name 添加权限组
             * @menu 权限组管理
             */
            Route::post("add", 'admin/Group/AddOne');
            /**
             * @name 修改权限组
             * @menu 权限组管理
             */
            Route::post("change", 'admin/Group/UpdateOne');
            /**
             * @name 删除权限组
             * @menu 权限组管理
             */
            Route::post("delete", 'admin/Group/DeleteOne');
            /**
             * @name 获得一个权限组
             * @menu 权限组管理
             */
            Route::post("getone", 'admin/Group/GetOne');
            /**
             * @name 权限组列表
             * @menu 权限组管理
             */
            Route::post("getlist", 'admin/Group/GetList');
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @menu 区域管理
         * @name 区域管理
         * @type menu
         * @isshow 1
         */
        Route::group('regiongroup', function () {
            /**
             * @name 添加区域组
             * @menu 区域管理
             */
            Route::post("add", 'admin/RegionGroup/AddOne');
            /**
             * @name 修改区域组
             * @menu 区域管理
             */
            Route::post("change", 'admin/RegionGroup/UpdateOne');
            /**
             * @name 删除区域组
             * @menu 区域管理
             */
            Route::post("delete", 'admin/RegionGroup/DeleteOne');
            /**
             * @name 获取单个区域组
             * @menu 区域管理
             */
            Route::post("getone", 'admin/RegionGroup/GetOne');
            /**
             * @name 区域组列表
             * @menu 区域管理
             */
            Route::post("getlist", 'admin/RegionGroup/GetList');
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @menu 仓库管理
         * @name 仓库管理
         * @type menu
         * @isshow 1
         */
        Route::group('tray', function () {
            /**
             * @name 添加仓库
             * @menu 仓库管理
             */
            Route::post("add", 'admin/Tray/AddOne');
            /**
             * @name 修改仓库
             * @menu 仓库管理
             */
            Route::post("change", 'admin/Tray/UpdateOne');
            /**
             * @name 删除仓库
             * @menu 仓库管理
             */
            Route::post("delete", 'admin/Tray/DeleteOne');
            /**
             * @name 获取一个仓库
             * @menu 仓库管理
             */
            Route::post("getone", 'admin/Tray/GetOne');
            /**
             * @name 仓库列表
             * @menu 仓库管理
             */
            Route::post("getlist", 'admin/Tray/GetList');
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @menu 订单管理
         * @name 订单管理
         * @type menu
         * @isshow 1
         */
        Route::group('order', function () {
            /**
             * @name 添加订单
             * @menu 订单管理
             */
            Route::post("shopadd", "admin/Order/ShopAddOne");
            /**
             * @name 修改订单
             * @menu 订单管理
             */
            Route::post("change", 'admin/Order/UpdateOne');
            /**
             * @name 删除订单
             * @menu 订单管理
             */
            Route::post("delete", 'admin/Order/DeleteOne');
            /**
             * @name 获取一个订单
             * @menu 订单管理
             */
            Route::post("getone", 'admin/Order/GetOne');
            /**
             * @name 订单列表
             * @menu 订单管理
             */
            Route::post("getlist", 'admin/Order/GetList');
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @menu 提现管理
         * @name 提现管理
         * @type menu
         * @isshow 1
         */
        Route::group('tixian', function () {
            /**
             * @name 提现
             * @menu 提现管理
             */
            Route::post("add", "admin/TiXian/AddOne");
            /**
             * @name 获取单个提现
             * @menu 提现管理
             */
            Route::post("getone", 'admin/TiXian/GetOne');
            /**
             * @name 提现列表
             * @menu 提现管理
             */
            Route::post("getlist", "admin/TiXian/GetList");
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @menu 消息管理
         * @name 消息管理
         * @type menu
         * @isshow 1
         */
        Route::group('message', function () {
            /**
             * @name 添加消息
             * @menu 消息管理
             */
            Route::post("add", "admin/Message/AddOne");
            /**
             * @name 获取单个消息
             * @menu 消息管理
             */
            Route::post("getone", 'admin/Message/GetOne');
            /**
             * @name 修改单个消息
             * @menu 消息管理
             */
            Route::post("change", 'admin/Message/UpdateOne');
            /**
             * @name 消息列表
             * @menu 消息管理
             */
            Route::post("getlist", "admin/Message/GetList");
            /**
             * @name 删除消息
             * @menu 消息管理
             */
            Route::post("delete", 'admin/Message/DeleteOne');
        });
    });

    Route::group('home', function () {
        /**
         * @name 提现
         */
        Route::post("withdraw", "home/TiXian/WithDraw");
        /**
         * @name 发送短信
         */
        Route::post("senMsg", "home/WechatSms/index");
        /**
         * @name 前台用户管理
         * @menu 前台用户管理
         * @type menu
         * @isshow 1
         */
        Route::group('user', function () {
            /**
             * @name 添加用户
             * @menu 前台用户管理
             */
            Route::post("add", 'home/Shop/AddOne');
            /**
             * @name 添加订单
             * @menu 前台用户管理
             */
            Route::post("addorder", 'home/Order/AddOder');
            /**
             * @name 添加本地库存
             * @menu 前台用户管理
             */
            Route::post("addStock", 'home/Retrospect/AddOne');
            /**
             * @name 删除门店添加的本地库存
             * @menu 前台用户管理
             */
            Route::post("delStock", 'home/Retrospect/DeleteOne');
            /**
             * @name 门店添加的本地库存列表
             * @menu 前台用户管理
             */
            Route::post("StockList", 'home/Retrospect/GetList');
            /**
             * @name 门店预估报价列表
             * @menu 前台用户管理
             */
            Route::post("addRetrospect", 'home/Retrospect/GetRetrospectList');
            /**
             * @name 修改用户
             * @menu 前台用户管理
             */
            Route::post("change", 'home/User/UpdateOne');
            /**
             * @name 获取单个用户
             * @menu 前台用户管理
             */
            Route::post("getone", 'home/User/GetDQOne');
            /**
             * @name 获取用户列表
             * @menu 前台用户管理
             */
            Route::post("getlist", 'home/User/GetList');
            /**
             * @name 退出用户
             */
            Route::post("logout", 'home/User/logout');
            /**
             * @name 用户登录
             */
            Route::post("login", 'home/User/login');
            /**
             * @name 用户审核
             * @menu 前台用户管理
             */
            Route::post("confirm", "home/User/Confirm");
            /**
             * @name 登录用户信息
             * @menu 前台用户管理
             */
            Route::post('getbyuser','home/User/GetByUser');
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @name 消息管理
         * @menu 消息管理
         * @type menu
         * @isshow 1
         */
        Route::group('message', function () {
            /**
             * @name 获取通知
             * @menu 消息管理
             */
            Route::post("getnotice", 'home/Message/GetNotice');
            /**
             * @name 获取用户消息
             * @menu 消息管理
             */
            Route::post("getusernotice", 'home/Message/GetUserNotice');
            /**
             * @name 获取用户未读消息
             * @menu 消息管理
             */
            Route::post("getnoread", 'home/Message/GetNoRead');
            /**
             * @name 获取用户身份通知
             * @menu 消息管理
             */
            Route::post("typenotice",'home/Message/TypeNotice');
            /**
             * @name 查询消息内容
             * @menu 消息管理
             */
            Route::post("notice",'home/Message/Notice');
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @name 垃圾分类管理
         * @menu 垃圾分类管理
         * @type menu
         * @isshow 1
         */
        Route::group('garbage', function () {
            /**
             * @name 添加垃圾分类
             * @menu 垃圾分类管理
             */
            Route::post("add", 'home/Garbage/AddOne');
            /**
             * @name 修改垃圾分类
             * @menu 垃圾分类管理
             */
            Route::post("change", 'home/Garbage/UpdateOne');
            /**
             * @name 删除垃圾分类
             * @menu 垃圾分类管理
             */
            Route::post("delete", 'home/Garbage/DeleteOne');
            /**
             * @name 获取单个垃圾分类
             * @menu 垃圾分类管理
             */
            Route::post("getone", 'home/Garbage/GetOne');
            /**
             * @name 垃圾分类列表
             * @menu 垃圾分类管理
             */
            Route::post("getlist", 'home/Garbage/GetList');
            /**
             * @name 所有垃圾分裂
             * @menu 垃圾分类管理
             */
            Route::post("getalllist", 'home/Garbage/GetAllList');
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @name 垃圾报价管理
         * @menu 垃圾报价管理
         * @type menu
         * @isshow 1
         */
        Route::group('garbageprice', function () {
            /**
             * @name 添加垃圾报价
             * @menu 垃圾报价管理
             */
            Route::post("add", 'home/GarbagePrice/AddOne');
            /**
             * @name 修改垃圾报价
             * @menu 垃圾报价管理
             */
            Route::post("change", 'home/GarbagePrice/UpdateOne');
            /**
             * @name 删除垃圾报价
             * @menu 垃圾报价管理
             */
            Route::post("delete", 'home/GarbagePrice/DeleteOne');
            /**
             * @name 获取单个垃圾报价
             * @menu 垃圾报价管理
             */
            Route::post("getone", 'home/GarbagePrice/GetOne');
            /**
             * @name 垃圾报价列表
             * @menu 垃圾报价管理
             */
            Route::post("getlist", 'home/GarbagePrice/GetList');
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @name 订单管理
         * @menu 订单管理
         * @type menu
         * @isshow 1
         */
        Route::group('order', function () {
            /**
             * @name 添加订单
             * @menu 订单管理
             */
//             门店下单  --待修改
            Route::post("shopadd", "home/Order/ShopAddOne");
            // 门店修改价格  --待修改
             /**
             * @name 修改订单价格与重量
             * @menu 订单管理
             */
            Route::post("updateprice", "home/Order/UpdatePrice");
             /**
             * @name 获取订单列表
             * @menu 订单管理
             */
            // 订单列表  -- 当前登录人发布的订单
            Route::post("getlist", "home/Order/GetList");
             /**
             * @name 确认订单
             * @menu 订单管理
             */
            // 确认订单  --待修改
            Route::post("confirm", 'home/Order/ConfirmOrder');
             /**
             * @name 获取单个订单
             * @menu 订单管理
             */
            // 根据订单id搜订单详情
            Route::post("getone", 'home/Order/getone');
             /**
             * @name 取消订单
             * @menu 订单管理
             */
            // 取消订单
            Route::post('cancel', 'home/Order/Cancel');
            // 业务员、暂存点发布订单
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @name 仓库管理
         * @menu 仓库管理
         * @type menu
         * @isshow 1
         */
        Route::group('tray', function () {
             /**
             * @name 添加仓库
             * @menu 仓库管理
             */
            Route::post("add", 'home/Tray/AddOne');
             /**
             * @name 修改仓库信息
             * @menu 仓库管理
             */
            Route::post("change", 'home/Tray/UpdateOne');
             /**
             * @name 删除仓库
             * @menu 仓库管理
             */
            Route::post("delete", 'home/Tray/DeleteOne');
             /**
             * @name 获取单个仓库信息
             * @menu 仓库管理
             */
            Route::post("getone", 'home/Tray/GetOne');
             /**
             * @name 获取仓库列表
             * @menu 仓库管理
             */
            Route::post("getlist", 'home/Tray/GetList');
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        /**
         * @name 提现管理
         * @menu 提现管理
         * @type menu
         * @isshow 1
         */
        Route::group('tixian', function () {
             /**
             * @name 申请提现
             * @menu 提现管理
             */
            Route::post("add", "home/TiXian/AddOne");
             /**
             * @name 获取单个提现
             * @menu 提现管理
             */
            Route::post("getone", 'home/TiXian/GetOne');
             /**
             * @name 获取个人提现列表
             * @menu 提现管理
             */
            Route::post("list", "home/TiXian/GetListById");
             /**
             * @name 获取所有提现列表
             * @menu 提现管理
             */
            Route::post("getlist", "home/TiXian/GetList");
        })->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
    });
});