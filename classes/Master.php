<?php
require_once('../config.php');
class Master extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	function capture_err()
	{
		if (!$this->conn->error)
			return false;
		else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}

	/**
	 * Suppliers
	 * ====================================================
	 */

	function save_supplier()
	{

		extract($_POST);

		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				$v = addslashes(trim($v));
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `supplier_list` where `name` = '{$name}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Supplier already exist.";
			return json_encode($resp);
			exit;
		}

		if (empty($id)) {
			$sql = "INSERT INTO `supplier_list` set {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `supplier_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}

		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Supplier successfully saved.");
			else
				$this->settings->set_flashdata('success', "Supplier successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}

	function delete_supplier()
	{

		extract($_POST);

		$del = $this->conn->query("DELETE FROM `supplier_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Supplier successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	/**
	 * Projects/Cost Centers
	 * ====================================================
	 */

	function save_project()
	{

		extract($_POST);

		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				$v = addslashes(trim($v));
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		$check = $this->conn->query("SELECT * FROM `project_list` where `name` = '{$name}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;

		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Project already exist.";
			return json_encode($resp);
			exit;
		}

		if (empty($id)) {
			$sql = "INSERT INTO `project_list` set {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `project_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}

		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Project successfully saved.");
			else
				$this->settings->set_flashdata('success', "Project successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}

	function delete_project()
	{

		$id = $_POST['id'];

		$del = $this->conn->prepare("DELETE FROM `project_list` where id = ?");
		$del->bind_param("s", $id);
		$del->execute();
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Project successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	/**
	 * Items
	 * ====================================================
	 */

	function save_item()
	{

		extract($_POST);

		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}

		$check = $this->conn->query("SELECT * FROM `item_list` where `name` = '{$name}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;

		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Item Name already exist.";
			return json_encode($resp);
			exit;
		}

		if (empty($id)) {
			$sql = "INSERT INTO `item_list` set {$data} ";
		} else {
			$sql = "UPDATE `item_list` set {$data} where id = '{$id}' ";
		}

		$save = $this->conn->query($sql);

		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New item successfully saved.");
			else
				$this->settings->set_flashdata('success', "item successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}

	function delete_item()
	{

		extract($_POST);

		$del = $this->conn->query("DELETE FROM `item_list` where id = '{$id}'");

		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "item successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function search_items()
	{

		extract($_POST);

		$qry = $this->conn->query("SELECT * FROM item_list where `name` LIKE '%{$q}%'");

		$data = array();
		while ($row = $qry->fetch_assoc()) {
			$data[] = array("label" => $row['name'], "unit" => $row['unit'], "id" => $row['id'], "description" => $row['description'], "selling_price" => $row['selling_price']);
		}
		return json_encode($data);
	}

	/**
	 * Purchase Orders
	 * ====================================================
	 */

	function save_po()
	{

		extract($_POST);
		$data = "";

		foreach ($_POST as $k => $v) {
			if (in_array($k, array('discount_amount', 'tax_amount')))
				$v = str_replace(',', '', $v);
			if (!in_array($k, array('id', 'po_no')) && !is_array($_POST[$k])) {
				$v = addslashes(trim($v));
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		if (!empty($po_no)) {
			$check = $this->conn->query("SELECT * FROM `po_list` where `po_no` = '{$po_no}' " . ($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
			if ($this->capture_err())
				return $this->capture_err();
			if ($check > 0) {
				$resp['status'] = 'po_failed';
				$resp['msg'] = "Purchase Order Number already exist.";
				return json_encode($resp);
				exit;
			}
		} else {
			$po_no = "";
			while (true) {
				$po_no = "PO-" . (sprintf("%'.06d", mt_rand(1, 999999)));
				$check = $this->conn->query("SELECT * FROM `po_list` where `po_no` = '{$po_no}'")->num_rows;
				if ($check <= 0)
					break;
			}
		}

		$data .= ", po_no = '{$po_no}' ";

		if (empty($id)) {
			$sql = "INSERT INTO `po_list` set {$data} ";
		} else {
			$sql = "UPDATE `po_list` set {$data} where id = '{$id}' ";
		}

		$save = $this->conn->query($sql);

		if ($save) {
			$resp['status'] = 'success';
			$po_id = empty($id) ? $this->conn->insert_id : $id;
			$resp['id'] = $po_id;
			$data = "";
			foreach ($item_id as $k => $v) {
				if (!empty($data)) $data .= ",";
				$data .= "('{$po_id}','{$v}','{$qty[$k]}')";
			}
			if (!empty($data)) {
				$this->conn->query("DELETE FROM `order_items` where po_id = '{$po_id}'");
				$save = $this->conn->query("INSERT INTO `order_items` (`po_id`,`item_id`,`quantity`) VALUES {$data} ");
			}
			if (empty($id))
				$this->settings->set_flashdata('success', "Purchase Order successfully saved.");
			else
				$this->settings->set_flashdata('success', "Purchase Order successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}

	function delete_po()
	{

		extract($_POST);

		$del = $this->conn->query("DELETE FROM `po_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Purchase Order successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function approve_po()
	{
		extract($_POST);
		$confirm = $this->conn->query("UPDATE po_list SET status = 1 WHERE id = '{$id}'");
		if ($confirm) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Purchase Order Succesfully Approved.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	/**
	 * Requisition Orders
	 * ====================================================
	 */

	function save_rq()
	{
		extract($_POST);

		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'rq_no')) && !is_array($_POST[$k])) {
				$v = addslashes(trim($v));
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}

		if (!empty($rq_no)) {
			$check = $this->conn->query("SELECT * FROM `rq_list` where `rq_no` = '{$rq_no}' " . ($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
			if ($this->capture_err())
				return $this->capture_err();
			if ($check > 0) {
				$resp['status'] = 'rq_failed';
				$resp['msg'] = "Requisition Number already exist.";
				return json_encode($resp);
				exit;
			}
		} else {
			$rq_no = "";
			while (true) {
				$rq_no = "RQ-" . (sprintf("%'.06d", mt_rand(1, 999999)));
				$check = $this->conn->query("SELECT * FROM `rq_list` where `rq_no` = '{$rq_no}'")->num_rows;
				if ($check <= 0)
					break;
			}
		}

		$data .= ", rq_no = '{$rq_no}' ";

		if (empty($id)) {
			$sql = "INSERT INTO `rq_list` set {$data} ";
		} else {
			$sql = "UPDATE `rq_list` set {$data} where id = '{$id}' ";
		}

		$save = $this->conn->query($sql);

		if ($save) {
			$resp['status'] = 'success';
			$rq_id = empty($id) ? $this->conn->insert_id : $id;
			$resp['id'] = $rq_id;
			$data = "";
			foreach ($item_id as $k => $v) {
				if (!empty($data)) $data .= ",";
				$data .= "('{$rq_id}','{$v}','{$qty[$k]}')";
			}
			if (!empty($data)) {
				$this->conn->query("DELETE FROM `requisition_items` where rq_id = '{$rq_id}'");
				$save = $this->conn->query("INSERT INTO `requisition_items` (`rq_id`,`item_id`,`quantity`) VALUES {$data} ");
			}
			if (empty($id))
				$this->settings->set_flashdata('success', "Requisition Order successfully saved.");
			else
				$this->settings->set_flashdata('success', "Requisition Order successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}

	function delete_rq()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `rq_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Requisition Order successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function approve_requisition()
	{
		extract($_POST);
		$confirm = $this->conn->query("UPDATE rq_list SET status = 1 WHERE id = '{$id}'");
		if ($confirm) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Requisition Order Succesfully Approved.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	/**
	 * Deliveries
	 * ====================================================
	 */

	// function save_dn()
	// {

	// 	extract($_POST);

	// 	$data = "";
	// 	foreach ($_POST as $k => $v) {
	// 		if (!in_array($k, array('id', 'dn_no')) && !is_array($_POST[$k])) {
	// 			$v = addslashes(trim($v));
	// 			if (!empty($data)) $data .= ",";
	// 			$data .= " `{$k}`='{$v}' ";
	// 		}
	// 	}
	// 	if (!empty($dn_no)) {
	// 		$check = $this->conn->query("SELECT * FROM `delivery_list` where `dn_no` = '{$dn_no}' " . ($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
	// 		if ($this->capture_err())
	// 			return $this->capture_err();
	// 		if ($check > 0) {
	// 			$resp['status'] = 'dn_failed';
	// 			$resp['msg'] = "Delivery Number already exist.";
	// 			return json_encode($resp);
	// 			exit;
	// 		}
	// 	} else {
	// 		$dn_no = "";
	// 		while (true) {
	// 			$dn_no = "DN-" . (sprintf("%'.06d", mt_rand(1, 999999)));
	// 			$check = $this->conn->query("SELECT * FROM `delivery_list` where `dn_no` = '{$dn_no}'")->num_rows;
	// 			if ($check <= 0)
	// 				break;
	// 		}
	// 	}

	// 	$data .= ", dn_no = '{$dn_no}' ";

	// 	if (empty($id)) {
	// 		$sql = "INSERT INTO `delivery_list` set {$data} ";
	// 	} else {
	// 		$sql = "UPDATE `delivery_list` set {$data} where id = '{$id}' ";
	// 	}

	// 	$save = $this->conn->query($sql);

	// 	if ($save) {
	// 		$resp['status'] = 'success';
	// 		$dn_id = empty($id) ? $this->conn->insert_id : $id;
	// 		$resp['id'] = $dn_id;
	// 		$data = "";
	// 		foreach ($item_id as $k => $v) {
	// 			if (!empty($data)) $data .= ",";
	// 			$data .= "('{$dn_id}','{$v}','{$qty[$k]}')";
	// 		}
	// 		if (!empty($data)) {
	// 			$this->conn->query("DELETE FROM `delivery_items` where dn_id = '{$dn_id}'");
	// 			$save = $this->conn->query("INSERT INTO `delivery_items` (`dn_id`,`item_id`,`quantity`) VALUES {$data} ");
	// 		}
	// 		if (empty($id))
	// 			$this->settings->set_flashdata('success', "Delivery Note successfully saved.");
	// 		else
	// 			$this->settings->set_flashdata('success', "Delivery Note successfully updated.");
	// 	} else {
	// 		$resp['status'] = 'failed';
	// 		$resp['err'] = $this->conn->error . "[{$sql}]";
	// 	}
	// 	return json_encode($resp);
	// }

	function save_dn(){
        
        if (empty($_POST['id'])) {
            $prefix = "BO";
            $code = sprintf("%'.04d", 1);
            while (true) {
                $check_code = $this->conn->query("SELECT * FROM `backorder_list` where `bo_code` ='" . $prefix . '-' . $code . "' ")->num_rows;
                if ($check_code > 0) {
                    $code = sprintf("%'.04d", $code + 1);
                } else {
                    break;
                }
            }
            $_POST['bo_code'] = $prefix . "-" . $code;
        }else{
			$get = $this->conn->query("SELECT * FROM backorder_list where rq_id = '{$_POST['rq_no']}' ");
			if($get->num_rows > 0){
				$res = $get->fetch_array();
				$bo_id = $res['id'];
				$_POST['bo_code'] = $res['bo_code'];	
			}else{

				$prefix = "BO";
				$code = sprintf("%'.04d",1);
				while(true){
					$check_code = $this->conn->query("SELECT * FROM `back_order_list` where bo_code ='".$prefix.'-'.$code."' ")->num_rows;
					if($check_code > 0){
						$code = sprintf("%'.04d",$code+1);
					}else{
						break;
					}
				}
				$_POST['bo_code'] = $prefix."-".$code;

			}
		}

		extract($_POST);
        $data = "";

        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id','bo_code','dn_no')) && !is_array($_POST[$k])) {
                $v = addslashes(trim($v));
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
            }
        }

        if (!empty($dn_no)) {
			$check = $this->conn->query("SELECT * FROM `delivery_list` where `dn_no` = '{$dn_no}' " . ($id > 0 ? " and id != '{$id}' " : ""))->num_rows;
			if ($this->capture_err())
				return $this->capture_err();
			if ($check > 0) {
				$resp['status'] = 'dn_failed';
				$resp['msg'] = "Delivery Number already exist.";
				return json_encode($resp);
				exit;
			}
		} else {
			$dn_no = "";
			while (true) {
				$dn_no = "DN-" . (sprintf("%'.06d", mt_rand(1, 999999)));
				$check = $this->conn->query("SELECT * FROM `delivery_list` where `dn_no` = '{$dn_no}'")->num_rows;
				if ($check <= 0)
					break;
			}
		}

		$data .= ", dn_no = '{$dn_no}' ";

        if (empty($id)) {
			$sql = "INSERT INTO `delivery_list` set {$data} ";
		} else {
			$sql = "UPDATE `delivery_list` set {$data} where id = '{$id}' ";
		}

        $save = $this->conn->query($sql);

        if ($save) {
            $resp['status'] = 'success';
			$dn_id = empty($id) ? $this->conn->insert_id : $id;
			$resp['id'] = $dn_id;
			$data = "";
            foreach ($item_id as $k => $v) {
				if (!empty($data)) $data .= ",";
				$data .= "('{$dn_id}','{$v}','{$qty[$k]}')";
				if($qty[$k] < $oqty[$k]){
					$bo_ids[] = $k;
				}
			}
			if (!empty($data)) {
				$this->conn->query("DELETE FROM `delivery_items` where dn_id = '{$dn_id}'");
				$save = $this->conn->query("INSERT INTO `delivery_items` (`dn_id`,`item_id`,`quantity`) VALUES {$data} ");
			}
            
            if (isset($bo_ids)) {
                $this->conn->query("UPDATE `rq_list` set status = 2 where id = '{$rq_no}'");
                if (!isset($bo_id)) {
                    $sql = "INSERT INTO `backorder_list` set bo_code = '{$bo_code}', rq_id = '{$rq_no}'";
                }
                $bo_save = $this->conn->query($sql);
                if (!isset($bo_id))
                    $bo_id = $this->conn->insert_id;
                $data = "";
                foreach ($item_id as $k => $v) {
                    if (!in_array($k, $bo_ids))
                        continue;
                    if (!empty($data)) $data .= ",";
                    $data .= " ('{$bo_id}','{$v}','" . ($oqty[$k] - $qty[$k]) . "') ";
                }
                $this->conn->query("DELETE FROM `backorder_items` where bo_id='{$bo_id}'");
                $save_backorder_items = $this->conn->query("INSERT INTO `backorder_items` (`bo_id`,`item_id`,`quantity`) VALUES {$data}");
                
            } else {
                $this->conn->query("UPDATE `rq_list` set status = 3 where id = '{$rq_no}'");
            }
        } else {
            $resp['status'] = 'failed';
            $resp['msg'] = 'An error occured. Error: ' . $this->conn->error;
        }
        if ($resp['status'] == 'success') {
            if (empty($id)) {
                $this->settings->set_flashdata('success', " Requisition order succesfully processed.");
            } else {
                $this->settings->set_flashdata('success', " Requisition order succesfully updated.");
            }
        }

        return json_encode($resp);
    }

	function delete_dn(){

		extract($_POST);

		$del = $this->conn->query("DELETE FROM `delivery_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Delivery Note successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function confirm_delivery(){
		
		extract($_POST);
		
		$confirm = $this->conn->query("UPDATE `delivery_list` SET `status` = '1', `date_received` = current_timestamp(), `received_by` = 2 where id = '{$id}'");
		if ($confirm) {

			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Delivery Succesfully Confirmed.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}

		return json_encode($resp);
	}

	//.............................................................................................//

	function delete_img()
	{

		extract($_POST);

		if (is_file($path)) {
			if (unlink($path)) {
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete ' . $path;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown ' . $path . ' path';
		}
		return json_encode($resp);
	}

	/**
	 * Invoice
	 * ====================================================
	 */

	 function generate_invoice(){
		
		extract($_POST);

		$dn_id = $id;

		if (!empty($in_no)) {
			$check = $this->conn->query("SELECT * FROM `invoice_list` where `in_no` = '{$in_no}' ")->num_rows;
			if ($this->capture_err())
				return $this->capture_err();
			if ($check > 0) {
				$resp['status'] = 'in_failed';
				$resp['msg'] = "Invoice already exist.";
				return json_encode($resp);
				exit;
			}
		} else {
			$in_no = "";
			while (true) {
				$in_no = "IN-" . (sprintf("%'.06d", mt_rand(1, 999999)));
				$check = $this->conn->query("SELECT * FROM `invoice_list` where `in_no` = '{$in_no}'")->num_rows;
				if ($check <= 0)
					break;
			}
		}

		$sql = "INSERT INTO invoice_list (dn_id, in_no) VALUES ('$dn_id', '$in_no')";
		

		$save = $this->conn->query($sql);

		if ($save) {
			$resp['status'] = 'success';
			$resp['id'] = $this->conn->insert_id;

			if (empty($id))
				$this->settings->set_flashdata('success', "Invoice successfully saved.");
			else
				$this->settings->set_flashdata('success', "Invoice successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		return json_encode($resp);
	}
	
	function delete_in(){

		extract($_POST);

		$del = $this->conn->query("DELETE FROM `invoice_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Invoice successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_supplier':
		echo $Master->save_supplier();
		break;
	case 'delete_supplier':
		echo $Master->delete_supplier();
		break;
	case 'save_project':
		echo $Master->save_project();
		break;
	case 'delete_project':
		echo $Master->delete_project();
		break;
	case 'confirm_delivery':
		echo $Master->confirm_delivery();
		break;
	case 'save_item':
		echo $Master->save_item();
		break;
	case 'delete_item':
		echo $Master->delete_item();
		break;
	case 'search_items':
		echo $Master->search_items();
		break;
	case 'save_po':
		echo $Master->save_po();
		break;
	case 'delete_po':
		echo $Master->delete_po();
		break;
	case 'approve_po':
		echo $Master->approve_po();
		break;
	case 'save_rq':
		echo $Master->save_rq();
		break;
	case 'delete_rq':
		echo $Master->delete_rq();
		break;
	case 'approve_requisition':
		echo $Master->approve_requisition();
		break;
	case 'save_dn':
		echo $Master->save_dn();
		break;
	case 'delete_dn':
		echo $Master->delete_dn();
		break;
	case 'delete_in':
		echo $Master->delete_in();
		break;

	default:
		// echo $sysset->index();
		break;
}
