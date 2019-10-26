<?php
namespace app\home\controller;
use think\facade\Request;
use think\Controller;
class Base extends Controller
{

     public $param;
    public function initialize()
    {
        parent::initialize();
        $origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';  
  
        $allow_origin = array(  
            'http://localhost:8080',  
            'http://localhost:8081'  
        );  
          
        if(in_array($origin, $allow_origin)){  
            header('Access-Control-Allow-Origin:'.$origin);       
        } 
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");
        $param =  Request::instance()->param();            
        $this->param = $param;
    }

    public function object_array($array) 
    {  
        if (is_object($array)) {  
            $array = (array)$array;  
        } 
        if (is_array($array)) {  
            foreach ($array as $key=>$value) {  
                $array[$key] = $this->object_array($value);  
            }  
        }  
        return $array;  
    }
}
 