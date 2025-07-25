<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hrd_M extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();

        date_default_timezone_set('Asia/Jakarta');
    }

    public function check($param, $obj)
    {
        // check status audit
        $data_audit = $this->db->get_where('m_audit_status', ['id' => 6])->row_array();
        $status_audit = $data_audit["status"];

        if ($status_audit == 1) {
            $t_exit_permit = "`mis`.t_audit_exit_permit";
            $m_employee = "hrms.audit_mmp_tb_m_kry";
        } else {
            $t_exit_permit = "`mis`.t_exit_permit";
            $m_employee = "hrms.tb_m_kry";
        }

        $data = array();
        if ($param == "employeeId") {
            $query = "SELECT 
                    Kode_Kry, Nama_Kry, Ucode_Div, Ucode_Dept, Ucode_Sec, Ucode_Jbt, No_RFID, 
                    (SELECT Nama_Div FROM hrms.tb_m_div WHERE Stat = 'Aktif' AND UCode_Div = a.UCode_Div) AS company,
                    (SELECT Nama_Dept FROM hrms.tb_m_dept WHERE Stat = 'Aktif' AND Ucode_Dept = a.Ucode_Dept) AS department,
                    (SELECT Nama_Sec FROM hrms.tb_m_sec WHERE Stat = 'Aktif' AND Ucode_Sec = a.Ucode_Sec) AS division,
                    (SELECT Nama_Jbt FROM hrms.tb_m_jbt WHERE Stat = 'Aktif' AND Ucode_Jbt = a.Ucode_Jbt) AS `position`,
                    a.Kode_Kry AS `id`,
                    a.Nama_Kry AS name
                    FROM " . $m_employee . " a
                    WHERE UCode_Div = '11330000000001'AND (Kode_Kry = '" . $obj . "' OR No_RFID = '" . $obj . "')";

            $row = $this->db->query($query)->num_rows();

            if ($row == 0) {
                $data['res'] = 0;
                $data['err'] = "Employee Data Not Found !";
            } else if ($row == 1) {
                $res = $this->db->query($query)->row_array();
                $employee_id = $res['id'];
                $data['id'] = $res['id'];
                $data['name'] = $res['name'];
                $data['department'] = $res['department'];
                $data['division'] = $res['division'];
                $data['position'] = $res['position'];

                $query2 = "SELECT 
                            *,
                            (SELECT necessity FROM m_necessity WHERE id = necessity_id) AS necessity 
                            FROM " . $t_exit_permit . " 
                            WHERE employee_id = '" . $employee_id . "' AND DATE(created_at) = CURDATE() AND date_in IS NULL AND time_in IS NULL AND status = 0";
                $row2 = $this->db->query($query2)->num_rows();

                if ($row2 == 0) {
                    $query3 = "SELECT 
                                *,
                                (SELECT necessity FROM m_necessity WHERE id = necessity_id) AS necessity 
                                FROM " . $t_exit_permit . " 
                                WHERE employee_id = '" . $employee_id . "' AND DATE(created_at) = (CURDATE() - INTERVAL 1 DAY) AND date_out IS NULL AND time_out IS NULL AND status = 0";
                    $row3 = $this->db->query($query3)->num_rows();
                    $res3 = $this->db->query($query3)->row_array();



                    if ($row3 > 0) {
                        $data['transaction_id'] = $res3['id'];
                        $data['date_out'] = date("d-m-Y", strtotime($res3['date_out']));
                        $data['time_out'] = $res3['time_out'];
                        $data['necessity_id'] = $res3['necessity_id'];
                        $data['necessity'] = $res3['necessity'];
                        $data['remark'] = $res3['remark'];
                        $data['res'] = 2;
                    } else {
                        $data['res'] = 1;
                    }
                } else if ($row2 == 1) {
                    $res2 = $this->db->query($query2)->row_array();
                    $data['transaction_id'] = $res2['id'];
                    $data['date_out'] = date("d-m-Y", strtotime($res2['date_out']));
                    $data['time_out'] = $res2['time_out'];
                    $data['necessity_id'] = $res2['necessity_id'];
                    $data['necessity'] = $res2['necessity'];
                    $data['remark'] = $res2['remark'];
                    $data['res'] = 2;
                }
            } else if ($row > 1) {
                $data['res'] = 0;
                $data['err'] = "Employee Data Duplicate !";
            }
        } else {
            $objx = explode("|", $obj);
            if ($objx[0] == "exitPermit") {
                if ($objx[1] == "detail") {
                    $query = "SELECT 
                                    dt1.*, 
                                    (SELECT Nama_Div FROM hrms.tb_m_div WHERE Stat = 'Aktif' AND UCode_Div = dt2.UCode_Div) AS company,
                                    (SELECT Nama_Dept FROM hrms.tb_m_dept WHERE Stat = 'Aktif' AND Ucode_Dept = dt2.Ucode_Dept) AS department,
                                    (SELECT Nama_Sec FROM hrms.tb_m_sec WHERE Stat = 'Aktif' AND Ucode_Sec = dt2.Ucode_Sec) AS division,
                                    (SELECT Nama_Jbt FROM hrms.tb_m_jbt WHERE Stat = 'Aktif' AND Ucode_Jbt = dt2.Ucode_Jbt) AS `position`,
                                    dt2.Nama_Kry AS `name`,
                                (SELECT necessity FROM `mis`.m_necessity WHERE id = dt1.necessity_id) AS necessity,
                                dt1.id AS transaction_id,  
                                dt2.Kode_Kry AS employee_id,
                                DATE_FORMAT(dt1.date_in, '%d-%m-%Y') as date_in,
                                DATE_FORMAT(dt1.date_out, '%d-%m-%Y') as date_out,  
                                DATE_FORMAT(dt1.created_at, '%d-%m-%Y %H:%i:%s') as created_at,
                                DATE_FORMAT(dt1.log_at, '%d-%m-%Y %H:%i:%s') as log_at    
                                FROM 
                                (
                                    SELECT * FROM " . $t_exit_permit . " a WHERE a.id = '" . $param . "'
                                )dt1
                                INNER JOIN 
                                (
                                SELECT 
                                    Kode_Kry, Nama_Kry, Ucode_Div, Ucode_Dept, Ucode_Sec, Ucode_Jbt, No_RFID
                                    FROM " . $m_employee . " b
                                    WHERE b.Ucode_Div = '11330000000001' 
                                )dt2
                                ON dt1.employee_id = dt2.Kode_Kry";
                    $row = $this->db->query($query)->num_rows();

                    if ($row > 0) {
                        $res = $this->db->query($query)->row_array();

                        $data['employee_id'] = $res['employee_id'];
                        $data['name'] = $res['name'];
                        $data['department'] = $res['department'];
                        $data['division'] = $res['division'];
                        $data['position'] = $res['position'];
                        $data['transaction_id'] = $res['transaction_id'];
                        $data['date_in'] = $res['date_in'];
                        $data['time_in'] = $res['time_in'];
                        $data['date_out'] = $res['date_out'];
                        $data['time_out'] = $res['time_out'];
                        $data['necessity_id'] = $res['necessity_id'];
                        $data['necessity'] = $res['necessity'];
                        $data['remark'] = $res['remark'];
                        $data['created_by'] = $res['created_by'];
                        $data['created_at'] = $res['created_at'];
                        $data['log_by'] = $res['log_by'];
                        $data['log_at'] = $res['log_at'];
                        $data['res'] = 3;
                    } else {
                        $data['res'] = 0;
                        $data['err'] = "Data Transaction Doesn't Exist !";
                    }
                } else if ($objx[1] == "edit") {
                    $query = "SELECT 
                                dt1.*, 
                                (SELECT Nama_Div FROM hrms.tb_m_div WHERE Stat = 'Aktif' AND UCode_Div = dt2.UCode_Div) AS company,
                                (SELECT Nama_Dept FROM hrms.tb_m_dept WHERE Stat = 'Aktif' AND Ucode_Dept = dt2.Ucode_Dept) AS department,
                                (SELECT Nama_Sec FROM hrms.tb_m_sec WHERE Stat = 'Aktif' AND Ucode_Sec = dt2.Ucode_Sec) AS division,
                                (SELECT Nama_Jbt FROM hrms.tb_m_jbt WHERE Stat = 'Aktif' AND Ucode_Jbt = dt2.Ucode_Jbt) AS `position`,
                                dt2.Nama_Kry AS `name`,
                            (SELECT necessity FROM `mis`.m_necessity WHERE id = dt1.necessity_id) AS necessity,
                            dt1.id AS transaction_id,  
                            dt2.Kode_Kry AS employee_id,
                            DATE_FORMAT(dt1.date_in, '%d-%m-%Y') as date_in,
                            DATE_FORMAT(dt1.date_out, '%d-%m-%Y') as date_out,  
                            DATE_FORMAT(dt1.created_at, '%d-%m-%Y %H:%i:%s') as created_at,
                            DATE_FORMAT(dt1.log_at, '%d-%m-%Y %H:%i:%s') as log_at    
                            FROM 
                            (
                                SELECT * FROM " . $t_exit_permit . " a WHERE a.id = '" . $param . "'
                            )dt1
                            INNER JOIN 
                            (
                            SELECT 
                                Kode_Kry, Nama_Kry, Ucode_Div, Ucode_Dept, Ucode_Sec, Ucode_Jbt, No_RFID
                                FROM " . $m_employee . " b
                                WHERE b.Ucode_Div = '11330000000001' 
                            )dt2
                            ON dt1.employee_id = dt2.Kode_Kry";
                    $row = $this->db->query($query)->num_rows();

                    if ($row > 0) {
                        $res = $this->db->query($query)->row_array();

                        $data['employee_id'] = $res['employee_id'];
                        $data['name'] = $res['name'];
                        $data['department'] = $res['department'];
                        $data['division'] = $res['division'];
                        $data['position'] = $res['position'];
                        $data['transaction_id'] = $res['transaction_id'];
                        $data['date_in'] = $res['date_in'];
                        $data['time_in'] = $res['time_in'];
                        $data['date_out'] = $res['date_out'];
                        $data['time_out'] = $res['time_out'];
                        $data['necessity_id'] = $res['necessity_id'];
                        $data['necessity'] = $res['necessity'];
                        $data['remark'] = $res['remark'];
                        $data['created_by'] = $res['created_by'];
                        $data['created_at'] = $res['created_at'];
                        $data['log_by'] = $res['log_by'];
                        $data['log_at'] = $res['log_at'];
                        $data['res'] = 4;
                    } else {
                        $data['res'] = 0;
                        $data['err'] = "Data Transaction Doesn't Exist !";
                    }
                }
            }
        }

        return $data;
    }

    public function get($param, $obj)
    {
        $data = array();

        if ($param == "inNecessity") {
            $query = "SELECT id, necessity FROM m_necessity";
            $row = $this->db->query($query)->num_rows();

            if ($row > 0) {
                $data["res"] = $this->db->query($query)->result_array();
            } else {
                return FALSE;
            }
        }

        return $data;
    }

    public function save($param, $obj, $inId, $inNecessity, $inRemark, $inTransaction_id)
    {
        // check status audit
        $data_audit = $this->db->get_where('m_audit_status', ['id' => 6])->row_array();
        $status_audit = $data_audit["status"];

        if ($status_audit == 1) {
            $t_exit_permit = "`mis`.t_audit_exit_permit";
            $m_employee = "hrms.audit_mmp_tb_m_kry";
        } else {
            $t_exit_permit = "`mis`.t_exit_permit";
            $m_employee = "hrms.tb_m_kry";
        }

        $curdate = date("Y-m-d");
        $curtime = date("H:i:s");
        $data = array();

        if ($param == 'add') {
            if ($obj == 'exitPermit') {
                $data_status = $this->db->get_where('m_necessity', ['id' => $inNecessity])->row_array();
                $status = $data_status["status"];
                $inStatus = "";

                if ($status == 1) {
                    $inStatus = 1;
                }

                if ($inTransaction_id != "") {
                    $data = array(
                        'necessity_id' => $inNecessity,
                        'remark' => $inRemark,
                        'status' => $inStatus,
                        'log_by' => $this->session->userdata['user_id'],
                        'log_at' => date("Y-m-d H:i:s")
                    );

                    $this->db->db_debug = false;

                    $this->db->where("id", $inTransaction_id);

                    if ($this->db->update($t_exit_permit, $data)) {
                        $data['res'] = 'success';
                    } else {
                        $data['res'] =  $this->db->error();
                        $data['res'] = $data['res']['message'];
                    }
                } else {
                    $data = array(
                        'employee_id' => $inId,
                        'date_out' => $curdate,
                        'time_out' => $curtime,
                        'necessity_id' => $inNecessity,
                        'remark' => $inRemark,
                        'status' => $inStatus,
                        'created_by' => $this->session->userdata['user_id']
                    );

                    $this->db->db_debug = false;

                    if ($this->db->insert($t_exit_permit, $data)) {
                        $data['res'] = 'success';
                    } else {
                        $data['res'] =  $this->db->error();
                        $data['res'] = $data['res']['message'];
                    }
                }
            }
        } else if ($param == 'update') {
            if ($obj == 'exitPermit') {
                $data = array(
                    'date_in' => $curdate,
                    'time_in' => $curtime,
                    'status' => '1',
                    'log_by' => $this->session->userdata['user_id'],
                    'log_at' => date("Y-m-d H:i:s")
                );

                $this->db->db_debug = false;

                $this->db->where("id", $inId);

                if ($this->db->update($t_exit_permit, $data)) {
                    $data['res'] = 'success';
                } else {
                    $data['res'] =  $this->db->error();
                    $data['res'] = $data['res']['message'];
                }
            }
        } else if ($param == 'new') {
            if ($obj == 'exitPermit') {
                $data = array(
                    'status' => '2',
                    'log_by' => $this->session->userdata['user_id'],
                    'log_at' => date("Y-m-d H:i:s")
                );

                $this->db->db_debug = false;

                $this->db->where("id", $inId);

                if ($this->db->update($t_exit_permit, $data)) {
                    $data['res'] = 'success';
                } else {
                    $data['res'] =  $this->db->error();
                    $data['res'] = $data['res']['message'];
                }
            }
        }

        return $data;
    }

    public function remove($param, $obj)
    {
        // check status audit
        $data_audit = $this->db->get_where('m_audit_status', ['id' => 6])->row_array();
        $status_audit = $data_audit["status"];

        if ($status_audit == 1) {
            $t_exit_permit = "`mis`.t_audit_exit_permit";
            $m_employee = "hrms.audit_mmp_tb_m_kry";
        } else {
            $t_exit_permit = "`mis`.t_exit_permit";
            $m_employee = "hrms.tb_m_kry";
        }

        $data = array();

        if ($obj == "exitPermit") {
            $this->db->db_debug = false;
            $this->db->where('id', $param);

            if ($this->db->delete($t_exit_permit)) {
                $data['res'] = 'success';
            } else {
                $data['res'] =  $this->db->error();
                $data['res'] = $data['res']['message'];
            }
        }

        return $data;
    }
}
