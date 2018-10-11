<?php
namespace App\Model;
if (!defined('APP_PATH')) {
	die('can not access');
}
require "app/config/database.php";

use App\Config\Database;
use \PDO;
class CustomerModel extends database{
	function __construct(){
		parent::__construct();
	}
	public function getAllDataCus($keyword =''){
		$key = "%".$keyword."%";
		$data = [];

		$sql = "SELECT * FROM customer AS c WHERE c.name_cus LIKE :key";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':key',$key,PDO::PARAM_STR);
			if ($stmt->execute()) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getAllDataCusByPage($start,$limit=2,$keyword){
		$data = [];
		$key = "%".$keyword."%";
		$sql = "SELECT * FROM customer AS c WHERE c.name_cus LIKE :key LIMIT :start,:limmit";
		$stmt = $this->db->prepare($sql);
		if($stmt){
			$stmt->bindParam(':key',$key,PDO::PARAM_STR);
			$stmt->bindParam(':start',$start,PDO::PARAM_INT);
			$stmt->bindParam(':limmit',$limit,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
				$stmt->closeCursor();
			}
		}
		return $data;
	}
	public function getAllDataBill($keyword){
		$data = [];
		$key = "%".$keyword."%";
		$sql = "SELECT * FROM bill AS b WHERE b.name_cus LIKE :key AND b.status_bill = 1  ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':key',$key,PDO::PARAM_STR);
			if ($stmt->execute()) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getAllDataBillByPage($start,$limit,$keyword){
		$data = [];
		$key = "%".$keyword."%";
		$sql = "SELECT * FROM bill  AS b WHERE b.name_cus LIKE :key AND b.status_bill = 1 LIMIT :start,:limmit ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':key',$key,PDO::PARAM_STR);
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
	public function getAllDataCity(){
		$data = [];
		$sql = "SELECT * FROM city";
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
	public function getAllDataDistrict(){
		$data = [];
		$sql = "SELECT * FROM district";
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
	public function getAllPdOrder($idBill){
		$data = [];
		$sql = "SELECT * FROM detail_bill WHERE id_bill = :idBill";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idBill',$idBill,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getDataBillById($idBill){
		$data = [];
		$sql = "SELECT * FROM bill WHERE id = :idBill";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idBill',$idBill,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetch(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function perfectOrderOfCus($idBill,$idMan){
		$flag = false;
		$status = 0;
		$sql = "UPDATE bill SET status_bill = :status,id_man = :idMan WHERE id = :idBill ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idBill',$idBill,PDO::PARAM_INT);
			$stmt->bindParam(':status',$status,PDO::PARAM_INT);
			$stmt->bindParam(':idMan',$idMan,PDO::PARAM_INT);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
	public function getAllDataProduct(){
		$data = [];
		$sql = "SELECT * FROM products";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			if ($stmt->execute()) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getCoinCustomer($idCus){
		$data = [];
		$sql = "SELECT coin FROM customer AS c WHERE c.id = :idCus";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCus',$idCus,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetch(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function updateCoinforCus($idCus,$coin){
		$flag = false;
		$sql = " UPDATE customer SET coin = :coin WHERE id = :idCus";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCus',$idCus,PDO::PARAM_INT);
			$stmt->bindParam(':coin',$coin,PDO::PARAM_INT);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
	public function updateQtySell($qty,$id){
		$flag = false;
		$sql = "UPDATE products SET quanity_sell = :qty WHERE id = :id ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':id',$id,PDO::PARAM_INT);
			$stmt->bindParam(':qty',$qty,PDO::PARAM_INT);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}

	public function deleteOrder($idBill){
		$flag = false;
		$sql = "DELETE FROM bill WHERE id = :idBill";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idBill',$idBill,PDO::PARAM_INT);
			if ($stmt->execute()>0) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
	public function getInfoComment(){
		$data = [];
		$sql = "SELECT * FROM comment";
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
	public function getNamePd(){
		$data = [];
		$sql = "SELECT id,name_pd FROM products";
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

}