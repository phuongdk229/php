<?php
if (!defined('APP_PATH')) {
	die('can not access');
}

ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// define('PATH_UPLOAD', '../public/upload/image/');
function uploadFileData($file){
	if ($file['error']==0) {
		$tmpName = $file['tmp_name'];
		$nameFile = $file['name'];
		if ($tmpName !== '') {
			if (move_uploaded_file($tmpName, PATH_IMAGE.$nameFile)) {
				return $nameFile;
			}
		}
	}
	return;
}
function validateImgae($pic){
	$err = [];
	$err['pic'] = ($pic == '')?'Choose image ':'';
	return $err;
}

function sendMailPHPMailer($email,$subject,$content){
	$mail = new PHPMailer(true);
	try{
		$mail->isSMTP();
		$mail->Host = 'smtp.googlemail.com';

		$mail->SMTPAuth = true;
		$mail->Username = 'pbookstore229@gmail.com';
		$mail->Password = 'KimPhuong229';
		$mail->SMTPSecure = 'tls';

		$mail->Port = 587;
		$mail->CharSet = "utf-8";

		$mail->setFrom('pbookstore229@gmail.com','Pbook Store');
		$mail->addAddress($email);
		$mail->addCC('phuongmerino229@gmail.com');

		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $content;

		if ($mail->send()) {
			return true;
		}
		else{
			echo "<pre>";
			print_r($mail->ErrorInfo);
			die;
		}
	}catch(Exception $e){
		echo 'Mailer Error: ';
		echo "<br>";
		print_r($mail->ErrorInfo);
		die;
	}
}

function sendMail($email,$subject,$content){
	$header = "From:pbookstore229@gmail.com \r\n";
	$header .= "MINE-VersionL 1.0\r\n";
	$header .="Content-type: text/html; charset=utf-8\r\n";
	if (mail($email,$subject,$content,$header)) {
		return true;
	}
	return false;
}


function validateAddProduct($namePd,$catPd,$priceInput,$pricePd,$qty,$desPd,$imagePd){
	$err = [];
	$err['namePd'] = ($namePd=='') ? 'Enter name Product' : '';
	$err['catPd'] = ($catPd=='') ? 'Enter Categories Product' : '';
	$err['pricePd'] = ($pricePd <=0) ? 'Enter price Product' : '';
	$err['priceInput'] = ($priceInput <= 0)?'Enter input price':'';
	$err['qty'] = ($qty <= 0) ? 'Enter quanity Product' : '';
	$err['desPd'] = ($desPd == '') ? 'Enter description Product' : '';
	$err['imagePd'] = ($imagePd =='')?'Choose image Product' : '';
	return $err; 
}
function validateAddCategories($nameCat){
	$err = [];
	$err['nameCat'] = ($nameCat=='') ? 'Enter name categories' : '';
	return $err;
}
function validateAddManager($nameMan,$passMan,$emailMan){
	$err = [];
	$err['nameMan'] = ($nameMan=='')? 'Enter name Manager' : '';
	// $err['passMan'] = ($passMan=='')? 'Enter password Manager' : '';
	if ($passMan == '') {
		$err['passMan'] = 'Enter password Manager';
	}else{
		$pass = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/';
		if (preg_match($pass, $passMan)) {
			$err['passMan'] = '';
		}else{
			$err['passMan'] = 'Password incorrect';
		}

	}

	if ($emailMan=='') {
		$err['emailMan'] = 'Enter email Manager';
	}else{
			if (filter_var($emailMan,FILTER_VALIDATE_EMAIL)) {
				$err['emailMan'] = '';
			}else{
				$err['emailMan'] = 'Not email address';
			}
	}
	// $err['emailMan'] = ($emailMan=='')? 'Enter email Manager' : '';

	return $err;
}
function validateEditManager($nameMan,$email){
	$err = [];
	// $err['nameMan'] = ($nameMan =='')? 'Enter name Manager' : '';
	$err['nameMan'] = ($nameMan == '')? 'Enter name manager !': '';
	if ($email=='') {
		$err['emailMan'] = 'Enter email Manager';
	}else{
			if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
				$err['emailMan'] = '';
			}else{
				$err['emailMan'] = 'Not email address';
			}
	}
	return $err;
}

function creat_link($data=[]){
	$urlLink = '';
	foreach ($data as $key => $val) {
		$urlLink.="{$key}={$val}&";
	}
	return ($urlLink != '')? BASE_URL ."?".rtrim($urlLink,'&'):BASE_URL;
}

function pagination($link,$totalRecod,$currentPage,$limit=2,$keyWord=''){
	$totalPage = ceil($totalRecod/$limit);
	if ($currentPage < 1) {
		$currentPage =1;
	}
	elseif($currentPage > $totalPage){
		$currentPage = $totalPage;
	}
	// tinh start
	$start = ($currentPage-1)*$limit;

	// xay dung template phan trang bang bootstrap
	$html ='';
	$html.="<nav aria-label='...' >";
	$html.="<ul class='pagination'>";
	if ($currentPage >1 && $currentPage <=$totalPage) {
		$html.="<li class='page-item'><a class='page-link' href='".str_replace('{page}', $currentPage-1, $link)."' tabindex='-1'>Previous</a></li> ";
	}
	// hien thi cho cac trang o giua
	for($i=1;$i<=$totalPage;$i++){
		if ($i==$currentPage) {
			$html.="<li class='page-item active' ><a class='page-link'>".$currentPage."</a></li>";
		}else{
			$html.="<li class ='page-item'><a class='page-link' href='".str_replace('{page}', $i, $link)."'>".$i."</a></li>";
		}
	}
	// xu ly nut next
	if (($currentPage < $totalPage) && ($currentPage >=1)) {
		$html.="<li class='page-item'><a class='page-link' href='".str_replace('{page}', $currentPage+1, $link)."'>Next</a></li>";
	}
	$html.="</ul>";
	$html.="</nav>";
	return [
		'start' => $start,
		'page' => $currentPage,
		'htmlPage' => $html,
		'limit' => $limit
	];
}
function validateStc($dateFrom,$dateTo,$nameStc){
	$err = [];
	$nowY = date('Y');
	$nowM = date('m');
	$nowD = date('d');
	$lastY = 2000;
	if ($dateFrom == '') {
		$err['dateFrom'] = 'Choose from date';
	}else{
		$shareFrom = explode('-', $dateFrom);
		$yFrom = $shareFrom[0];
		$mFrom = $shareFrom[1];
		$dFrom = $shareFrom[2];
		if (($yFrom <= $nowY) && ($yFrom >= $lastY) ) {
			if ($mFrom <= $nowM) {
				if ($dFrom <= $nowD) {
					$err['dateFrom'] = '';
					if ($dateTo != '') {
						$shareTo = explode('-', $dateTo);
						$yTo = $shareTo[0];
						$mTo = $shareTo[1];
					 	$dTo = $shareTo[2];
					 	if ($yTo <= $nowY && $yTo>= $yFrom) {
					 		if ($mTo <= $nowM && $mTo >= $mFrom) {
					 			if ($dTo <= $nowD && $dTo >= $dFrom) {
					 				$err['dataTo'] = '';
					 			}else{
					 				$err['dataTo'] = 'Choose to day';
					 			}
					 		}else{
					 			$err['dataTo'] = 'Choose to month';
					 		}
					 	}else{
					 		$err['dataTo'] = 'Choose to year';
					 	}
					}else{
						$err['dataTo'] = 'Choose to date';
					}
				}else{
					$err['dateFrom'] = 'Choose from day';
				}
			}else{
				$err['dateFrom'] = 'Choose from month';
			}
		}else{
			$err['dateFrom'] = 'Choose from year';
		}
	}

	$err['nameStc'] = ($nameStc == '')?'Choose name statistic':'' ;
	return $err;
}