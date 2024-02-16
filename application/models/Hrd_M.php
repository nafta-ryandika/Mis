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
        if ($param == "employeeId") {
            $query = "SELECT *, 
                    (SELECT department FROM m_department WHERE id = department_id) AS department,
                    (SELECT division FROM m_division WHERE id = division_id) AS division,
                    (SELECT position FROM m_position WHERE id = position_id) AS position 
                    FROM m_employee 
                    WHERE id = '" . $obj . "' OR card = '" . $obj . "'";
            $row = $this->db->query($query)->num_rows();

            $data = array();

            if ($row == 0) {
                $data['res'] = 0;
                $data['err'] = "Employee Data Not Found !";
            } else if ($row == 1) {
                $res = $this->db->query($query)->row_array();
                $employee_id = $res['id'];

                $query2 = "SELECT * FROM t_exit_permit WHERE employee_id = '" . $employee_id . "' AND DATE(created_at) = CURDATE() AND date_out IS NULL AND time_out IS NULL";
                $row2 = $this->db->query($query2)->num_rows();

                if ($row2 == 0) {
                    $query3 = "SELECT * FROM t_exit_permit WHERE employee_id = '" . $employee_id . "' AND DATE(created_at) = (CURDATE() - INTERVAL 1 DAY) AND date_out IS NULL AND time_out IS NULL";
                    $row3 = $this->db->query($query3)->num_rows();

                    $data['name'] = $res['name'];
                    $data['department'] = $res['department'];
                    $data['division'] = $res['division'];
                    $data['position'] = $res['position'];

                    if ($row3 > 0) {
                        # code...
                    } else {
                        $data['res'] = 1;
                    }
                } else if ($row2 == 1) {
                    # code...
                }
                // return $res;
            } else if ($row > 1) {
                $data['res'] = 2;
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

    public function save($param, $obj, $inId, $inNecessity, $inRemark)
    {
        $curdate = date("Y-m-d");
        $curtime = date("H:i:s");

        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        if ($param == 'add') {
            if ($obj == 'exitPermit') {

                $data = array(
                    'employee_id' => $inId,
                    'date_in' => $curdate,
                    'time_in' => $curtime,
                    'necessity_id' => $inNecessity,
                    'remark' => $inRemark,
                    'created_by' => $this->session->userdata['user_id']
                );

                $this->db->db_debug = false;

                if ($this->db->insert('t_exit_permit', $data)) {
                    $res['res'] = 'success';
                } else {
                    $res['res'] =  $this->db->error();
                    $res['res'] = $res['res']['message'];
                }
            }
        }
    }
}
