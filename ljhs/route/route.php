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

Route::group('api',function(){
    Route::group('file',function(){
        Route::post("pic",'admin/File/Upfile');
        Route::post("databulk","admin/File/Bulk");
        Route::post("video",'admin/File/Video');
    })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();

    Route::group('admin',function(){
    	Route::post("login",'admin/admin/login')->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey,sessionId')->allowCrossDomain();
        Route::post("add",'admin/admin/AddOne')->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey,sessionId')->allowCrossDomain();
        Route::post("change",'admin/admin/UpdateOne')->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey,sessionId')->allowCrossDomain();
        Route::post("getlist",'admin/admin/GetList')->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey,sessionId')->allowCrossDomain();
        Route::post("getone",'admin/admin/GetOne')->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey,sessionId')->allowCrossDomain();
        Route::post("delete",'admin/admin/DeleteOne')->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey,sessionId')->allowCrossDomain();
        Route::post("logout",'admin/admin/logout')->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
     	Route::post("uppwd",'admin/admin/UpPwd')->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();

        Route::post("addtest",'admin/admin/addtest')->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::post("showtest",'admin/admin/showtest')->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();

        Route::group('user',function(){
            Route::post("add",'admin/User/AddOne');
            Route::post("change",'admin/User/UpdateOne');
            Route::post("delete",'admin/User/DeleteOne');
            Route::post("getone",'admin/User/GetOne');
            Route::post("getlist",'admin/User/GetList');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('garbage',function(){
            Route::post("add",'admin/Garbage/AddOne');
            Route::post("change",'admin/Garbage/UpdateOne');
            Route::post("delete",'admin/Garbage/DeleteOne');
            Route::post("getone",'admin/Garbage/GetOne');
            Route::post("getlist",'admin/Garbage/GetList');
            Route::post("getalllist",'admin/Garbage/GetAllList');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('garbageprice',function(){
            Route::post("add",'admin/GarbagePrice/AddOne');
            Route::post("change",'admin/GarbagePrice/UpdateOne');
            Route::post("delete",'admin/GarbagePrice/DeleteOne');
            Route::post("getone",'admin/GarbagePrice/GetOne');
            Route::post("getlist",'admin/GarbagePrice/GetList');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('rule',function(){
            Route::post("add",'admin/Rule/AddOne');
            Route::post("change",'admin/Rule/UpdateOne');
            Route::post("delete",'admin/Rule/DeleteOne');
            Route::post("getone",'admin/Rule/GetOne');
            Route::post("getlist",'admin/Rule/GetList');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('group',function(){
            Route::post("add",'admin/Group/AddOne');
            Route::post("change",'admin/Group/UpdateOne');
            Route::post("delete",'admin/Group/DeleteOne');
            Route::post("getone",'admin/Group/GetOne');
            Route::post("getlist",'admin/Group/GetList');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('regiongroup',function(){
            Route::post("add",'admin/RegionGroup/AddOne');
            Route::post("change",'admin/RegionGroup/UpdateOne');
            Route::post("delete",'admin/RegionGroup/DeleteOne');
            Route::post("getone",'admin/RegionGroup/GetOne');
            Route::post("getlist",'admin/RegionGroup/GetList');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('tray',function(){
            Route::post("add",'admin/Tray/AddOne');
            Route::post("change",'admin/Tray/UpdateOne');
            Route::post("delete",'admin/Tray/DeleteOne');
            Route::post("getone",'admin/Tray/GetOne');
            Route::post("getlist",'admin/Tray/GetList');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('order',function(){
            Route::post("shopadd","admin/Order/ShopAddOne");
            Route::post("tempadd","admin/Order/TempAddOne");
            Route::post("tempprice","admin/Order/TempPrice");
            Route::post("updateprice","admin//UpdatePrice");
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('tixian',function(){
            Route::post("add","admin/TiXian/AddOne");
            Route::post("getone",'admin/TiXian/GetOne');
            Route::post("getlist","admin/TiXian/GetList");
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('message',function(){
            Route::post("add","admin/Message/AddOne");
            Route::post("getone",'admin/Message/GetOne');
            Route::post("change",'admin/Message/UpdateOne');
            Route::post("getlist","admin/Message/GetList");
            Route::post("delete",'admin/Message/DeleteOne');
        });
    });

    Route::group('home',function(){
        Route::post("withdraw","home/TiXian/WithDraw");
        //发短信
        Route::post("senMsg","home/WechatSms/index");
//        门店
        Route::group('shop',function(){
            //门店注册
            Route::post("add",'home/Shop/AddOne');
            Route::post("change",'home/Shop/UpdateOne');
            Route::post("delete",'home/Shop/DeleteOne');
            Route::post("getone",'home/Shop/GetOne');
            Route::post("getlist",'home/Shop/GetList');
            Route::post("logout",'home/Shop/logout');
            Route::post("login",'home/Shop/login');
            Route::post("addorder",'home/Order/AddOder');
//            门店添加一个本地库存
            Route::post("addStock", 'home/Retrospect/AddOne');
//            删除门店添加的本地库存
            Route::post("delStock", 'home/Retrospect/DeleteOne');
//            门店添加的本地库存列表
            Route::post("StockList", 'home/Retrospect/GetList');
//            门店预估报价列表
            Route::post("addRetrospect", 'home/Retrospect/GetRetrospectList');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('user',function(){
            Route::post("change",'home/User/UpdateOne');
            Route::post("getone",'home/User/GetDQOne');
            Route::post("gettemplist",'home/User/GetTempList');
            Route::post("getlist",'home/User/GetList');
            Route::post("logout",'home/User/logout');
            Route::post("login",'home/User/login');
            Route::post("change",'home/User/UpdateOne');
            Route::post("chagebyid","home/User/UpdateOneById");
            Route::post("register","home/User/Register");
            Route::post("confirm","home/User/Confirm");
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('message',function(){
            Route::post("getnotice",'home/Message/GetNotice');
            Route::post("getusernotice",'home/Message/GetUserNotice');
            Route::post("getnoread",'home/Message/GetNoRead');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('garbage',function(){
            Route::post("add",'home/Garbage/AddOne');
            Route::post("change",'home/Garbage/UpdateOne');
            Route::post("delete",'home/Garbage/DeleteOne');
            Route::post("getone",'home/Garbage/GetOne');
            Route::post("getlist",'home/Garbage/GetList');
            Route::post("getalllist",'home/Garbage/GetAllList');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('garbageprice',function(){
            Route::post("add",'home/GarbagePrice/AddOne');
            Route::post("change",'home/GarbagePrice/UpdateOne');
            Route::post("delete",'home/GarbagePrice/DeleteOne');
            Route::post("getone",'home/GarbagePrice/GetOne');
            Route::post("getlist",'home/GarbagePrice/GetList');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('order',function(){
            Route::post("shopadd","home/Order/ShopAddOne");
            Route::post("tempadd","home/Order/TempAddOne");
            Route::post("tempprice","home/Order/TempPrice");
            Route::post("updateprice","home//UpdatePrice");
            Route::post("getlist","home/Order/GetList");
            Route::post("confirm",'home/Order/ConfirmOrder');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('tray',function(){
            Route::post("add",'home/Tray/AddOne');
            Route::post("change",'home/Tray/UpdateOne');
            Route::post("delete",'home/Tray/DeleteOne');
            Route::post("getone",'home/Tray/GetOne');
            Route::post("getlist",'home/Tray/GetList');
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
        Route::group('tixian',function(){
            Route::post("add","home/TiXian/AddOne");
            Route::post("getone",'home/TiXian/GetOne');
            Route::post("list","home/TiXian/GetListById");
            Route::post("getlist","home/TiXian/GetList");
        })->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId')->allowCrossDomain();
    });
});