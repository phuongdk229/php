<?php
namespace App\Controller;
require 'app/core/MY_controller.php';
require 'app/model/customer_model.php';
// require '../admin/app/helper/mail/src/Exception.php';
// require '../admin/app/helper/mail/src/PHPMailer.php';
// require '../admin/app/helper/mail/src/SMTP.php';
// require '../admin/app/helper/mail/sendmail_helper.php';

use App\Core\MY_controller;
use App\Model\CustomerModel;
class CustomerController extends MY_controller{
	private $CusModel;
	function __construct(){
		$this->CusModel = new CustomerModel();
		if (isset($_SESSION['errAddCus']) && !isset($_GET['state'])) {
			unset($_SESSION['errAddCus']);
		}
		if (isset($_GET['state'])&& $_GET['state'] !== 'exist') {
			unset($_SESSION['errEmailCus']);
		}
	}
	public function register(){
		$data = [];
		$header = [];
		$header['title'] = "This is form register";

		$city = $this->CusModel->getDataCity();
		if ($city != []) {
			$data['city'] = $city;
		}
		$data['errAdd'] = $_SESSION['errAddCus']??[];
		$data['state'] = $_GET['state']??'';
		$data['errEmail'] = $_SESSION['errEmailCus']??'';
		// echo "<pre>";
		// print_r($data['city']);
		// die;
		$this->LoadHeader($header);
		$this->LoadView('app/view/customer/register_view.php',$data);
		$this->LoadFooter();
	}
	public function ajax_city(){

		$id = $_POST['id'];
		$district = $this->CusModel->getDataDistrict($id);
		foreach ($district as $key => $item) {
			echo "<option value='{$item['id']}'>{$item['name_dis']}</option>";
		}	
	}
	public function ajax_ship(){
		$idCity = $_POST['idCity'];
		$ship = $this->CusModel->getShipPay($idCity);
		echo number_format($ship['ship_pay']);
	}
	public function ajax_pay(){
		$idCity = $_POST['idCity'];
		$coinCus = $_POST['coinCustomer']??'';
		$coinCus = $coinCus*1000;
		// echo $coinCus;
		// die;
		$sumMoney =0;
		foreach ($_SESSION['cartPd'] as $key => $val) {
			$sumMoney += ($val['price']*$val['qtyPd']);
		}
		$ship = $this->CusModel->getShipPay($idCity);
		if ($sumMoney >= 500000) {
			$pay = $sumMoney;
		}else{
			$pay = $ship['ship_pay']+$sumMoney-$coinCus;
		}
		
		 
		echo number_format($pay);
	}

	public function handleBill(){
		$idCity = $_POST['idCity'];
		$idDis = $_POST['idDis'];
		$coinCus = $_POST['coinCus'];
		
		$ship = $this->CusModel->getShipPay($idCity);
		$shipPay = $ship['ship_pay'];
		$sumMoney = 0;
		$note = null;
		if (isset($_SESSION['id_cus'])) {
			$idCus = $_SESSION['id_cus'];
			$nameCus = $_SESSION['name_cus'];
			$emailCus = $_SESSION['email_cus'];
			$phoneCus = $_SESSION['phone_cus'];
			$addCus = $_SESSION['address_cus'];
		}
		$cart = $_SESSION['cartPd'];
		foreach ($cart as $key => $item) {
			$sumMoney += ($item['price']*$item['qtyPd']);
		}
		// $payment = $sumMoney + $shipPay;
		if ($sumMoney >= 500000) {
			$payment = $sumMoney;
			$note = 'Free ship';
		}else{
			$payment = $shipPay+$sumMoney-$coinCus;
			$note = $coinCus;
		}
		$dataErr = validateCustomer($emailCus,$nameCus,$phoneCus,$addCus);
		// echo "<pre>";
		// print_r($dataErr);
		// die;
		$checkCus = true;
		foreach ($dataErr as $key => $err) {
			if ($err != '') {
				$checkCus = false;
				break;
			}
		}

		if ($checkCus) {
			// them sp dat vao bang hoa don
			$bill = $this->CusModel->AddDataBill($idCus,$nameCus,$emailCus,$addCus,$idCity,$idDis,$phoneCus,$sumMoney,$payment,$note);
			// tru diem cho khach
			$MinusCoin = $this->CusModel->updateCoinforCus($idCus);
			if ($bill != '') {
				// header("location:?c=customer&m=register&state=success");
				$id_bill= $bill;
				// echo $id_bill;
				// die;
				// $id_bill = settype($id_bill,'int');

				foreach ($_SESSION['cartPd'] as $key => $item) {
					$totalMoney = $item['price']*$item['qtyPd'];
					// $id_product = $item['id']??'';
					// $id_product = is_numeric($id_product)? $id_product : 0;
					$detailbill = $this->CusModel->AddDataBillDetail($id_bill,$item['id'],$item['namePd'],$item['qtyPd'],$item['price'],$item['price_input'],$totalMoney);
				}
				// echo "<pre>";
				// print_r($detailbill);
				// die;
				if ($detailbill) {
					echo "Đặt hàng thành công-Quý khách vui lòng theo dõi gmail để biết thông tin về đơn hàng ";
					if (isset($_SESSION['cartPd'])) {
						unset($_SESSION['cartPd']);
					}
				}else{
					echo "khong them duoc";
				}
				

			}else{
				// header("location:?c=customer&m=register&state=err");
				echo "khong insert vao csdl duoc";
			}
		}else{
			// header("location:?c=customer&m=register&state=fail");
			echo "bo trong mot so thu";
		}
	}
	public function cancelOder(){
		$idBill = $_GET['id'];
		$delete = $this->CusModel->deleteOrder($idBill);
		if ($delete) {
			header('location:?c=customer&m=infoCus&state=success');
		}else{
			header('location:?c=customer&m=infoCus&state=err');
		}
	}

	public function addCustomer(){
		$data = [];
		$data['errAdd'] = $_SESSION['errAddCus']??[];
		$data['state'] = $_GET['state']??'';
		$data['errEmail'] = $_SESSION['errEmailCus']??'';
		$header = [];
		$header['title'] = "This is form register";
		$this->LoadHeader($header);
		$this->LoadView('app/view/customer/addCustomer_view.php',$data);
		$this->LoadFooter();
	}
	public function handleAddCus(){
		if (isset($_POST['btnRegister'])) {
				if (isset($_SESSION['resCus'])) {
					unset($_SESSION['resCus']);
				}

			$emailCus = $_POST['txtEmailCus']??'';
			$nameCus = $_POST['txtNameCus']??'';
			$passCus = $_POST['txtPassCus']??'';
			$addressCus = $_POST['addressCus']??'';
			$phoneCus = $_POST['phoneCus']??'';
			$dataErr = validateDataBestCus($emailCus,$nameCus,$passCus,$addressCus,$phoneCus);
			// echo "<pre>";
			// print_r($dataErr);
			// die;
			$checkCus = true;
			foreach ($dataErr as $key => $err) {
				if ($err != '') {
					$checkCus = false;
					break;
				}
			}
			// if ($checkCus) {
			// $email = $emailCus;
			// 		// echo $email;
			// 		// die;
			// 		$subject = 'Website bán sách online Pbook store';
			// 		$content = 'Quý khách đã đăng ký thành công tài khoản khách hàng thân thiết của cửa hàng sách Pbook store. Cảm ơn quý khách đã tin tưởng';
			// 		if (sendMailPHPMailer($email,$subject,$content)) {
			// 			header('location:?c=customer&m=register');
			// 		}else{
			// 			header('location:?c=customer&m=register&state=err');
			// 		}	
			// }else{
			// 	header('location:?c=customer&m=register&state=fail');
			// }
			if ($checkCus) {
				if (isset($_SESSION['errAddCus'])) {
					unset($_SESSION['errAddCus']);
				}
				$checkEmail = $this->CusModel->checkEmailCusExit($emailCus);
				if ($checkEmail) {
					$_SESSION['errEmailCus'] = $emailCus;
					header('location:?c=customer&m=register&state=exist');
				}else{
					$passCus = md5($passCus);
					$sec = rand(100,999);
					// echo $sec;
					// die;
					// xu lý gui tin nhan xac nhan trong email qua ma so
					if (!isset($_SESSION['resCus'])) {
						$_SESSION['resCus']['nameCus'] = $nameCus;
						$_SESSION['resCus']['emailCus'] = $emailCus;
						$_SESSION['resCus']['passCus'] = $passCus;
						$_SESSION['resCus']['addressCus'] = $addressCus;
						$_SESSION['resCus']['phoneCus'] = $phoneCus;
						$_SESSION['resCus']['security'] = $sec;
						// echo "<pre>";
						// print_r($_SESSION['resCus']);


					}
					// die;
					$email = $emailCus;
							// echo $email;
							// die;
							$subject = 'Website bán sách online Pbook store';
							// $content = 'Quý khách đã đăng ký thành công tài khoản khách hàng thân thiết của cửa hàng sách Pbook store. Cảm ơn quý khách đã tin tưởng';
							$content = '<b>'.$_SESSION['resCus']['security'].'</b> là mã xác nhận tài khoản của quý khách tại Pbook store.';
							// echo $content;
							// die;
							if (sendMailPHPMailer($email,$subject,$content)) {
								header('location:?c=customer&m=countDown');
							}else{
								header('location:?c=customer&m=register&state=err');
							}

						// echo "<pre>";
						// print_r($_SESSION['resCus']);

					// $addCus = $this->CusModel->AddDataCustomer($nameCus,$emailCus,$passCus,$addressCus,$phoneCus);
					// echo "<pre>";
					// print_r($addCus);
					// if ($addCus) {
					// 	$email = $emailCus;
					// 	$subject = 'Website bán sách online Pbook Store';
					// 	$content = 'Quý khách đã đăng ký thành công tài khoản khách hàng thân thiết của cửa hàng sách Pbook store. Cảm ơn quý khách đã tin tưởng ';
					// 	if (sendMailPHPMailer($email,$subject,$content)) {
					// 		header('location:?c=customer&m=register');
					// 	}else{
					// 		header('location:?c=customer&m=register&state=err');
					// 	}
					// }else{
					// 	header('location:?c=customer&m=register&state=err');
					// }
				}
			}else{
				$_SESSION['errAddCus'] = $dataErr;
				header('location:?c=customer&m=register&state=fail');
			}
		}
	}
	public function handleAddCusOnMenu(){
		if (isset($_POST['btnSubmit'])) {
			if (isset($_SESSION['resCus'])) {
				unset($_SESSION['resCus']);
			}
			$emailCus = $_POST['txtEmailCus']??'';
			$nameCus = $_POST['txtNameCus']??'';
			$passCus = $_POST['txtPassCus']??'';
			$addressCus = $_POST['addressCus']??'';
			$phoneCus = $_POST['phoneCus']??'';
			$dataErr = validateDataBestCus($emailCus,$nameCus,$passCus,$addressCus,$phoneCus);
			// echo "<pre>";
			// print_r($dataErr);
			// die;
			$checkCus = true;
			foreach ($dataErr as $key => $err) {
				if ($err != '') {
					$checkCus = false;
					break;
				}
			}
			if ($checkCus) {
				if (isset($_SESSION['errAddCus'])) {
					unset($_SESSION['errAddCus']);
				}
				$checkEmail = $this->CusModel->checkEmailCusExit($emailCus);
				if ($checkEmail) {
					$_SESSION['errEmailCus'] = $emailCus;
					header('location:?c=customer&m=addCustomer&state=exist');
				}else{
					$passCus = md5($passCus);
					$sec = rand(100,999);
					if (!isset($_SESSION['resCus'])) {
						$_SESSION['resCus']['nameCus'] = $nameCus;
						$_SESSION['resCus']['emailCus'] = $emailCus;
						$_SESSION['resCus']['passCus'] = $passCus;
						$_SESSION['resCus']['addressCus'] = $addressCus;
						$_SESSION['resCus']['phoneCus'] = $phoneCus;
						$_SESSION['resCus']['security'] = $sec;
						// echo "<pre>";
						// print_r($_SESSION['resCus']);
					}
					// die;
					$email = $emailCus;
							// echo $email;
							// die;
							$subject = 'Website bán sách online Pbook store';
							// $content = 'Quý khách đã đăng ký thành công tài khoản khách hàng thân thiết của cửa hàng sách Pbook store. Cảm ơn quý khách đã tin tưởng';
							$content = '<b>'.$_SESSION['resCus']['security'].'</b> là mã xác nhận tài khoản của quý khách tại Pbook store.';
							// echo $content;
							// die;
							if (sendMailPHPMailer($email,$subject,$content)) {
								header('location:?c=customer&m=countDown');
							}else{
								header('location:?c=customer&m=register&state=err');
							}
					// $addCus = $this->CusModel->AddDataCustomer($nameCus,$emailCus,$passCus,$addressCus,$phoneCus);
					// echo "<pre>";
					// print_r($addCus);
					// if ($addCus) {
					// 	$email = $emailCus;
					// 	$subject = 'Website bán sách online Pbook Store';
					// 	$content = 'Quý khách đã đăng ký thành công tài khoản khách hàng thân thiết của cửa hàng sách Pbook store. Cảm ơn quý khách đã tin tưởng ';
					// 	if (sendMailPHPMailer($email,$subject,$content)) {
					// 		header('location:?c=home');
					// 	}else{
					// 		header('location:?c=customer&m=addCustomer&state=err');
					// 	}
					// }else{
					// 	header('location:?c=customer&m=addCustomer&state=err');
					// }
				}
			}else{
				$_SESSION['errAddCus'] = $dataErr;
				header('location:?c=customer&m=addCustomer&state=fail');
			}
		}
	}
	public function infoCus(){
		$data = [];
		$idCus = $_SESSION['id_cus']??'';
		$delivered = [];
		$order = [];
		// lay id bill cua khach da mua
		$idBillSell = $this->CusModel->getIdBillCus($idCus);
		// echo "<pre>";
		// print_r($idBill);
		// die;
		foreach ($idBillSell as $key => $id) {
			$infPro = $this->CusModel->getProDeli($id['id']);
			// foreach ($ as $key => $value) {
			// 	# code...
			// }
			// echo $id;
			if (!empty($infPro)) {
				foreach ($infPro as $key => $item) {
					$delivered[$item['id']] = array(
						'idPd' => $item['id_product'],
						'namePd' => $item['name_pd'],
						'qtyPd' => $item['quanity_pd'],
						'pricePd' => $item['price_pd'],
						'totalMoney' => $item['totalMoney']
					);
				}
			}
			
		}
		$idBillOrder = $this->CusModel->getIdBillOrder($idCus);
		// echo "<pre>";
		// print_r($idBillOrder);
		// die;		
		foreach ($idBillOrder as $key => $id) {
			$infPro = $this->CusModel->getProDeli($id['id']);
			if (!empty($infPro)) {
				foreach ($infPro as $key => $item) {
					// echo "<pre>";
					// print_r($infPro);
					// print_r($item['id_product']);
					$order[$item['id']] = array(
						'idbill' => $item['id_bill'],
						'idPd' => $item['id_product'],
						'namePd' => $item['name_pd'],
						'qtyPd' => $item['quanity_pd'],
						'pricePd' => $item['price_pd'],
						'totalMoney' => $item['totalMoney']
					);
				}
			}
			
		}
				

		// echo "<pre>";
		// print_r($data);
		// die;
		// $data['idBill'] = $idBillOrder;
		$data['delivered'] = $delivered;
		$data['order'] = $order;
		// echo "<pre>";
		// print_r($data['order']);
		// die;		
		$header = [];
		$header['title'] = "This is Infomation customer";
		$this->LoadHeader($header);
		$this->LoadView('app/view/customer/InfoCus_view.php',$data);
		$this->LoadFooter();
	}
	public function editCus(){
		$idCus = $_SESSION['id_cus'];
		$data = [];
		$data['errEdit'] = $_SESSION['errEditCus']??[];
		$data['state'] = $_GET['state']??'';
		// echo $idCus;
		$header = [];
		$header['title'] = "This is Infomation customer";
		$this->LoadHeader($header);
		$this->LoadView('app/view/customer/editCustomer_view.php',$data);
		$this->LoadFooter();
	}
	public function handleEdit(){
		if (isset($_POST['btnSubmit'])) {
			// echo "sada";
			// die;
			$idCus = $_SESSION['id_cus'];
			$nameCus = $_POST['txtName']??'';
			$addCus = $_POST['txtAddr']??'';
			$phoneCus = $_POST['txtPhone']??'';

			$checkCus = true;
			$dataErr = validateEditCus($nameCus,$addCus,$phoneCus);
			// echo "<pre>";
			// print_r($dataErr);
			// die;
			foreach ($dataErr as $key => $err) {
				if ($err !== '') {
					$checkCus = false;
					break;
				}
			}
			if ($checkCus) {
				if (isset($_SESSION['errEditCus'])) {
					unset($_SESSION['errEditCus']);
				}
				$edit = $this->CusModel->UpdateDataCus($idCus,$nameCus,$addCus,$phoneCus);
				// echo $edit;
				// die;
				if ($edit) {
					header('location:?c=customer&m=infoCus');
				}else{
					header('location:?c=customer&m=editCus&state=err');
				}
			}else{
				$_SESSION['errEditCus'] = $dataErr;
				header('location:?c=customer&m=editCus&state=fail');
			}
		}
	}
	public function deleteCus(){
		$idCus = $_SESSION['id_cus'];
		$delete = $this->CusModel->deleteCus($idCus);
		if ($delete) {
			header('location:?c=home');
		}else{
			header('location:?c=customer&m=infoCus&state=fail');
		}
		
	}
	public function countDown(){
		$header = [];
		$header['title'] = "This is Infomation customer";
		$this->LoadHeader($header);
		$this->LoadView('app/view/customer/countDown_view.php');
		$this->LoadFooter();		
	}
	public function failCus(){
		// echo "hello";
		if (isset($_SESSION['resCus'])) {
			unset($_SESSION['resCus']);
			header('location:?c=customer&m=addCustomer');
		}else{
			header('location:?c=home');
		}
	}
	public function getcode(){
		$code = $_POST['txtNumber'];
		$sec = $_SESSION['resCus']['security'];
		$nameCus = $_SESSION['resCus']['nameCus'];
		$emailCus = $_SESSION['resCus']['emailCus'];
		$passCus = $_SESSION['resCus']['passCus'];
		$addressCus = $_SESSION['resCus']['addressCus'];
		$phoneCus = $_SESSION['resCus']['phoneCus'];
		// echo $sec;
		// echo "<br>";
		// echo $code;
		if ($code == $sec) {
			$addCus = $this->CusModel->AddDataCustomer($nameCus,$emailCus,$passCus,$addressCus,$phoneCus);
			if ($addCus) {
				header('location:?c=home&state=success');
			}else{
				header('location:?c=customer&m=addCustomer&state=err');
			}
		}else{
			header('location:?c=customer&m=countDown&state=err');
		}
	}
	

}
$cus = new CustomerController;
$method = $_GET['m']??'addCustomer';
$cus->$method();