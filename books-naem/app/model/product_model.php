<?php
namespace App\Model;
require 'app/config/database.php';
use App\Config\Database;
use \PDO;
if (!defined('APP_PATH')) {
	die('can not access');
}
class ProductModel extends Database{
	function __construct(){
		parent::__construct();
	}
	public function getDetailProduct($idPd){
		$data = [];
		$sql = "SELECT * FROM products AS p WHERE p.id = :idPd";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idPd',$idPd,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetch(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getAllDataProduct($key){
		$data = [];
		$keyword = "%".$key."%";

		$sql = "SELECT * FROM products AS p WHERE  p.name_pd LIKE :key OR p.price_pd LIKE :key2";
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
	public function getCatProduct($idPd,$catPd){
		$data = [];
		$sql = "SELECT products.name_pd,products.price_pd,products.sale_off,products.quanity_pd,products.id,products.image_pd FROM products INNER JOIN categories ON products.cat_id = categories.id WHERE products.id <> :idPd AND categories.id = :catPd LIMIT 0,4";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':catPd',$catPd,PDO::PARAM_INT);
			$stmt->bindParam(':idPd',$idPd,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getLstPro($idCat){
		$data = [];
		$sql = "SELECT * FROM products AS p WHERE p.cat_id = :idCat ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCat',$idCat,PDO::PARAM_INT);
			if ($stmt->execute()) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			$stmt->closeCursor();
		}
		return $data;		
	}
	public function getLstProByPage($idCat,$start,$limit){
		$data = [];
		$sql = "SELECT * FROM products AS p WHERE p.cat_id = :idCat LIMIT :start,:limmit ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCat',$idCat,PDO::PARAM_INT);
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
	public function getNameCat($idCat){
		$data = [];
		$sql = "SELECT name_cat FROM categories AS c WHERE c.id = :idCat ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCat',$idCat,PDO::PARAM_INT);
			if ($stmt->execute()) {
				$data = $stmt->fetch(PDO::FETCH_ASSOC);
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getAllComment($idPd){
		$data = [];
		$sql = "SELECT * FROM comment AS c WHERE c.product_id = :idPd ORDER BY c.id DESC LIMIT 0,5 ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idPd',$idPd,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function addComment($idCus,$idPd,$content,$nameCus){
		$flag = false;
		$status = 1;
		$ct = date('Y-m-d H:i:s');
		$sql = "INSERT INTO comment(cus_id,name_cus,content,product_id,status,creat_time) VALUES (:idCus, :nameCus,:content,:idPd,:status,:ct)";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCus',$idCus,PDO::PARAM_INT);
			$stmt->bindParam(':nameCus',$nameCus,PDO::PARAM_STR);
			$stmt->bindParam(':content',$content,PDO::PARAM_STR);
			$stmt->bindParam(':idPd',$idPd,PDO::PARAM_INT);
			$stmt->bindParam(':status',$status,PDO::PARAM_INT);
			$stmt->bindParam(':ct',$ct,PDO::PARAM_STR);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
}