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

function uploadFileData($file){
	if ($file['error']==0) {
		$tmpName = $file['tmp_name'];
		$nameFile = $file['name'];
		if ($tmpName != '') {
			if (move_uploaded_file($tmpName, PATH_IMAGE.$nameFile)) {
				return $nameFile;
			}
		}
	}
	return;
}

function validateCustomer($emailCus,$nameCus,$phoneCus,$addCus){
	$err = [];
	$err['emailCus'] = ($emailCus == '')?'Enter Email Customer':'';
	$err['nameCus'] = ($nameCus == '')? 'Enter Name Customer':'';
	$err['phoneCus'] = ($phoneCus == '')? 'Enter phone Customer':'';
	$err['addCus'] = ($addCus == '')? 'Enter address customer':'';
	return $err;
}
function validateEditCus($nameCus,$addCus,$phoneCus){
	$err = [];
	$err['nameCus'] = ($nameCus == '')? 'Enter Name Customer':'';
	$err['phoneCus'] = ($phoneCus == '')? 'Enter phone Customer':'';
	$err['addCus'] = ($addCus == '')? 'Enter address customer':'';
	return $err;
}
function validateDataBestCus($emailCus,$nameCus,$passCus,$addCus,$phoneCus){
	$err = [];
	$err['nameCus'] = ($nameCus == '')? 'Enter Name Customer':'';
	if ($passCus=='') {
		$err['passCus'] = 'Enter password customer';
	}else{
		$pass = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/';
		if (preg_match($pass, $passCus)) {
			$err['passCus']='';
		}else{
			$err['passCus']='Password incorrect';
		}
	}
	if($emailCus==''){
		$err['emailCus'] = 'Enter email customer';
	}else{
		if (filter_var($emailCus,FILTER_VALIDATE_EMAIL)) {
			$err['emailCus']='';
		}else{
			$err['emailCus']='Not email address';
		}
	}
	$err['phoneCus'] = ($phoneCus == '')? 'Enter phone Customer':'';
	$err['addCus'] = ($addCus == '')? 'Enter address customer':'';
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
function creat_link($data=[]){
	$urlLink = '';
	foreach ($data as $key => $val) {
		$urlLink.="{$key}={$val}&";
	}
	return ($urlLink != '')? BASE_URL ."?".rtrim($urlLink,'&'):BASE_URL;
}
function pagination_search($link,$totalRecod,$currentPage,$limit=2,$keyWord=''){
	$totalPage = ceil($totalRecod/$limit);
	if ($currentPage <1 ) {
		$currentPage = 1;
	}elseif($currentPage > $totalPage){
		$currentPage = $totalPage;
	}
	$start = ($currentPage-1)*$limit;
	// xay dung template phan trang bang bootstrap
	$html = '';
	$html.="<nav aria-label='...'>";
	$html.="<ul class='pagination'>";
	if ($currentPage > 1 && $currentPage <= $totalPage) {
		$html.="<li class='page-item'><a class='page-link' href='".str_replace('{page}', $currentPage-1, $link)."'tabindex'-1'>Previous</a></li>";
	}
	// hien thi cho cac trang o giua
	for ($i=1; $i < $totalPage; $i++) { 
		if ($i == $currentPage) {
			$html.="<li class='page-item active'><a class='page_link'>".$currentPage."</a></li>";
		}else{
			$html.="<li class='page-item'><a class='page-link' href='".str_replace('{page}', $i, $link)."'>".$i."</a></li>";
		}
	}
	if (($currentPage < $totalPage) && ($currentPage >=1)) {
		$html.="<li class='page-item><a class='page-link' href='".str_replace('{page}', $currentPage+1, $link)."'>Next</a></li>";
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
function pagination($link,$totalRecod,$currentPage,$limit=2){
	$totalPage = ceil($totalRecod/$limit);
	if ($currentPage < 1 ) {
		$currentPage = 1;
	}elseif($currentPage > $totalPage){
		$currentPage = $totalPage;
	}
	$start = ($currentPage-1)*$limit;
	// xay dung template phan trang bang bootstrap
	$html = '';
	$html.="<nav aria-label='...'>";
	$html.="<ul class='pagination'>";
	if ($currentPage > 1 && $currentPage <= $totalPage) {
		$html.="<li class='page-item'><a class='page-link' href='".str_replace('{page}', $currentPage-1, $link)."'tabindex'=-1'>Previous</a></li>";
	}
	// hien thi cho cac trang o giua
	for ($i=1; $i < $totalPage; $i++) { 
		if ($i == $currentPage) {
			$html.="<li class='page-item active'><a class='page-link'>".$currentPage."</a></li>";
		}else{
			$html.="<li class='page-item'><a class='page-link' href='".str_replace('{page}', $i, $link)."'>".$i."</a></li>";
		}
	}
	// xu lý nut next
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