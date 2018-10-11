<?php
namespace App\Model;
if (!defined('APP_PATH')) {
	die('can not access');
}
require "app/config/database.php";

use App\Config\Database;
use\PDO;
class ProductModel extends database{
	function __construct(){
		parent::__construct();
	}
	public function getAllDataProduct($key=''){
		$data = [];
		$keyword = "%".$key."%";

		$sql = "SELECT * FROM products AS p WHERE p.name_pd LIKE :key OR p.price_pd LIKE :key2";

		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':key',$keyword,PDO::PARAM_STR);
			$stmt->bindParam(':key2',$keyword,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function deleteProductById($id){
		$flag = false;
		$sql = "DELETE FROM products WHERE id=:id";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
	public function getAllDataCategories(){
		$data = [];
		$sql = "SELECT * FROM categories";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function addDataProduct($namePd,$catPd,$priceInput,$pricePd,$qty,$desPd,$imagePd,$sale_off){
		$flag = false;
		// $sale_off = 0;
		$status = 1;
		$ct = date('Y-m-d H:i:s');
		$ut = null;
		$sql = "INSERT INTO products(cat_id,name_pd,image_pd,price_pd,price_input,sale_off,quanity_pd,description_pd,status_pd,create_time,update_time) VALUES (:catPd,:namePd,:imagePd,:pricePd,:priceInput,:sale_off,:qty,:desPd,:status,:ct,:ut)";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':catPd',$catPd,PDO::PARAM_INT);
			$stmt->bindParam(':namePd',$namePd,PDO::PARAM_INT);
			$stmt->bindParam(':imagePd',$imagePd,PDO::PARAM_INT);
			$stmt->bindParam(':pricePd',$pricePd,PDO::PARAM_INT);
			$stmt->bindParam(':priceInput',$priceInput,PDO::PARAM_INT);
			$stmt->bindParam(':sale_off',$sale_off,PDO::PARAM_INT);
			$stmt->bindParam(':qty',$qty,PDO::PARAM_INT);
			$stmt->bindParam(':desPd',$desPd,PDO::PARAM_INT);
			$stmt->bindParam(':status',$status,PDO::PARAM_INT);
			$stmt->bindParam(':ct',$ct,PDO::PARAM_INT);
			$stmt->bindParam(':ut',$ut,PDO::PARAM_INT);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}

	public function checkNamePdExist($namePd){
		$flag = false;
		$sql = "SELECT name_pd FROM products AS p WHERE p.name_pd = :namePd ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':namePd',$namePd,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$flag = true;
				}
			}
			$stmt->closeCursor();
		}
		return $flag;
	}

	public function getInfDataById($id_pd){
		$data = [];
		$sql = "SELECT * FROM products AS a WHERE a.id = :id_pd";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':id_pd',$id_pd,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetch(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}

	public function checkEditNamePd($id_pd,$namePd){
		$flag = false;
		$sql = "SELECT name_pd FROM products AS p WHERE p.name_pd = :namePd AND id <> :id_pd";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':id_pd',$id_pd,PDO::PARAM_INT);
			$stmt->bindParam('namePd',$namePd,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$flag = true;
				}
			}
			$stmt->closeCursor();
		}
		return $flag;
	}

	public function updateDataById($id_pd,$namePd,$catPd,$priceInput,$pricePd,$sale_off,$qty,$desPd,$nameImage,$status){
		$flag = false;
		// $sale_off = 0;
		$ut = date('Y-m-d H:i:s');
		$sql = "UPDATE products SET cat_id=:catPd,name_pd=:namePd,image_pd=:imagePd,price_pd=:pricePd,price_input=:priceInput,sale_off=:sale_off,status_pd=:status,quanity_pd=:qty,description_pd=:desPd,update_time=:ut WHERE id=:id_pd";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':id_pd',$id_pd,PDO::PARAM_INT);
			$stmt->bindParam(':catPd',$catPd,PDO::PARAM_INT);
			$stmt->bindParam(':namePd',$namePd,PDO::PARAM_STR);
			$stmt->bindParam(':imagePd',$nameImage,PDO::PARAM_STR);
			$stmt->bindParam(':priceInput',$priceInput,PDO::PARAM_INT);
			$stmt->bindParam(':pricePd',$pricePd,PDO::PARAM_INT);
			$stmt->bindParam(':sale_off',$sale_off,PDO::PARAM_INT);
			$stmt->bindParam(':status',$status,PDO::PARAM_INT);
			$stmt->bindParam(':qty',$qty,PDO::PARAM_INT);
			$stmt->bindParam(':desPd',$desPd,PDO::PARAM_STR);
			$stmt->bindParam(':ut',$ut,PDO::PARAM_STR);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
	public function getAllDataProductByPage($start,$limit,$key){
		$data = [];
		$keyword = "%".$key."%";
		$sql = "SELECT * FROM products AS p WHERE p.name_pd LIKE :key OR p.price_pd LIKE :key2 LIMIT :start,:limmit ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':key',$keyword,PDO::PARAM_STR);
			$stmt->bindParam(':key2',$keyword,PDO::PARAM_STR);
			$stmt->bindParam(':start',$start,PDO::PARAM_INT);
			$stmt->bindParam(':limmit',$limit,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function addPic($pic){
		$flag = false;
		$ct = date('Y-m-d H:i:s');
		$sql = "INSERT INTO banner (name_pic,create_time) VALUES (:pic,:ct) ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':pic',$pic,PDO::PARAM_STR);
			$stmt->bindParam(':ct',$ct,PDO::PARAM_STR);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
	public function checkNamePic($pic){
		$flag = false;
		$sql = "SELECT * FROM banner WHERE name_pic = :namepic";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':namepic',$pic,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$flag = true;
				}
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
}