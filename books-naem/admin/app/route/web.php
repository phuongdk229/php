<?php
session_start();
if (!defined('APP_PATH')) {
	die('can not access');
}

require_once 'app/config/constant.php';

require_once 'app/helper/common_helper.php';


class Route{
	public function login(){
		require_once 'app/controller/LoginController.php';
	}
	public function dashboard(){
		require_once 'app/controller/DashboardController.php';
	}
	public function product(){
		require_once 'app/controller/ProductsController.php';
	}
	public function categories(){
		require_once 'app/controller/CategoriesController.php';
	}
	public function manager(){
		require_once 'app/controller/ManagerController.php';
	}
	public function customer(){
		require_once 'app/controller/CustomerController.php';
	}
	public function statistic(){
		require_once 'app/controller/StatisticController.php';
	}
	function __call($r,$q){
		echo "Not found Request";
	}
}
$route = new Route;
$controller = $_GET['c']??'login';
$route->$controller();