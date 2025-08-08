<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fair_trade_M extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();

        date_default_timezone_set('Asia/Jakarta');
    }

    public function check($param, $obj)
    {
        $res = array();
        if ($param == "inId") {
            $datax = explode("|", $obj);

            $collection_id = $datax[0];
            $employee_id = $datax[1];

            $query = "SELECT * FROM 
                        (
                            SELECT 
                                id, collection_id, `status` 
                            FROM m_employee_collection
                            WHERE
                                collection_id = '" . $collection_id . "'
                        )dt1 
                        JOIN 
                        (
                            SELECT 
                                Kode_Kry, Nama_Kry, No_RFID 
                            FROM hrms.tb_m_kry 
                            WHERE 
                                Stat = 'Aktif' AND (Kode_Kry = '" . $employee_id . "' OR No_RFID = '" . $employee_id . "')
                        )dt2
                        ON dt1.id = dt2.Kode_Kry";

            $row = $this->db->query($query)->num_rows();

            if ($row > 1) {
                $res['res'] = "Error";
                $res['err'] = "Duplicate Data !";
            } else if ($row == 0) {
                $res['res'] = "Error";
                $res['err'] = "Data Not Found !";
            } else {
                $data = $this->db->query($query)->row_array();
                $employee_id = $data['id'];
                $status = $data['status'];

                if ($status == 1) {
                    $res['res'] = "Error";
                    $res['err'] = "Participant Has Been Collected !";
                } else {
                    $data1 = array(
                        'status' => 1,
                        'created_by' => $this->session->userdata['user_id'],
                        'created_at' => date("Y-m-d H:i:s")
                    );

                    $this->db->db_debug = false;

                    $this->db->where("id", $employee_id);
                    $this->db->where("collection_id", $collection_id);

                    if ($this->db->update("m_employee_collection", $data1)) {
                        $res['res'] = "Success";
                        $res['err'] = "";
                    } else {
                        $res['res'] = "Error";
                        $res['err'] = "Collect Data Error !";
                    }
                }
            }
        }

        return $res;
    }

    public function get($param, $obj)
    {
        $data = array();

        if ($param == "dt2.Ucode_Dept") {
            $query = "SELECT UCode_Dept, Nama_Dept FROM hrms.tb_m_dept";
            $row = $this->db->query($query)->num_rows();

            if ($row > 0) {
                $data["res"] = $this->db->query($query)->result_array();
            } else {
                return FALSE;
            }
        } else if ($param == "dt2.Ucode_Sec") {
            $query = "SELECT UCode_Sec, Nama_Sec FROM hrms.tb_m_sec";
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
