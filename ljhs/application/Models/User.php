<?php
namespace app\Models;

use app\validate\AdminUpdate as AdminUpdateValidate;
use app\validate\LimitValidate;
use app\validate\LoginChange as LoginChangeValidate;
use app\validate\LoginValidate;
use app\validate\TokenValidate;
use app\validate\UserAdd;
use think\facade\Request;

class User extends BaseModel
{
    protected $table = 'user';

    //添加一个管理员
    public function AddOne()
    {
        $post = Request::post();
        (new UserAdd())->goCheck($post);
        $SmsModel = new Sms();
        $sms_w = [];
        $sms_w[] = ['mobile', '=', $post['phone']];
        $sms_w[] = ['create_time', '>', time() - 300];
        $sms_res = $SmsModel->MFind($sms_w);
        if (empty($sms_res) || $sms_res['code'] != $post['code']) {
            $this->error = '验证码错误';
            return false;
        }
        $mcont = [];
        $mcont['phone'] = $post['phone'];
        $mcont['status'] = 1;
        $mcont['del'] = 0;
        $mcont['type'] = 1;
        $fadmin = $this->MFind($mcont);
        if ($fadmin) {
            $this->error = "此用户已存在";
            return false;
        } else {
            $region = [];
            $region[] = $post['province'];
            $region[] = $post['city'];
            $region[] = $post['county'];
            $region_ids = [];
            $region_ids[] = ['regionid','=',implode(',',$region)];
            $region_ids[] = ['del','=','0'];
            $region_ids[] = ['status','=','1'];
            $region_model = new ReGroup();
            $region_user = $region_model->MFind($region_ids,'','regroupid');
            if(empty($region_user)){
                $this->error = '该地区暂不开放注册功能';
                return false;
            }
            $post['token'] = md5(time());
            $post['pwd'] = md5($post['pwd']);
            $post['region'] = $region_user['regroupid'];
            $res = $this->MAdd($post);
            if ($res) {
                return $res;
            } else {
                $this->error = "添加失败";
                return false;
            }
        }
    }

    //修改管理员信息
    public function ChangeOne()
    {
        $post = Request::post();
        (new UserAdd())->goCheck($post);
        $mcont['name'] = $post['name'];
        $mcont['status'] = 1;
        $mcont['del'] = 0;
        $user = session("user");
        $fadmin = $this->MFind($mcont);
        if ($fadmin) {
            if ($fadmin['id'] != $user['userInfo']['id']) {
                $this->error = "此用户名已经存在";
                return false;
            } else {
                $acont['id'] = $user['userInfo']['id'];
                $res = $this->MUpdate($acont, $post);
                if ($res) {
                    return $res;
                } else {
                    $this->error = "修改失败";
                    return false;
                }
            }
        } else {
            $acont['id'] = $user['userInfo']['id'];
            $res = $this->MUpdate($acont, $post);
            if ($res) {
                return $res;
            } else {
                $this->error = "修改失败";
                return false;
            }
        }
    }

    //分页查询信息
    public function GetList()
    {
        $post = Request::post();
        (new LimitValidate())->goCheck($post);
        $config['page'] = $post['page'];
        $config['list_rows'] = $post['list_rows'];
        $field = array("token", "name", "phone", 'id', 'realname', 'pic', 'zhicheng');
        $where['status'] = 1;
        $where['del'] = 0;
        if (array_key_exists("type", $post) && $post['type'] != "") {
            $where['type'] = $post['type'];
        }
        $res = $this->MLimitSelect($where, $config, "id desc", $field);
        if ($res) {
            return $res;
        } else {
            $this->error = "查询失败";
            return false;
        }
    }

    //删除用户
    public function DeleteOne()
    {
        $post = Request::post();
        if (array_key_exists("token", $post)) {
            $mcont['token'] = $post['token'];
            $res = $this->MDelete($mcont);
            if ($res) {
                return $res;
            } else {
                $this->error = "删除失败";
                return false;
            }
        } else {
            $this->error = "缺少必要参数";
            return false;
        }
    }

    public function login()
    {
        $post = Request::post();
        (new LoginValidate())->goCheck($post);
        $acont['name'] = $post['name'];
        $acont['status'] = 1;
        $acont['del'] = 0;
        $admin = $this->MFind($acont);
        if (!$admin) {
            $this->error = "帐号不存在";
            return false;
        } else {
            if ($post['pwd'] !== $admin['pwd']) {
                $this->error = "密码错误";
                return false;
            } else {
                $cache['userInfo'] = $admin;
                $cache['time'] = time();
                $cache['authKey'] = md5($admin['id'] . $admin['name'] . $admin['pwd'] . $cache['time']);
                session('user', $cache, 'think');
                return $cache['authKey'];
            }
        }
    }

    //退出登录
    public function logout()
    {
        Session("user", "");
        return 1;
    }

    //修改登录密码与账号
    public function UpPwd()
    {
        $post = Request::post();
        (new LoginChangeValidate())->goCheck($post);
        $seadmin = Session("userInfo");
        $acont['id'] = $seadmin['id'];
        $admin = $this->MFind($acont);
        if ($admin) {
            if ($admin['name'] == $post['name'] && $admin['pwd'] == $post['oldpwd']) {
                $this->error = "密码错误";
                return false;
            } else {
                $data['name'] = $post['name'];
                $data['pwd'] = $post['pwd'];
                $res = $this->MUpdate($data, $acont);
                if ($res) {
                    $cache['userInfo'] = $data;
                    $cache['time'] = time();
                    $cache['authKey'] = md5($admin['ad_id'] . $data['name'] . $data['pwd'] . $cache['time']);
                    session('user', $cache, 'think');
                    return $cache['authKey'];
                } else {
                    $this->error = "修改失败";
                    return false;
                }
            }
        } else {
            $this->error = "网络错误,请重新登录";
            return false;
        }
    }

    //查询暂存点用户列表
    public function GetTempList()
    {
        $res = $this->GetTypeList("3");
        if ($res) {
            return $res;
        } else {
            $this->error = "查询失败";
            return false;
        }
    }

    //查询业务员点用户列表
    public function GetSaleList()
    {
        $user = session("user");
        $res = $this->GetTypeList("2", "tempid", $user['userInfo']['id']);
        if ($res) {
            return $res;
        } else {
            $this->error = "查询失败";
            return false;
        }
    }

    //查询门店用户列表
    public function GetShopList()
    {
        $user = session("user");
        $res = $this->GetTypeList("2", "saleid", $user['userInfo']['id']);
        if ($res) {
            return $res;
        } else {
            $this->error = "查询失败";
            return false;
        }
    }

    //根据类型获得
    public function GetTypeList($type, $userid = "", $findusername = "")
    {
        $post = Request::post();
        (new LimitValidate())->goCheck($post);
        $where['type'] = $type;
        $where['status']=1;
        $where['del'] = 0;
        if ($userid != '') {
            $where[$findusername] = $userid;
        }
        $config['page'] = $post['page'];
        $config['list_rows'] = $post['list_rows'];
        $res = $this->MLimitSelect($where, $config);
        return $res;
    }

    //根据id修改用户信息
    public function UpdateOneById()
    {
        $post = Request::post();
        (new UserAdd())->goCheck($post);
        if (array_key_exists("id", $post) && $post['id']) {
            $where['id'] = $post['id'];
            unset($post['id']);
            $res = $this->MUpdate($where, $post);
            if ($res) {
                return $res;
            } else {
                $this->error = '修改失败';
                return false;
            }
        } else {
            $this->error = "修改失败";
            return false;
        }
    }
    //注册门店
    public function Register()
    {

        $post = Request::post();
        (new UserAdd())->goCheck($post);
        $mcont['name'] = $post['name'];
        $mcont['realname'] = $post['realname'];
        $mcont['del'] = 0;
        $fadmin = $this->MFind($mcont);

        if ($fadmin) {
            $this->error = "此用户名或真实姓名已经存在";
            return false;
        } else {
            $post1['token'] = md5(time());
            $post1['zhicheng'] = $post['zhicheng'];
            $post1['realname'] = $post['realname'];
            $post1['address'] = $post['address'];
            $post1['pwd'] = $post['pwd'];
            $post1['name'] = $post['name'];
            $post1['phone'] = $post['phone'];
            $post1['status']=0;
            $this->startTrans();
            $res = $this->MAdd($post1);
            $message=new Message();
            $str="用户".$post['realname']."申请注册名为".$post['zhicheng']."的门店";
            $res1=$message->AddMessage("",'','注册申请',$str);
            if ($res&&$res1) {
                $this->commit();
                return $res;
            } else {
                $this->rollback();
                $this->error = "添加失败";
                return false;
            }
        }
    }
    //审核
    public function Confirm()
    {
        $post=Request::post();
        (new TokenValidate())->goCheck($post);
        if((array_key_exists('status',$post)&&$post['status']!="")&&(array_key_exists('remark',$post)&&$post['remark']!="")){
            if($post['status']==1){
                $data['status']=1;
            }else{
                $data['status']=-1;
                $data['remark']=$post['remark'];
            }
            $where['token']=$post['token'];
            $res=$this->MUpdate($where,$data);
            if($res){
                return $res;
            }else{
                $this->error="审核操作失败";
                return false;
            }
        }else{
            $this->error="缺少必要参数";
            return false;
        }
    }
}