<?php
namespace App\Controller;
if (!defined('APP_PATH')) {
	die('Can not access');
}
require 'app/model/Login_model.php';
use App\Model\LoginModel;
class LoginController{
	private $loginDb;
	function __construct(){
		$this->loginDb = new LoginModel();
	}
	public function index(){
		require 'app/view/login/index_view.php';
	}
	public function handle(){
		if (isset($_POST['btnSubmit'])) {
			$username = $_POST['txtUser'];
			$username = strip_tags($username);

			$password = $_POST['txtPass'];
			$password = strip_tags($password);
			$password = md5($password);

			if ($username==='' OR $password==='') {
				header("location:?c=login&state=err");
			}else{
				$checkLogin = $this->loginDb->CheckLoginAdmin($username,$password);
				if (! empty($checkLogin) && isset($checkLogin['id'])) {
					$_SESSION['username'] = $checkLogin['username'];
					$_SESSION['id'] = $checkLogin['id'];
					$_SESSION['role'] = $checkLogin['role'];
					header('location:?c=dashboard');
				}else{
					header("location:?c=login&state=fail");
				}
			}
		}
	}
	public function logout(){
		unset($_SESSION['username']);
		unset($_SESSION['id']);
		unset($_SESSION['role']);
		header('location:?c=login');
	}
	function __call($r,$q){
		echo "Not found Request";
	}
}
$login = new LoginController;
$method = $_GET['m']??'index';
$login->$method();