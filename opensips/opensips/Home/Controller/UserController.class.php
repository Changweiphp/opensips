<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
	/**
	 * 初始页面
	 */
    public function index(){
    	$this->name="post";
    	$this->display();
     }
}