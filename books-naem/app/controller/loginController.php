<?php
namespace App\Controller;
if (!defined('APP_PATH')) {
	die('Can not access');
}
require 'app/model/login_model.php';
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
			$email = $_POST['txtEmail'];
			$email = strip_tags($email);

			$password = $_POST['txtPass'];
			$password = strip_tags($password);
			$password = md5($password);

			if ($email==='' OR $password==='') {
				header("location:?c=login&state=err");
			}else{
				$checkLogin = $this->loginDb->CheckLoginAdmin($email,$password);
				if (! empty($checkLogin) && isset($checkLogin['id'])) {
					$_SESSION['email_cus'] = $checkLogin['email_cus'];
					$_SESSION['id_cus'] = $checkLogin['id'];
					$_SESSION['name_cus'] = $checkLogin['name_cus'];
					$_SESSION['address_cus'] = $checkLogin['address_cus'];

					$_SESSION['phone_cus'] = $checkLogin['phone_cus'];
					$_SESSION['coin'] = $checkLogin['coin'];
					
					header('location:?c=customer&m=register');
				}else{
					header("location:?c=login&state=fail");
				}
			}
		}
	}
	public function handleOnMenu(){
		if (isset($_POST['btnSubmit'])) {
			$email = $_POST['txtEmail'];
			$email = strip_tags($email);

			$password = $_POST['txtPass'];
			$password = strip_tags($password);
			$password = md5($password);

			if ($email==='' OR $password==='') {
				header("location:?c=home&state=err");
			}else{
				$checkLogin = $this->loginDb->CheckLoginAdmin($email,$password);
				if (! empty($checkLogin) && isset($checkLogin['id'])) {
					$_SESSION['email_cus'] = $checkLogin['email_cus'];
					$_SESSION['id_cus'] = $checkLogin['id'];
					$_SESSION['name_cus'] = $checkLogin['name_cus'];
					$_SESSION['address_cus'] = $checkLogin['address_cus'];

					$_SESSION['phone_cus'] = $checkLogin['phone_cus'];
					$_SESSION['coin'] = $checkLogin['coin'];
					
					header('location:?c=home');
				}else{
					header("location:?c=home&state=fail");
				}
			}
		}		
	}
	public function logout(){
		unset($_SESSION['id_cus']);
		// unset($_SESSION['id']);
		// unset($_SESSION['role']);
		header('location:?c=home');
	}
	function __call($r,$q){
		echo "Not found Request";
	}
}
$login = new LoginController;
$method = $_GET['m']??'index';
$login->$method();