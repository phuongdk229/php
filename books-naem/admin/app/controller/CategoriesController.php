<?php
namespace App\Controller;
require 'app/core/MY_controller.php';
require 'app/model/categories_model.php';

use App\Model\CategoriesModel;
use App\Core\MY_controller;

if (!defined('APP_PATH')) {
	die('can not access');
}
class CategoriesController extends MY_controller{
	private $catModel;
	function __construct(){
		parent::__construct();
		$this->catModel = new CategoriesModel;
		if (isset($_SESSION['errAddCat']) && !isset($_GET['state'])) {
			unset($_SESSION['errAddCat']);
		}
		if (isset($_GET['state']) && $_GET['state'] !== 'exist') {
			unset($_SESSION['errNameCat']);
		}
		if (isset($_SESSION['editErrCat']) && !isset($_GET['state'])) {
			unset($_SESSION['editErrCat']);
		}
		if (isset($_GET['state']) && $_GET['state'] !=='exist') {
			unset($_SESSION['errNameEdit']);
		}
	}
	public function index(){
		$data = [];
		$keyword = $_GET['key']??'';
		$keyword = strip_tags($keyword);

		$page = $_GET['page']??'';
		$page = (is_numeric($page) && $page > 0)?$page:1;

		$link = [
			'c' => 'categories',
			'm' => 'index',
			'page' => '{page}',
			'key' => $keyword
		];

		$creat_links = creat_link($link);
		$allCat = $this->catModel->getAllDataCategories($keyword);

		$pagination = pagination($creat_links,count($allCat),$page,ROW_LIMIT,$keyword);

		$dataPage = $this->catModel->getAllDataCategoriesByPage($pagination['start'],$pagination['limit'],$keyword);

		$data['lsCat'] = $dataPage;
		$data['key'] = $keyword;
		$data['pageHtml'] = $pagination['htmlPage']; 
		$data['limit'] = $pagination['limit'];
		$data['page'] = $page;
		// echo "<pre>";
		// print_r($allCat);
		// die;		
		$header = [];
		$header['title'] = 'This is Categories';
		$header['content'] = 'This is content categories';
		$this->loadHeader($header);
		$this->loadView('app/view/categories/index_view.php',$data);
		$this->loadFooter();
	}
	public function delete(){
		$id = $_POST['id'];
		$id = is_numeric($id) ? $id : 0;
		if ($id >0) {
			$del = $this->catModel->deleteCateById($id);
			if ($del) {
				echo "OK";
			}else{
				echo "ERR";
			}
		}else{
			echo "ERR";
		}
	}
	public function add(){
		$data = [];
		$data['errAdd'] = $_SESSION['errAddCat']??[];
		$data['errName'] = $_SESSION['errNameCat']??'';
		$data['state'] = $_GET['state']??'';

		$header = [];
		$header['title'] = 'This is Adding Categories';
		$header['content'] = 'This is Adding content';
		$this->loadHeader($header);
		$this->loadView('app/view/categories/add_view.php',$data);
		$this->loadFooter();
	}
	public function handleAdd(){
		if (isset($_POST['btnAdd'])) {
			$nameCat = $_POST['nameCat']??'';
			$nameCat = strip_tags($nameCat);

			$dataErr = validateAddCategories($nameCat);
			$checkAdd = true;
			foreach ($dataErr as $key => $err) {
				
				if ($err != '') {
					$checkAdd = false;
					break;
				}
			}
			if ($checkAdd) {
				if (isset($_SESSION['errAddCat'])) {
					unset($_SESSION['errAddCat']);
				}
				$checkName = $this->catModel->checkNameCat($nameCat);
				if ($checkName) {
					$_SESSION['errNameCat'] = $nameCat;
					header('location:?c=categories&m=add&state=exist');
				}else{
					if (isset($_SESSION['errNameCat'])) {
						unset($_SESSION['errNameCat']);
					}
					$add = $this->catModel->addDataCategories($nameCat);
					if ($add) {
						header("location:?c=categories");
					}else{
						header("location:?c=product&m=add&state=err");
					}					
				}

			}else{
				$_SESSION['errAddCat'] = $dataErr;
				header("location:?c=categories&m=add&state=fail");
			}
		}
	}
	public function edit(){
		$id_cat = $_GET['id'];
		$id_cat = is_numeric($id_cat) ? $id_cat : 0;
		// echo $id_cat;
		// die;
		$infCat = $this->catModel->getInfDataById($id_cat);
		if (!empty($infCat)) {
			$data = [];
			$data['info'] = $infCat;
			$data['errEdit'] = $_SESSION['editErrCat'] ?? [];
			$data['errName'] = $_SESSION['errNameEdit']??'';
			$data['state'] = $_GET['state']??'';

			// load header
			$header = [];
			$header['title'] = 'This is Editing Categories';
			$header['content'] = 'This is content edit categories';
			$this->loadHeader($header);
			$this->loadView('app/view/categories/edit_view.php',$data);
			$this->loadFooter();
		}else{
			$header['title'] = 'Not found page';
			$header['content'] = 'Err page';
			$this->loadHeader($header);
			$this->loadView('app/view/error/error_view.php');
			$this->loadFooter();
		}
	}

	public function handleEdit(){
		if (isset($_POST['btnEdit'])) {
			$nameCat = $_POST['nameCat']??'';
			$nameCat = strip_tags($nameCat);

			$status = $_POST['rStatus'];
			$status = is_numeric($status) ? $status : 0;

			$id_cat = $_GET['id'] ?? '';
			$id_cat = is_numeric($id_cat) ? $id_cat:0;

			$infCat = $this->catModel->getInfDataById($id_cat);
			$dataErr = validateAddCategories($nameCat);
			// echo "<pre>";
			// print_r($dataErr);
			// die;
			$checkEdit = true;
			foreach ($dataErr as $key => $err) {
				if ($err != '') {
					$checkEdit = false;
					break;
				}
			}

			if ($checkEdit) {
				if (isset($_SESSION['editErrCat'])) {
					unset($_SESSION['editErrCat']);
				}
				$checkNameCat = $this->catModel->checkEditNameById($id_cat,$nameCat);
				if ($checkNameCat) {
					$_SESSION['errNameEdit'] = $nameCat;
					header("location:?c=categories&m=edit&id=$id_cat&state=exist");
				}else{
					$edit = $this->catModel->updateDataById($id_cat,$nameCat,$status);
					if ($edit) {
						header('location:?c=categories');
					}else{
						header("location:?c=categories&m=edit&id=$id_cat&state=err");
					}
				}
			}else{
				$_SESSION['editErrCat'] = $dataErr;
				header("location:?c=categories&m=edit&id=$id_cat&state=fail");
			}
		}
	}
	public function search(){
		$keyword = $_POST['key']??'';
		$keyword = strip_tags($keyword);
		echo $keyword;
	}

}
$cat = new CategoriesController;
$method = $_GET['m']??'index';
$cat->$method();