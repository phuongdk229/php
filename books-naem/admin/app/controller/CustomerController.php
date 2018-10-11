<?php
namespace App\Controller;

require 'app/core/MY_controller.php';
require 'app/model/customer_model.php';

use App\Core\MY_controller;
use App\Model\CustomerModel;
if (!defined('APP_PATH')) {
	die('can not access');
}

class CustomerController extends MY_controller{
	private $cusModel;
	function __construct(){
		parent::__construct();
		$this->cusModel = new CustomerModel();
	}
	public function infoCus(){
		$data = [];
		$keyword = $_GET['key']??'';
		$keyword = strip_tags($keyword);

		$page = $_GET['page']??'';
		$page = (is_numeric($page) && $page>0)?$page : 1;
		$link = [
			'c' => 'customer',
			'm' => 'infoCus',
			'page' => '{page}',
			'key' => $keyword
		];

		$creat_links = creat_link($link);


		$infoCus = $this->cusModel->getAllDataCus($keyword);

		// xu ly phan trang
		$pagination = pagination($creat_links,count($infoCus),$page,ROW_LIMIT,$keyword);
		$dataPage = $this->cusModel->getAllDataCusByPage($pagination['start'],$pagination['limit'],$keyword);
		// echo "<pre>";
		// print_r($infoCus);
		// die;

		$data['key'] = $keyword;
		$data['infoCus'] = $dataPage;
		$data['pageHtml'] = $pagination['htmlPage'];
		$data['limit'] = $pagination['limit'];
		$data['page'] = $page;
		// echo "<pre>";
		// print_r($infoCus);
		// die;


		$header = [];
		$header['title'] = 'This is Customer';
		$header['content'] = 'This is content Customer';
		$this->loadHeader($header);
		$this->loadView('app/view/customer/infoCus_view.php',$data);
		$this->loadFooter();		
	}
	public function pdOrder(){
		$data = [];
		$keyword = $_GET['key']??'';
		$keyword = strip_tags($keyword);

		$page = $page = $_GET['page']??'';
		$page = (is_numeric($page) && $page>0) ? $page : 1;
		$link = [
			'c' => 'customer',
			'm' => 'pdOrder',
			'page' => '{page}',
			'key' => $keyword
		];

		$creat_links = creat_link($link);


		$dataBill = $this->cusModel->getAllDataBill($keyword);
		$pagination = pagination($creat_links,count($dataBill),$page,ROW_LIMIT,$keyword);
		$dataPage = $this->cusModel->getAllDataBillByPage($pagination['start'],$pagination['limit'],$keyword);
		$data['lstCity'] = $this->cusModel->getAllDataCity();
		$data['lstDis'] = $this->cusModel->getAllDataDistrict();
		$data['key'] = $keyword;
		$data['infoCus'] = $dataPage;
		$data['pageHtml'] = $pagination['htmlPage'];
		$data['limit'] = $pagination['limit'];
		$data['page'] = $page;	

		$header = [];
		$header['title'] = 'This is Customer';
		$header['content'] = 'This is content Customer';
		$this->loadHeader($header);
		$this->loadView('app/view/customer/order_view.php',$data);
		$this->loadFooter();		
	}
	public function detailBill(){
		$idBill = $_GET['id'];
		// echo $idBill;
		$data = [];
		$data['pdOder'] = $this->cusModel->getAllPdOrder($idBill);
		$data['lstBill'] = $this->cusModel->getDataBillById($idBill);
		// echo "<pre>";
		// print_r($data['pdOder']);

		$header = [];
		$header['title'] = 'This is Customer';
		$header['content'] = 'This is content Customer';
		$this->loadHeader($header);
		$this->loadView('app/view/customer/detailBill_view.php',$data);
		$this->loadFooter();		
	}
	public function perfectOrder(){
		$idBill = $_GET['id'];
		$idMan = $_SESSION['id'];
		$bill = $this->cusModel->getDataBillById($idBill);
		$lstPd = $this->cusModel->getAllPdOrder($idBill);
		$allPd = $this->cusModel->getAllDataProduct();
		$idCus = $bill['id_cus'];
		$coinCus = $this->cusModel->getCoinCustomer($idCus);
		$money = $bill['totalMoney'];
		$note = $bill['note'];
		$coin = 0;
		// them so luong ban vao bang product
		foreach ($allPd as $key => $item) {
			foreach ($lstPd as $key => $pd) {
				if ($pd['id_product'] == $item['id']) {
					// echo $item['id'];
					$qty = $item['quanity_sell'] + $pd['quanity_pd'];
					// echo $qty;
					$updatePd = $this->cusModel->updateQtySell($qty,$item['id']);
				}
			}
		}
		if ($updatePd) {
			// xac nhan don hang va luu thong tin manager da xac nhan don hang
				$perfect = $this->cusModel->perfectOrderOfCus($idBill,$idMan);
				if ($perfect) {
					$idCus = $bill['id_cus'];
					$money = $bill['totalMoney'];
					if ($money >= 100000 && $note == 0) {
						$coin = $money/100000;
						$coin = ceil($coin);
						$coin = $coin+$coinCus['coin'];
						// tich diem cua customer
						$addCoin = $this->cusModel->updateCoinforCus($idCus,$coin);
						if ($addCoin) {
							$email = $bill['email_cus'];
							$subject = 'Website bán sách online Pbook store';
							$content = 'Đơn hàng của bạn đang trong quá trình gửi. Bạn vui lòng chờ giao hàng 2-4 ngày. Thắc mắc xin liên hệ 0169460313* hoặc Email: pbookstore229@gmail.com. Cảm ơn bạn đã tin yêu Pbook store. ';
							// gui thong bao cho cus biet 
							if (sendMailPHPMailer($email,$subject,$content)) {
								header('location:?c=customer&m=pdOrder');
							}else{
								header('location:?c=customer&m=pdOrder&state=err');
							}								
						}
					}			
				}else{
					header('location:?c=customer&m=pdOrder&state=err');
				}		
		}else{
			header('location:?c=customer&m=pdOrder&state=err');
		}
	}

	public function failOrder(){
		$idBill = $_GET['id'];
		$bill = $this->cusModel->getDataBillById($idBill);
		$delOrder = $this->cusModel->deleteOrder($idBill);
		$email = $bill['email_cus'];
		$subject = 'Website bán sách online Pbook store';
		$content = 'Đơn hàng của bạn đã bị hủy vì lí do không xác định được địa điểm ship. Thắc mắc xin liên hệ 0169460313* hoặc Email: pbookstore229@gmail.com. Cảm ơn bạn đã tin yêu Pbook store. ';
		if ($delOrder) {
			if (sendMailPHPMailer($email,$subject,$content)) {
				header('location:?c=customer&m=pdOrder');
			}else{
				header('location:?c=customer&m=pdOrder&state=err');
			}
		}else{
			header('location:?c=customer&m=pdOrder&state=err');
		}
	}
	public function getComment(){
		echo "uow";
		die;
		$data = [];
		$header = [];
		$comment = $this->CusModel->getInfoComment();
		$namePd = $this->CusModel->getNamePd();
		$data['namePro'] = $namePd;
		$data['comment'] = $comment;
		$this->LoadHeader($header);
		$this->LoadView('app/view/customer/comment_view.php',$data);
		$this->LoadFooter();		
	} 
}

$cus = new CustomerController;
$method = $_GET['m']??'infoCus';
$cus->$method();