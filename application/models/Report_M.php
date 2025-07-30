<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_M extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();

        date_default_timezone_set('Asia/Jakarta');
    }

    public function get($report, $param, $obj)
    {
        $data = array();

        if ($report == "exitPermit") {
            if ($param == "dt1.necessity_id") {
                $query = "SELECT id, necessity FROM m_necessity";
                $row = $this->db->query($query)->num_rows();

                if ($row > 0) {
                    $data["res"] = $this->db->query($query)->result_array();
                } else {
                    return FALSE;
                }
            }
        }

        return $data;
    }
}
