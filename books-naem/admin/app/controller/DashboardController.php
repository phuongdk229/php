<?php
namespace App\Controller;
require 'app/core/MY_controller.php';
require 'app/model/dashboard_model.php';
use App\Core\MY_controller;
use App\Model\DashboardModel;

if (!defined('APP_PATH')) {
	die('can not access');
}
class DashboardController extends MY_controller{
	private $dsModel;
	function __construct(){
		parent::__construct();
		$this->dsModel = new DashboardModel;
	}
	public function index(){
		$data = [];
		$data['bestSeller'] = $this->dsModel->getFiveProBestSell();
		$data['customer'] = $this->dsModel->getInfoCus();
		$data['order'] = $this->dsModel->getOder();
		$data['comment'] = $this->dsModel->getComment(); 
		// echo "<pre>";
		// print_r($data['bestSeller']);
		// die;
		$header = [];
		$header['title']='This is Dashboard';
		$header['content'] = 'This is content dashborad';
		$this->loadHeader($header);
		$this->loadView('app/view/dashboard/index_view.php',$data);
		$this->loadFooter();
	}
}
$dashboard = new DashboardController;
$method = $_GET['m']??'index';
$dashboard -> $method();