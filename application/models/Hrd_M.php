<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_M extends CI_Model
{
    public function check($param, $obj)
    {
        if ($param == "employeeId") {
            $query = "SELECT * FROM m_employee WHERE id = '" . $obj . "' OR card = '" . $obj . "'";
            $row = $this->db->query($query)->num_rows();

            if ($row == 0) {
                # code...
            } else if ($row == 1) {
                $res = $this->db->query($query)->row_array();
                return $res;
            } else if ($row > 1) {
                # code...
            }
        }

        return $this->db->query($query)->result_array();
    }
}
