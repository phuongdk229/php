<?php
namespace App\Core;

class MY_controller{

	protected function LoadHeader($header=[]){

		$title = $header['title']??'';
		$content = $header['content']??'';
		require_once 'app/view/partials/header_view.php';
	}
	protected function LoadView($pathView,$data = []){
		require $pathView;
	}
	protected function LoadFooter(){
		require_once 'app/view/partials/footer_view.php';
	}
}