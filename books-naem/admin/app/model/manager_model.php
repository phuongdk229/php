<?php
namespace App\Model;

require 'app/config/database.php';

use App\Config\Database;
use \PDO;

if (!defined('APP_PATH')) {
	die('can not access');
}
class ManagerModel extends Database{
	function __construct(){
		parent::__construct();
	}
	public function getAllDataManager($keyword=''){
		$data = [];
		$key = "%".$keyword."%";

		$sql = "SELECT * FROM admins AS a WHERE  a.username LIKE :key OR a.email LIKE :key2";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':key',$key,PDO::PARAM_STR);
			$stmt->bindParam(':key2',$key,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function addDataMannager($nameMan,$passMan,$emailMan){
		$flag = false;
		$status = 1;
		$role = 0;
		$ct = date('Y-m-d H:i:s');
		$ut = null;
		$sql = "INSERT INTO admins(username,passWord,email,role,status,creatTime,updateTime) VALUES (:nameMan,:passMan,:emailMan,:role,:status,:ct,:ut)";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':nameMan',$nameMan,PDO::PARAM_STR);
			$stmt->bindParam(':passMan',$passMan,PDO::PARAM_STR);
			$stmt->bindParam(':emailMan',$emailMan,PDO::PARAM_STR);
			$stmt->bindParam(':role',$role,PDO::PARAM_INT);
			$stmt->bindParam(':status',$status,PDO::PARAM_INT);
			$stmt->bindParam(':ct',$ct,PDO::PARAM_STR);
			$stmt->bindParam(':ut',$ut,PDO::PARAM_STR);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}

	public function checkNameManExit($nameMan){
		$flag = false;
		$sql = "SELECT username FROM admins AS a WHERE a.username = :nameMan";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':nameMan',$nameMan,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$flag = true;
				}
			}
			$stmt->closeCursor();
		}
		return $flag;
	}

	public function getAllDataById($idMan){
		$data = [];
		$sql = "SELECT * FROM admins AS a WHERE a.id = :idMan";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idMan',$idMan,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetch(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}

	public function checkNameManEdit($idMan,$nameMan){
		$flag = false;
		$sql = " SELECT username FROM admins AS a WHERE a.username = :nameMan AND a.id <> :idMan ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idMan',$idMan,PDO::PARAM_INT);
			$stmt->bindParam(':nameMan', $nameMan,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$flag = true;
				}
			}
			$stmt->closeCursor();
		}
		return $flag;
	}

	public function updateDataById($idMan,$nameMan,$status,$role){
		$flag = false;
		$ut = date('Y-m-d H:i:s');
		$sql = "UPDATE admins SET username=:nameMan,status=:status,role=:role,updateTime=:ut WHERE id=:idMan";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idMan',$idMan,PDO::PARAM_INT);
			$stmt->bindParam(':nameMan',$nameMan,PDO::PARAM_STR);
			$stmt->bindParam(':status',$status,PDO::PARAM_INT);
			$stmt->bindParam(':role',$role,PDO::PARAM_INT);
			$stmt->bindParam(':ut',$ut,PDO::PARAM_STR);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}

	public function getAllDataProductByPage($start,$limit,$keyword){
		$data = [];
		$key = "%".$keyword."%";
		$sql = "SELECT * FROM admins AS a WHERE a.username LIKE :key OR a.email LIKE :key2 LIMIT :start,:limmit ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':key',$key,PDO::PARAM_STR);
			$stmt->bindParam(':key2',$key,PDO::PARAM_STR);
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
	public function deleteManagerById($id){
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
}