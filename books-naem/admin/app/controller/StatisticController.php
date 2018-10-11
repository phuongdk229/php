<?php
namespace App\Controller;

require 'app/core/MY_controller.php';
require 'app/model/statistic_model.php';

use App\Core\MY_controller;
use App\Model\StatisticModel;

if (!defined('APP_PATH')) {
	die('can not access');
}
class StatisticController extends MY_controller{
	private $stModel;
	function __construct(){
		parent::__construct();
		$this->stModel = new StatisticModel();
		if (isset($_SESSION['errStc']) && !isset($_GET['state'])) {
			unset($_SESSION['errStc']);
		}
	}
	public function index(){

		$data = [];
		$data['err'] = $_SESSION['errStc']??[];
		$data['profit'] = $_SESSION['profit']??[];
		$data['inventory'] = $_SESSION['inventory']??[];
		$data['customer'] = $_SESSION['customer']??[];
		$header = [];
		$header['title'] = 'This is statistic';
		$header['content'] = 'This is content Statistic';
		$this->loadHeader($header);
		$this->loadView('app/view/statistic/index_view.php',$data);
		$this->loadFooter();		
	}
	public function handle(){
		if (isset($_POST['btnSubmit'])) {
			$data = [];
			$dateFrom = $_POST['txtfrom']??'';
			$dateTo = $_POST['txtTo']??'';
			$nameStc = $_POST['item']??'';
			$dataErr = validateStc($dateFrom,$dateTo,$nameStc);
			$checkErr = true;
			foreach ($dataErr as $key => $err) {
			 	if ($err != '') {
			 		$checkErr = false;
			 		break;
			 	}
			}
			if ($checkErr) {
			 	if ($nameStc == 1) {
			 		if (isset($_SESSION['inventory'])) {
			 			unset($_SESSION['inventory']);
			 		}elseif(isset($_SESSION['customer'])){
			 			unset($_SESSION['customer']);
			 		}
			 		$profit = $this->stModel->getDataDetailBill($dateFrom,$dateTo);
			 		$_SESSION['profit'] = $profit;
			 		header('location:?c=statistic&m=index');
			 	}elseif($nameStc == 2){
			 		if (isset($_SESSION['profit'])) {
			 			unset($_SESSION['profit']);
			 		}elseif(isset($_SESSION['customer'])){
			 			unset($_SESSION['customer']);
			 		}			 		
			 		$inventory = $this->stModel->getDataProduct($dateFrom,$dateTo);
			 		$_SESSION['inventory']= $inventory;
			 		header('location:?c=statistic&m=index');
			 	}elseif($nameStc == 3){
			 		if (isset($_SESSION['profit'])) {
			 			unset($_SESSION['profit']);
			 		}elseif(isset($_SESSION['inventory'])){
			 			unset($_SESSION['inventory']);
			 		}			 		
			 		$customer = $this->stModel->getDataCustomer($dateFrom,$dateTo);
					// echo "<pre>";
					// print_r($customer);
					$_SESSION['customer'] = $customer;
					header('location:?c=statistic&m=index');
				}		
			}
			else{
				$_SESSION['errStc'] = $dataErr;
				header('location:?c=statistic&m=index&state=fail');
			} 
		}
	}

}
$st = new StatisticController;
$method = $_GET['m']??'index';
$st->$method();