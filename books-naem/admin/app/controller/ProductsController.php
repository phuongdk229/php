<?php
namespace App\Controller;

require 'app/core/MY_controller.php';
require 'app/model/product_model.php';

use App\Core\MY_controller;
use App\Model\ProductModel;

if (!defined('APP_PATH')) {
	die('can not access');
}
class ProductController extends MY_controller{
	private $pdModel;
	function __construct(){
		parent::__construct();
		$this->pdModel = new ProductModel();
		if (isset($_SESSION['errAddPd'])  && !isset($_GET['state'])) {
			unset($_SESSION['errAddPd']);		
		}
		if (isset($_GET['state']) && $_GET['state'] !=='exist') {
			unset($_SESSION['errNamePd']);
			unset($_SESSION['errName']);
		}
		if (isset($_SESSION['errPic'])&& !isset($_GET['state'])) {
			unset($_SESSION['errPic']);
		}
	}
	public function index(){
		$data = [];
		$keyword = $_GET['key']??'';
		$keyword = strip_tags($keyword);

		$page = $_GET['page']??'';
		$page = (is_numeric($page) && $page > 0 ) ? $page : 1;

		$link = [
			'c' => 'product',
			'm' => 'index',
			'page' => '{page}',
			'key' => $keyword
		];
		$creat_link = creat_link($link);
		$allPd = $this->pdModel->getAllDataProduct($keyword);
		// echo "<pre>";
		// print_r($allPd);
		// die;
		$pagination = pagination($creat_link,count($allPd),$page,ROW_LIMIT,$keyword);
		$dataPage = $this->pdModel->getAllDataProductByPage($pagination['start'],$pagination['limit'],$keyword);

		$data['lsPd']=$dataPage;
		$data['name'] = 'Duong Thi Kim Phuong';
		$data['age'] = 20;
		$data['key'] = $keyword;
		$data['pageHtml'] = $pagination['htmlPage'];
		$data['limit'] = $pagination['limit'];
		$data['page'] = $page;

		// echo "<pre>";
		// print_r($allPd);
		// die;

		$header = [];
		$header['title'] = 'This is product';
		$header['content'] = 'This is content Product';
		$this->loadHeader($header);
		$this->loadView('app/view/product/index_view.php',$data);
		$this->loadFooter();

	}
	public function delete(){
		$id = $_POST['id']??'';
		$id = is_numeric($id) ? $id : 0;
		if ($id >0) {
			$del = $this->pdModel->deleteProductById($id);
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
		$data['lstCat'] = $this->pdModel->getAllDataCategories();
		$data['errAdd'] = $_SESSION['errAddPd']??[];
		$data['state'] = $_GET['state']??'';
		$data['errName'] = $_SESSION['errNamePd']??'';

		$header = [];
		$header['title'] = 'This is Adding Products';
		$header['content'] = 'This is Adding content';

		$this->loadHeader($header);
		$this->loadView('app/view/product/add_view.php',$data);
		$this->loadFooter();
	}
	public function handleAdd(){
		if (isset($_POST['btnAdd'])) {
			$namePd = $_POST['namePd']??'';
			$namePd = strip_tags($namePd);

			$catPd = $_POST['slcCat']??'';
			$catPd = is_numeric($catPd) ? $catPd : 0;

			$priceInput = $_POST['inputPrice']??'';
			$priceInput = strip_tags($priceInput);
			$priceInput = is_numeric($priceInput) ? $priceInput : 0;

			$pricePd = $_POST['pricePd']??'';
			$pricePd = strip_tags($pricePd);
			$pricePd = is_numeric($pricePd) ? $pricePd : 0;

			$sale_off = $_POST['sale_off']??'';
			$sale_off = strip_tags($sale_off);
			$sale_off = is_numeric($sale_off) ? $sale_off : 0;

			$qty = $_POST['qtyPd']??'';
			$qty = is_numeric($qty)? $qty :0;

			$desPd = $_POST['desPd']??'';

			$imagePd = null;
			if (isset($_FILES['imagePd'])) {
				$imagePd = uploadFileData($_FILES['imagePd']);
			}
			$dataErr = validateAddProduct($namePd,$catPd,$priceInput,$pricePd,$qty,$desPd,$imagePd);
			// echo "<pre>";
		 //  	print_r($dataErr);
		 //  	die;
			$checkAdd = true;
			foreach ($dataErr as $key => $err) {
				if ($err != '') {
					$checkAdd = false;
					break;
				}
			}

			if ($checkAdd) {
				if (isset($_SESSION['errAddPd'])) {
					unset($_SESSION['errAddPd']);
				}
				$checkName = $this->pdModel->checkNamePdExist($namePd);
				if ($checkName) {
					$_SESSION['errNamePd'] = $namePd;
					header("location:?c=product&m=add&state=exist");
				}else{
					if (isset($_SESSION['errNamePd'])) {
						unset($_SESSION['errNamePd']);
					}
					$add = $this->pdModel->addDataProduct($namePd,$catPd,$priceInput,$pricePd,$qty,$desPd,$imagePd,$sale_off);
					if ($add) {
						header('location:?c=product');
					}else{
						header('location:?c=product&m=add&state=err');
					}					
				}
				
			}else{
				$_SESSION['errAddPd'] = $dataErr;
				header('location:?c=product&m=add&state=fail');
			}
		}
	}
	public function edit(){
		$id_pd = $_GET['id'];
		$id_pd = is_numeric($id_pd) ? $id_pd : 0;
		$infPd = $this->pdModel->getInfDataById($id_pd);
		if (!empty($infPd)) {
			$data = [];
			$data['inf'] = $infPd;
			$data['lstCat'] = $this->pdModel->getAllDataCategories();
			$data['errEdit'] = $_SESSION['errEditPd']??[];
			$data['errName'] = $_SESSION['errNameEditPd']??'';

			// load header
			$header = [];
			$header['title'] = 'This is Editting Product';
			$header['content'] = 'This is content edit product';
			$this->loadHeader($header);
			$this->loadView('app/view/product/edit_view.php',$data);
			$this->loadFooter();
		}else{
			$header = [];
			$header['title'] = 'Not found page';
			$header['content'] = 'Err page';
			$this->loadHeader($header);
			$this->loadView('app/view/error/error_view.php');
			$this->loadFooter();
		}
	}

	public function handleEdit(){
		if (isset($_POST['btnEdit'])) {
			$namePd = $_POST['namePd']??'';
			$namePd = strip_tags($namePd);

			$catPd = $_POST['slcCat'];
			$catPd = is_numeric($catPd)? $catPd : 0;

			$priceInput = $_POST['inputPrice']??'';
			$priceInput = strip_tags($priceInput);
			$priceInput = is_numeric($priceInput)? $priceInput:0;

			$pricePd = $_POST['pricePd']??'';
			$pricePd = strip_tags($pricePd);
			$pricePd = is_numeric($pricePd)? $pricePd:0;
			$sale_off = $_POST['sale_off']??'';
			$sale_off = strip_tags($sale_off);
			$sale_off = is_numeric($sale_off)? $sale_off:0;

			$qty = $_POST['qtyPd']??'';
			$qty = is_numeric($qty)? $qty : 0;

			$desPd = $_POST['desPd']??'';

			$status = $_POST['statusPd']??'';
			$status = is_numeric($status) && in_array($status, [0,1]) ? $status : 0; 

			$id_pd = $_GET['id']??'';
			$id_pd = is_numeric($id_pd) ? $id_pd : 0;

			$infPd = $this->pdModel->getInfDataById($id_pd);

			$nameImage = $infPd['image_pd'];

			// neu nguoi dung muon thay doi anh thi kiem tra
			if (isset($_FILES['imagePd']) && !empty($_FILES['imagePd'])) {
				if (isset($_FILES['imagePd']['name']) && !empty($_FILES['imagePd']['name'])) {
					$nameImage = uploadFileData($_FILES['imagePd']);
				}
			}

			$dataErr = validateAddProduct($namePd,$catPd,$priceInput,$pricePd,$qty,$desPd,$nameImage);

			$checkEdit = true;
			foreach ($dataErr as $key => $err) {
				if (!empty($err)) {
					$checkEdit = false;
				}
			}

			if ($checkEdit) {
				if (isset($_SESSION['errEditPd'])) {
					unset($_SESSION['errEditPd']);
				}
				$checkEditNamePd = $this->pdModel->checkEditNamePd($id_pd,$namePd);
				if ($checkEditNamePd) {
					$_SESSION['errNameEditPd'] = $namePd;
					header("location:?c=product&m=edit$id=$id_pd&state=exist");
				}else{
					$edit = $this->pdModel->updateDataById($id_pd,$namePd,$catPd,$priceInput,$pricePd,$sale_off,$qty,$desPd,$nameImage,$status);
					if ($edit) {
						header('location:?c=product');
					}else{
						header("location:?c=product&m=edit&id=$id_pd&state=err");
					}
				}
			}else{
				$_SESSION['errEditPd'] = $dataErr;
				header("location:?c=product&m=edit&id=$id_pd&state=fail");
			}

		}
	}
	public function searchCategories(){
		$keyword = $_POST['key']??'';
		$keyword = strip_tags($keyword);
		echo $keyword;
	}
	public function addNew(){
		$data = [];
		$data['errPic'] = $_SESSION['errPic']??[];
		// echo $data['errPic'];
		// die;
		$data['state'] = $_GET['state']??[];
		$data['errName'] = $_SESSION['errName']??[];
		$header = [];
		$header['title'] = 'This is product';
		$header['content'] = 'This is content Product';
		$this->loadHeader($header);
		$this->loadView('app/view/product/addNew_view.php',$data);
		$this->loadFooter();		
	}
	public function handleNew(){
		if (isset($_POST['btnSubmit'])) {
			$pic = null;
			// $dataErr = validateImgae($pic1,$pic2,$pic3);
			// $imagePd = null;
			if (isset($_FILES['imageBan'])) {
				$pic = uploadFileData($_FILES['imageBan']);
			}
			// echo $pic;
			// die;
			// $dataErr = validateImgae($pic);

			if (!empty($pic)) {
				// neu ton tai looi pic xoa loi
				if (isset($_SESSION['errPic'])) {
					unset($_SESSION['errPic']);
				}
				// kiem tra ten co nam trong sql khong
				$checkNamePic = $this->pdModel->checkNamePic($pic);
				// neu co thi bao loi
				if ($checkNamePic) {
					$_SESSION['errName'] = $pic;
					echo $_SESSION['errName'];
					header('location:?c=product&m=addNew&state=exist1');
				}else{

					if (isset($_SESSION['errName'])) {
						unset($_SESSION['errName']);
					}
					// neu khong neu them pic1
					$add = $this->pdModel->addPic($pic);
					if ($add) {
						header('location:?c=product&m=index');
					}else{
						header('location:?c=product&m=addNew&state=err');
					}					
				}
				
			}
			else{
				$_SESSION['errPic'] = 'Choose image';
				// echo $_SESSION['errPic'];
				// die;
				header('location:?c=product&m=addNew&state=fail');
			}		
		}

	}
}
$pd = new ProductController;
$method = $_GET['m']??'index';
$pd->$method();