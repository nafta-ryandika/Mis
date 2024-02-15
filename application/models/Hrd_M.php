<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hrd_M extends CI_Model
{
    public function check($param, $obj)
    {
        if ($param == "employeeId") {
            $query = "SELECT id FROM m_employee WHERE id = '" . $obj . "' OR card = '" . $obj . "'";
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

                    if ($row3 > 0) {
                        # code...
                    } else {
                    }
                } else if ($row2) {
                    # code...
                }
                return $res;
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
}
