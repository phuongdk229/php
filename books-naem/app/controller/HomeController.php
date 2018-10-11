<?php
namespace App\Controller;
if (!defined('APP_PATH')) {
	die('can not access');
}
require 'app/core/MY_controller.php';
require 'app/model/home_model.php';
use App\Core\MY_controller;
use App\Model\HomeModel;

class HomeController extends MY_controller{
	private $homeModel;
	function __construct(){
		// parent::__construct();
		$this->homeModel = new HomeModel();
	}
	public function index(){
		$bestSell = $this->homeModel->getBestSell();
		$newProduct = $this->homeModel->getNewProduct();
		// $DataCate = $this->homeModel->getDataCat();

		$data = [];
		$data['lstBestSell'] = $bestSell;
		$data['newProduct'] = $newProduct;
		$data['slide'] = $this->homeModel->getImageForSlide();

		// $data['lstCat'] = $DataCate;
		// echo "<pre>";
		// print_r($data['slide'][0]['name_pic']);
		// die;
		
		$header = [];
		$header['title'] = 'This is Home Page';
		$this->LoadHeader($header);
		$this->LoadView('app/view/home/index_view.php',$data);
		$this->LoadFooter();
		// require 'app/view/home/index_view.php';
	}

	function __call($r,$q){
		echo "not found request o day";
	}
}
$home = new HomeController;
$method = $_GET['m']??'index';
$home->$method();