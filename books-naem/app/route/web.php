<?php
session_start();
if (!defined('APP_PATH')) {
	die('can not access');
}
require_once 'app/config/constant.php';
require_once 'app/helper/common_helper.php';

class Route{
	public function home(){
		require_once 'app/controller/HomeController.php';
	}
	public function login(){
		require_once 'app/controller/loginController.php';
	}
	public function product(){
		require_once 'app/controller/productController.php';
	}
	public function cart(){
		require_once 'app/controller/cartController.php';
	}
	public function customer(){
		require_once 'app/controller/customerController.php';
	}
	function __call($r,$q){
		echo "not found request";
	}
}
$route = new Route;
$c = $_GET['c']??'home';
$route->$c();