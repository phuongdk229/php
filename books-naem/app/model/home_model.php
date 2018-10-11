<?php
namespace App\Model;
if (!defined('APP_PATH')) {
	die('can not access');
}
require 'app/config/database.php';
use App\Config\Database;
use \PDO;
class HomeModel extends Database{
	function __construct(){
		parent::__construct();
	}
	public function getBestSell(){
		$data = [];
		$sql = "SELECT * FROM products AS c ORDER BY c.quanity_sell DESC LIMIT 0,8";
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
	public function getNewProduct(){
		$data = [];
		$sql = "SELECT * FROM products AS p ORDER BY p.id DESC LIMIT 0,8";
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
	public function getImageForSlide(){
		$data = [];
		$sql = "SELECT name_pic FROM banner AS b ORDER BY b.id DESC LIMIT 0,3 ";
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