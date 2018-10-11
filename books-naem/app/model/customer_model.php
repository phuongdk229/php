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
	public function AddDataBill($idCus,$nameCus,$emailCus,$addCus,$idCity,$idDis,$phoneCus,$sumMoney,$payment,$note){
		$flag = false;
		$last_id = 0;
		$status = 1;
		$ct = date('Y-m-d H:i:s');
		$ut = null;
		$date_order = date('Y-m-d');
		// $idDis = 2;
		$sql = "INSERT INTO bill(id_cus,name_cus,email_cus,address_cus,id_city,id_district,phone_cus,totalMoney,Payment,date_order,note,status_bill,create_time,update_time) VALUES (:idCus,:nameCus,:emailCus,:addCus,:idCity,:idDis,:phoneCus,:sumMoney,:payment,:date_order,:note,:status,:ct,:ut)";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCus',$idCus,PDO::PARAM_INT);
			$stmt->bindParam(':nameCus',$nameCus,PDO::PARAM_STR);
			$stmt->bindParam(':emailCus',$emailCus,PDO::PARAM_STR);
			$stmt->bindParam(':addCus',$addCus,PDO::PARAM_STR);
			$stmt->bindParam(':idCity',$idCity,PDO::PARAM_INT);
			$stmt->bindParam(':idDis',$idDis,PDO::PARAM_INT);
			$stmt->bindParam(':phoneCus',$phoneCus,PDO::PARAM_INT);
			$stmt->bindParam(':sumMoney',$sumMoney,PDO::PARAM_INT);
			$stmt->bindParam(':payment',$payment,PDO::PARAM_INT);
			$stmt->bindParam(':date_order',$date_order,PDO::PARAM_STR);
			$stmt->bindParam(':note',$note,PDO::PARAM_STR);
			$stmt->bindParam(':status',$status,PDO::PARAM_INT);
			$stmt->bindParam(':ct',$ct,PDO::PARAM_STR);
			$stmt->bindParam(':ut',$ut,PDO::PARAM_STR);
			if ($stmt->execute()) {
				$flag = true;
				$last_id = $this->db->lastInsertId();
			}
			$stmt->closeCursor();
		}
		return $last_id;
	}

	public function AddDataBillDetail($id_bill,$id_product,$name_pd,$quanity_pd,$price_pd,$price_input,$totalMoney){
		$flag = false;
		$ct = date('Y-m-d H:i:s');
		$ut = null;
		$sql = "INSERT INTO detail_bill(id_bill,id_product,name_pd,quanity_pd,price_pd,price_input,totalMoney,creat_time,update_time) VALUES(:id_bill,:id_product,:name_pd,:quanity_pd,:price_pd,:price_input,:totalMoney,:ct,:ut)";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':id_bill',$id_bill,PDO::PARAM_INT);
			$stmt->bindParam(':id_product',$id_product,PDO::PARAM_INT);
			$stmt->bindParam(':name_pd',$name_pd,PDO::PARAM_STR);
			$stmt->bindParam(':quanity_pd',$quanity_pd,PDO::PARAM_INT);
			$stmt->bindParam(':price_pd',$price_pd,PDO::PARAM_INT);
			$stmt->bindParam(':price_input',$price_input,PDO::PARAM_INT);
			$stmt->bindParam(':totalMoney',$totalMoney,PDO::PARAM_INT);
			$stmt->bindParam(':ct',$ct,PDO::PARAM_STR);
			$stmt->bindParam(':ut',$ut,PDO::PARAM_STR);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}

	public function AddDataCustomer($nameCus,$emailCus,$passCus,$addressCus,$phoneCus){
		$flag = false;
		$ct = date('Y-m-d H:i:s');
		$ut = null;
		$status = 1;
		$sql = "INSERT INTO customer(name_cus,password_cus,address_cus,phone_cus,email_cus,status,creat_time,update_time) VALUES (:nameCus,:passCus,:addressCus,:phoneCus,:emailCus,:status,:ct,:ut)";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':nameCus',$nameCus,PDO::PARAM_STR);
			$stmt->bindParam(':passCus',$passCus,PDO::PARAM_STR);
			$stmt->bindParam(':addressCus',$addressCus,PDO::PARAM_STR);
			$stmt->bindParam(':phoneCus',$phoneCus,PDO::PARAM_INT);
			$stmt->bindParam(':emailCus',$emailCus,PDO::PARAM_STR);
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

	public function getDataCity(){
		$data = [];
		$sql = "SELECT * FROM city";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			if ($stmt->execute()) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			$stmt->closeCursor();
		}
		return $data;
	}

	public function getDataDistrict($id){
		$data = [];
		$sql = "SELECT id,name_dis FROM district AS d WHERE d.id_city = :idCity";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCity',$id,PDO::PARAM_INT);
			if ($stmt->execute()) {
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}
			$stmt->closeCursor();
		}
		return $data;
	}

	public function getShipPay($idCity){
		$data = [];
		$sql = "SELECT ship_pay FROM city AS c WHERE c.id = :idCity";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCity',$idCity,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetch(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function checkEmailCusExit($emailCus){
		$flag = false;
		$sql = "SELECT email_cus FROM customer AS c WHERE c.email_cus = :emailCus";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':emailCus',$emailCus,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$flag = true;
				}
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
	public function getIdBillCus($idCus){
		$data = [];
		$sql= "SELECT id FROM bill AS b WHERE b.id_cus = :idCus AND status_bill = 0 ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCus',$idCus,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getIdBillOrder($idCus){
		$data = [];
		$sql= "SELECT id FROM bill AS b WHERE b.id_cus = :idCus AND status_bill = 1 ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCus',$idCus,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getProDeli($idBill){
		$data = [];
		$sql = "SELECT * FROM detail_bill WHERE id_bill = :idBill ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idBill',$idBill,PDO::PARAM_INT);
			if ($stmt->execute()) {
				if ($stmt->rowCount() > 0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function deleteCus($idCus){
		$flag = false;
		$status = 0;
		$sql = "UPDATE customer SET status=:status WHERE id=:idCus";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCus',$idCus,PDO::PARAM_INT);
			$stmt->bindParam(':status',$status,PDO::PARAM_INT);
			if ($stmt->execute()) {
				$flag = true;
			}
		}
		return $flag;
	}
	public function UpdateDataCus($idCus,$nameCus,$addCus,$phoneCus){
		$flag = false;
		$sql = "UPDATE customer SET name_cus = :nameCus,address_cus=:addCus,phone_cus=:phoneCus WHERE id = :idCus";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idCus',$idCus,PDO::PARAM_INT);
			$stmt->bindParam(':nameCus',$nameCus,PDO::PARAM_STR);
			$stmt->bindParam(':addCus',$addCus,PDO::PARAM_STR);
			$stmt->bindParam(':phoneCus',$phoneCus,PDO::PARAM_INT);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
	public function updateCoinforCus($idCus){
		$flag = false;
		$coin = 0;
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
	public function deleteOrder($idBill){
		$flag = false;
		$sql = " DELETE FROM bill WHERE id = :idBill";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':idBill',$idBill,PDO::PARAM_INT);
			if ($stmt->execute()) {
				$flag = true;
			}
			$stmt->closeCursor();
		}
		return $flag;
	}
	
}