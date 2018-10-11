<?php
namespace App\Controller;

require 'app/core/MY_controller.php';
require 'app/model/product_model.php';

use App\Model\ProductModel;
use App\Core\MY_controller;

if (!defined('APP_PATH')) {
	die('can not access');
}
class ProductController extends MY_controller{
	private $PdModel;
	function __construct(){
		$this->PdModel = new ProductModel();
	}
	public function detail(){
		$idPd = $_GET['id']??'';

		$detail = $this->PdModel->getDetailProduct($idPd);
		// echo "<pre>";
		// print_r($detail['cat_id']);
		// die;
		$catPd = $detail['cat_id'];
		$withKind = $this->PdModel->getCatProduct($idPd,$catPd);
		$data = [];
		$data['detail'] = $detail;
		$data['withKind'] = $withKind;
		$data['comment'] = $this->PdModel->getAllComment($idPd);

		$header = [];
		$this->LoadHeader($header);
		$this->LoadView('app/view/product/detail_view.php',$data);
		$this->LoadFooter();
	}
	public function literary(){
		$idCat = 4;
		$data = [];
		$header = [];

		$page = $_GET['page']??'';
		$page = (is_numeric($page) && $page > 0) ? $page : 1;
		
		$link = [
			'c' => 'product',
			'm' => 'literary',
			'page' =>'{page}'
		];
		$creat_link = creat_link($link);

		$lstLit = $this->PdModel->getLstPro($idCat);
		$pagination = pagination($creat_link,count($lstLit),$page,ROW_LIMIT);
		// echo "<pre>";
		// print_r($pagination);
		// var_dump($pagination);
		// die;
		$dataPage = $this->PdModel->getLstProByPage($idCat,$pagination['start'],$pagination['limit']);
		$nameCat = $this->PdModel->getNameCat($idCat);
		// echo "<pre>";
		// print_r($lstLit);
		
		$data['lstLit'] = $dataPage;
		$data['pageHtml'] = $pagination['htmlPage'];
		$data['limit'] = $pagination['limit'];
		$data['page'] = $page;
		$data['nameCat'] = $nameCat;
		// echo "<pre>";
		// print_r($data['nameCat']);
		// die;
		$header['title'] ='This is list literary';
		$header['content'] = 'This is content literary';
		$this->LoadHeader($header);
		$this->LoadView('app/view/product/listProduct_view.php',$data);
		$this->LoadFooter();
	}
	public function science(){
		$idCat = 5;
		$data = [];
		$header = [];

		$page = $_GET['page']??'';
		$page = (is_numeric($page) && $page > 0) ? $page : 1;
		
		$link = [
			'c' => 'product',
			'm' => 'literary',
			'page' =>'{page}'
		];
		$creat_link = creat_link($link);

		$lstSci = $this->PdModel->getLstPro($idCat);
		$pagination = pagination($creat_link,count($lstSci),$page,ROW_LIMIT);
		$dataPage = $this->PdModel->getLstProByPage($idCat,$pagination['start'],$pagination['limit']);

		$nameCat = $this->PdModel->getNameCat($idCat);
		$data['lstSci'] = $dataPage;
		$data['pageHtml'] = $pagination['htmlPage'];
		$data['limit'] = $pagination['limit'];
		$data['page'] = $page;		
		$data['nameCat'] = $nameCat;

		// echo "<pre>";
		// print_r($lstSci);
		$header['title'] ='This is list literary';
		$header['content'] = 'This is content literary';
		$this->LoadHeader($header);
		$this->LoadView('app/view/product/listProduct_view.php',$data);
		$this->LoadFooter();
	}
	public function skill(){
		$idCat = 3;
		$data = [];
		$header = [];

		$page = $_GET['page']??'';
		$page = (is_numeric($page) && $page > 0) ? $page : 1;
		
		$link = [
			'c' => 'product',
			'm' => 'literary',
			'page' =>'{page}'
		];
		$creat_link = creat_link($link);

		$lstSkill = $this->PdModel->getLstPro($idCat);
		$pagination = pagination($creat_link,count($lstSkill),$page,ROW_LIMIT);
		$dataPage = $this->PdModel->getLstProByPage($idCat,$pagination['start'],$pagination['limit']);
		$nameCat = $this->PdModel->getNameCat($idCat);
		// echo "<pre>";
		// print_r($lstSkill);
		$data['lstSkill'] = $dataPage;
		$data['pageHtml'] = $pagination['htmlPage'];
		$data['limit'] = $pagination['limit'];
		$data['page'] = $page;		
		$data['nameCat'] = $nameCat;
		$header['title'] ='This is list literary';
		$header['content'] = 'This is content literary';
		$this->LoadHeader($header);
		$this->LoadView('app/view/product/listProduct_view.php',$data);
		$this->LoadFooter();
	}
	public function children(){
		$idCat = 1;
		$data = [];
		$header = [];

		$page = $_GET['page']??'';
		$page = (is_numeric($page) && $page > 0) ? $page : 1;
		
		$link = [
			'c' => 'product',
			'm' => 'literary',
			'page' =>'{page}'
		];
		$creat_link = creat_link($link);

		$lstChil = $this->PdModel->getLstPro($idCat);
		$pagination = pagination($creat_link,count($lstChil),$page,ROW_LIMIT);
		$dataPage = $this->PdModel->getLstProByPage($idCat,$pagination['start'],$pagination['limit']);
		$nameCat = $this->PdModel->getNameCat($idCat);
		// echo "<pre>";
		// print_r($lstChil);
		$data['lstChil'] = $dataPage;
		$data['pageHtml'] = $pagination['htmlPage'];
		$data['limit'] = $pagination['limit'];
		$data['page'] = $page;		
		$data['nameCat'] = $nameCat;
		$header['title'] ='This is list literary';
		$header['content'] = 'This is content literary';
		$this->LoadHeader($header);
		$this->LoadView('app/view/product/listProduct_view.php',$data);
		$this->LoadFooter();		
	}
	public function technology(){
		$idCat = 6;
		$data = [];
		$header = [];

		$page = $_GET['page']??'';
		$page = (is_numeric($page) && $page > 0) ? $page : 1;
		
		$link = [
			'c' => 'product',
			'm' => 'literary',
			'page' =>'{page}'
		];
		$creat_link = creat_link($link);

		$lstTech = $this->PdModel->getLstPro($idCat);
		$pagination = pagination($creat_link,count($lstTech),$page,ROW_LIMIT);
		$dataPage = $this->PdModel->getLstProByPage($idCat,$pagination['start'],$pagination['limit']);
		$nameCat = $this->PdModel->getNameCat($idCat);
		// echo "<pre>";
		// print_r($lstTech);
		$data['lstTech'] = $dataPage;
		$data['pageHtml'] = $pagination['htmlPage'];
		$data['limit'] = $pagination['limit'];
		$data['page'] = $page;	
		$data['nameCat'] = $nameCat;
		$header['title'] ='This is list literary';
		$header['content'] = 'This is content literary';
		$this->LoadHeader($header);
		$this->LoadView('app/view/product/listProduct_view.php',$data);
		$this->LoadFooter();		
	}
	public function search(){
		$keyword = $_POST['key']??'';
		$keyword = strip_tags($keyword);

		$data['lstPd'] = $this->PdModel->getAllDataProduct($keyword);
		$this->loadView('app/view/product/search_view.php',$data);

		// echo $keyword;
	}
	public function handleCom(){
		$idCus = $_SESSION['id_cus']??'';
		$idCus = is_numeric($idCus)? $idCus : 0;
		$idPd = $_POST['idPd']??'';
		$idPd = is_numeric($idPd)? $idPd : 0;
		$content = $_POST['content']??'';
		$nameCus = $_SESSION['name_cus']??'';
		// echo $idPd;
		if ($content != '') {
			$addComment = $this->PdModel->addComment($idCus,$idPd,$content,$nameCus);
			if ($addComment) {
				header("location:?c=product&m=detail&id={$idPs}");
			}else{
				header("location:?c=product&m=detail&id={$idPs}&state=fail");
			}
		}
	}
}
$pro = new ProductController;
$m = $_GET['m']??'detail';
$pro ->$m();
