<?php
namespace App\Controller;

require 'app/core/MY_controller.php';
// require 'app/model/cart_model.php';
require 'app/model/product_model.php';

use App\Core\MY_controller;
use App\Model\ProductModel;

if (!defined('APP_PATH')) {
	die('can not access');
}

class CartController extends MY_controller{
	private $CartModel;
	function __construct(){
		$this->CartModel = new ProductModel();
	}
	public function index(){
		// $cart = [];
		$data = [];
		$data['cart'] = $_SESSION['cartPd']??[];
		// echo "<pre>";
		// print_r($data['cart']);
		// die;
		$header = [];
		$this->LoadHeader($header);
		$this->LoadView('app/view/cart/add_view.php',$data);
		$this->LoadFooter();
	}
	public function add(){
		$idPd = $_GET['id'];
		$idPd = is_numeric($idPd) ? $idPd : 0;

		$infPd = $this->CartModel->getDetailProduct($idPd);
		if (!empty($infPd)) {
			// neu khong ton tai gio hang
			if (!isset($_SESSION['cartPd'])) {
				// tao gio hang
				$_SESSION['cartPd'][$idPd]['id'] = $idPd;
				$_SESSION['cartPd'][$idPd]['namePd'] = $infPd['name_pd'];
				if ($infPd['sale_off'] >0) {
					$_SESSION['cartPd'][$idPd]['price'] = $infPd['price_pd']-(($infPd['sale_off']*$infPd['price_pd'])/100);
				}else{
					$_SESSION['cartPd'][$idPd]['price'] = $infPd['price_pd'];
				}
				$_SESSION['cartPd'][$idPd]['price_input'] = $infPd['price_input'];
				$_SESSION['cartPd'][$idPd]['imagePd'] = $infPd['image_pd'];
				$_SESSION['cartPd'][$idPd]['qtyPd'] = 1;
			}else{
				// neu da co gio hang
				if (isset($_SESSION['cartPd'][$idPd]) && $_SESSION['cartPd'][$idPd]['id']==$idPd) {
					// ton tai sp ay trong gio hang
					$_SESSION['cartPd'][$idPd]['qtyPd'] +=1;
				}else{
					// neu khong ton tai gio hang
					$_SESSION['cartPd'][$idPd]['id'] = $idPd;
					$_SESSION['cartPd'][$idPd]['namePd'] = $infPd['name_pd'];
					if ($infPd['sale_off'] >0) {
						$_SESSION['cartPd'][$idPd]['price'] = $infPd['price_pd']-(($infPd['sale_off']*$infPd['price_pd'])/100);
					}else{
						$_SESSION['cartPd'][$idPd]['price'] = $infPd['price_pd'];
					}
					$_SESSION['cartPd'][$idPd]['price_input'] = $infPd['price_input'];
					$_SESSION['cartPd'][$idPd]['imagePd'] = $infPd['image_pd'];
					$_SESSION['cartPd'][$idPd]['qtyPd'] = 1;	
				}
			}
			// echo "<pre>";
			// print_r($_SESSION['cartPd']);
			// die;
			header("location:?c=cart");
		}else{
			echo "err";
		}

	}
	public function delete(){
		$id = $_GET['id'];
		$id = is_numeric($id) ? $id : 0;
		if (isset($_SESSION['cartPd'][$id])) {
			unset($_SESSION['cartPd'][$id]);
		}
		header("location:?c=cart&m=index");
	}
	public function remove(){
		if (isset($_SESSION['cartPd'])) {
			unset($_SESSION['cartPd']);
		}
		header("location:?c=cart");
	}
	public function ajax_cart(){
		$data = [];
		$data['mess'] = '';
		$data['id'] = '';
		$data['qty'] = '';
		$data['money'] = 0;
		$data['totalMoney'] = 0;

		$id = $_POST['id']??'';
		$id = is_numeric($id) ? $id : 0;

		$qty = $_POST['qty']??'';
		$qty = is_numeric($qty)? $qty : 0;
		if ($id == 0 || $qty == 0) {
			$data['mess'] = "ERR";
		}else{
			if (isset($_SESSION['cartPd'][$id])) {
				$_SESSION['cartPd'][$id]['qtyPd'] = $qty;
				$data['money'] = ($qty * $_SESSION['cartPd'][$id]['price']);
			}
			foreach ($_SESSION['cartPd'] as $key => $val) {
				$data['totalMoney'] += ($val['qtyPd']*$val['price']);
			}
			$data['mess'] = 'OK';
			$data['id'] = $id;
			$data['qty'] = $qty;
			$data['money'] = number_format($data['money']);
			$data['totalMoney'] = number_format($data['totalMoney']);
		}
		echo json_encode($data);
	}
}
$cart = new CartController;
$method = $_GET['m']??'index';
$cart->$method();
