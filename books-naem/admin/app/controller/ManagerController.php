<?php
namespace App\Controller;

require 'app/core/MY_controller.php';
require 'app/model/manager_model.php';
// require 'app/helper/mail/sendmail_helper.php';

use App\Core\MY_controller;
use App\Model\ManagerModel;

if (!defined('APP_PATH')) {
	die('can not access');
}

// if (!isset($_SESSION['username'])) {
// 	header('location:?c=login');
// }
// else{
// 	if ($_SESSION['username'] !== -1) {
// 		header('location:?c=dashboard');
// 	}
// }
class ManagerController extends MY_controller{
	private $ManModel;
	function __construct(){
		parent::__construct();
		$this->ManModel = new ManagerModel();
		if (isset($_SESSION['errAddMan']) && !isset($_GET['state'])) {
			unset($_SESSION['errAddMan']);
		}
		if (isset($_GET['state']) && $_GET['state']!=='exist') {
			unset($_SESSION['errNameMan']);
		}
		if (isset($_SESSION['errEditMan']) && !isset($_GET['state'])) {
			unset($_SESSION['errEditMan']);
		}
		if (isset($_GET['state']) && $_GET['state']!=='exist') {
			unset($_SESSION['errNameEdit']);
		}
	}
	public function index(){
		$data = [];
		$keyword = $_GET['key']??'';
		$keyword = strip_tags($keyword);

		$page = $_GET['page']??'';
		$page = (is_numeric($page) && $page > 0)? $page : 1;
		$link = [
			'c' => 'manager',
			'm' => 'index',
			'page' => '{page}',
			'key' => $keyword
		];

		$creat_links = creat_link($link);
		$allMan = $this->ManModel->getAllDataManager($keyword);

		// xu ly phan trang
		$pagination = pagination($creat_links,count($allMan),$page,ROW_LIMIT,$keyword);

		$dataPage = $this->ManModel->getAllDataProductByPage($pagination['start'],$pagination['limit'],$keyword);
		// echo "<pre>";
		// print_r($dataPage);
		// die;
		$data['lsMan'] = $dataPage;
		$data['key'] = $keyword;
		$data['pageHtml'] = $pagination['htmlPage'];
		$data['limit'] = $pagination['limit'];
		$data['page'] = $page;

		$header = [];
		$header['title'] = 'This is Manager';
		$header['content'] = 'This is content manager';
		$this->loadHeader($header);
		$this->loadView('app/view/manager/index_view.php',$data);
		$this->loadFooter();
	}
	public function add(){
		$data = [];
		$data['errAdd'] = $_SESSION['errAddMan'] ??[];
		$data['state'] = $_GET['state']??'';
		$data['errName'] = $_SESSION['errNameMan']??'';

		$header = [];
		$header['title'] = 'This is Adding Manager';
		$header['content'] = 'This is Adding content';
		$this->loadHeader($header);
		$this->loadView('app/view/manager/add_view.php',$data);
		$this->loadFooter();
	}
	public function handleAdd(){
		if (isset($_POST['btnAddMan'])) {
			$nameMan = $_POST['nameMan']??'';
			$nameMan = strip_tags($nameMan);

			$passMan = $_POST['passMan']??'';
			$passMan = strip_tags($passMan);


			$emailMan = $_POST['emailMan']??'';
			$emailMan = strip_tags($emailMan);

			$dataErr = validateAddManager($nameMan,$passMan,$emailMan);
			// echo "<pre>";
			// print_r($dataErr);
			// die;
			$checkAdd = true;
			foreach ($dataErr as $key => $err) {
				if ($err != '') {
					$checkAdd = false;
					break;
				}
			}

			if ($checkAdd) {
				if (isset($_SESSION['errAddMan'])) {
					unset($_SESSION['errAddMan']);
				}
				$checkName = $this->ManModel->checkNameManExit($nameMan);
				if ($checkName) {
					// khong cho them vi ten trung
					$_SESSION['errNameMan'] = $nameMan;
					header("location:?c=manager&m=add&state=exist");
				}else{
					$passMan = md5($passMan);
					// $content = rand(1,100);
					// $subject = 'Check code';
					// if (sendMailPHPMailer($emailMan,$subject,$content)) {
						
					// }
					$add = $this->ManModel->addDataMannager($nameMan,$passMan,$emailMan);
					if ($add) {
						header('location:?c=manager');
					}else{
						header('location:?c=manager&m=add&state=err');
					}					
				}

			}else{
				$_SESSION['errAddMan'] = $dataErr;
				// echo "<pre>";
				// print_r($_SESSION['errAddMan']);
				// die;
				header('location:?c=manager&m=add&state=fail');
			}
		}
	}

	public function edit(){
		$idMan = $_GET['id'];
		$idMan = is_numeric($idMan)? $idMan : 0;

		$infMan = $this->ManModel->getAllDataById($idMan);
		if (!empty($infMan)) {
			$data = [];
			$data['infMan'] = $infMan;
			$data['errEdit'] = $_SESSION['errEditMan']??[];
			$data['state'] = $_GET['state']??'';
			$data['errName'] = $_SESSION['errNameEdit']??'';

			// load header
			$header = [];
			$header['title'] = 'This is Edit Manager';
			$header['content'] = 'This is edit manager content';
			$this->loadHeader($header);
			$this->loadView('app/view/manager/edit_view.php',$data);
			$this->loadFooter();
		}
	}

	public function handleEdit(){

		if (isset($_POST['btnEditMan'])) {
			
			$idMan = $_GET['id'];
			$idMan = is_numeric($idMan)? $idMan : 0;

			$nameMan = $_POST['nameMan'];
			$nameMan = strip_tags($nameMan);

			$email = $_POST['emailMan'];
			$email = strip_tags($email);

			$status = $_POST['statusMan'];
			$status = is_numeric($status) && in_array($status, ['0','1'])?$status: 0;

			$role = $_POST['roleMan'];
			$role = is_numeric($role) && in_array($role, ['-1','0'])?$role : "";



			$dataErr = validateEditManager($nameMan,$email);
			// echo "<pre>";
			// print_r($dataErr);
			// die();

			$checkEdit = true;

			foreach ($dataErr as $key => $err) {
				if ($err != '') {
					$checkEdit = false;
					break;
				}
			}

			if ($checkEdit) {
				if (isset($_SESSION['errEditMan'])) {
						unset($_SESSION['errEditMan']);
				}
				$checkNameMan = $this->ManModel->checkNameManEdit($idMan,$nameMan);
				if ($checkNameMan) {
					$_SESSION['errNameEdit'] = $nameMan;
					header("location:?c=manager&m=edit&id=$idMan&state=exist");
				}else{
					$edit = $this->ManModel->updateDataById($idMan,$nameMan,$status,$role);
					if ($edit) {
						header('location:?c=manager');
					}else{
						header("location:?c=manager&m=edit&id=$idMan&state=err");
					}
				}
			}else{
				$_SESSION['errEditMan'] = $dataErr;
				header("location:?c=manager&m=edit&id=$idMan&state=fail");
			}

		}
	}
	public function search(){
		$keyword = $_POST['key']??'';
		$keyword = strip_tags($keyword);

		echo $keyword;
	}
	public function delete(){
		$id = $_POST['id']??'';
		$id = is_numeric($id) ? $id : 0;
		if ($id >0) {
			$del = $this->pdModel->deleteManagerById($id);
			if ($del) {
				echo "OK";
			}else{
				echo "ERR";
			}
		}else{
			echo "ERR";
		}
	}

}
$man = new ManagerController;
$method = $_GET['m']??'index';
$man->$method();