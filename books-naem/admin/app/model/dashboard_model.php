<?php
namespace App\Model;

require 'app/config/database.php';
use App\Config\Database;
use \PDO;
class DashboardModel extends Database{
	function __construct(){
		parent::__construct();
	}
	public function getFiveProBestSell(){
		$data = [];
		$sql = "SELECT quanity_sell, name_pd FROM products ORDER BY quanity_sell DESC LIMIT 0,5 ";
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
	public function getInfoCus(){
		$data = [];
		$sql = "SELECT * FROM customer";
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
	public function getOder(){
		$data = [];
		$sql = "SELECT * FROM bill WHERE status_bill = 1";
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
	public function getComment(){
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
}