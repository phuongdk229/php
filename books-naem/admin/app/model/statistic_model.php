<?php
namespace App\Model;
if (!defined('APP_PATH')) {
	die('can not access');
}
require 'app/config/database.php';

use App\Config\Database;
use\PDO;
class StatisticModel extends Database{
	function __construct(){
		parent::__construct();
	}
	public function getDataDetailBill($dateFrom,$dateTo){
		$data = [];
		$sql = "SELECT * FROM detail_bill AS d WHERE d.creat_time BETWEEN :dateFrom AND :dateTo ORDER BY d.quanity_pd DESC ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':dateFrom',$dateFrom,PDO::PARAM_STR);
			$stmt->bindParam(':dateTo',$dateTo,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getDataDetailBillByPage($dateFrom,$dateTo,$start,$limit){
		$data = [];
		$sql = "SELECT * FROM detail_bill WHERE :dateFrom AND :dateTo LIMIT :start,:limmit";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':dateFrom',$dateFrom,PDO::PARAM_STR);
			$stmt->bindParam(':dateTo',$dateTo,PDO::PARAM_STR);
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
	public function getDataProduct($dateFrom,$dateTo){
		$data = [];
		$sql = "SELECT * FROM products AS p WHERE p.create_time BETWEEN :dateFrom AND :dateTo ORDER BY p.quanity_pd DESC  ";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':dateFrom',$dateFrom,PDO::PARAM_STR);
			$stmt->bindParam(':dateTo',$dateTo,PDO::PARAM_STR);
			if ($stmt->execute()) {
				if ($stmt->rowCount()>0) {
					$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				}
			}
			$stmt->closeCursor();
		}
		return $data;
	}
	public function getDataCustomer($dateFrom,$dateTo){
		$data = [];
		$sql = "SELECT * FROM customer AS c WHERE c.creat_time BETWEEN :dateFrom AND :dateTo ORDER BY c.coin DESC";
		$stmt = $this->db->prepare($sql);
		if ($stmt) {
			$stmt->bindParam(':dateFrom',$dateFrom,PDO::PARAM_STR);
			$stmt->bindParam(':dateTo',$dateTo,PDO::PARAM_STR);
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