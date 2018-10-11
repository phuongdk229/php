<?php
namespace App\Model;
if (!defined('APP_PATH')) {
	die('can not access');
}
require "app/config/database.php";
use App\Config\Database;
use \PDO;
class CategoriesModel extends database{
	function __construct(){
		parent::__construct();
	}
	public function getAllDataCategories($keyword=''){
		$key = "%".$keyword."%";
		$data = [];

		$sql = "SELECT * FROM categories AS c WHERE c.name_cat LIKE :key";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':key',$key,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function addDataCategories($nameCat){
		$flag = false;
		$status = 1;
		$ct = date('Y-m-d H:i:s');
		$ut = null;
		$sql = "INSERT INTO categories(name_cat,status,creat_time,update_time) VALUES(:nameCat,:status,:ct,:ut)";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':nameCat',$nameCat,PDO::PARAM_STR);
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
	public function deleteCateById($id){
		$flag = false;
		$sql = "DELETE FROM categories WHERE id = :id";
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

	public function checkNameCat($nameCat){
		$flag = false;
		$sql = "SELECT name_cat FROM categories AS c WHERE c.name_cat = :nameCat ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':nameCat',$nameCat,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$flag = true;
				}
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
	public function getInfDataById($id_cat){
		$data = [];
		$sql = "SELECT * FROM categories AS c WHERE c.id = :idCat ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCat',$id_cat,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetch(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}

	public function checkEditNameById($id_cat,$nameCat){
		$flag = false;
		$sql = "SELECT name_cat FROM categories AS c WHERE c.name_cat = :nameCat AND c.id <> :id_cat";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':id_cat',$id_cat,PDO::PARAM_INT);
			$stmt->bindParam(':nameCat',$nameCat,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$flag = true;
				}
			}
			$stmt->closeCursor();
		}
		return $flag;
	}

	public function updateDataById($id_cat,$nameCat,$status){
		$flag = false;
		$ut = date('Y-m-d H:i:s');
		$sql = "UPDATE categories SET name_cat=:nameCat,status = :status,update_time=:ut WHERE id =:id_cat ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':id_cat',$id_cat,PDO::PARAM_INT);
			$stmt->bindParam(':nameCat',$nameCat,PDO::PARAM_STR);
			$stmt->bindParam(':status',$status,PDO::PARAM_INT);
			$stmt->bindParam('ut',$ut,PDO::PARAM_STR);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
	public function getAllDataCategoriesByPage($start,$limit=2,$key){
		$data = [];
		$keyword = "%".$key."%";
		$sql = "SELECT * FROM categories AS c WHERE c.name_cat LIKE :key LIMIT :start,:limmit";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':key',$keyword,PDO::PARAM_STR);
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
}