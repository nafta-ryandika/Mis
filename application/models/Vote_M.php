<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vote_M extends CI_Model
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

            $query =    "SELECT 
                        id, vote_id, card, `name`, department_id, division_id, position_id, `status` 
                        FROM m_vote_participant a 
                        WHERE a.card = '" . $datax[0] . "' AND vote_id = '" . $datax[1] . "'";
            $row = $this->db->query($query)->num_rows();

            if ($row == 0) {
                $query1 =    "SELECT 
                        id, vote_id, card, `name`, department_id, division_id, position_id, `status` 
                        FROM m_vote_participant a 
                        WHERE a.id = '" . $datax[0] . "' AND vote_id = '" . $datax[1] . "'";
                $row1 = $this->db->query($query1)->num_rows();

                if ($row1 == 0) {
                    $res['res'] = 0;
                    $res['err'] = "Participant Data Not Found !";
                } else if ($row1 > 1) {
                    $res['res'] = 0;
                    $res['err'] = "Participant Duplicate Data !";
                } else {
                    $data1 = $this->db->query($query1)->row_array();
                    $status1 = $data1['status'];

                    if ($status1 == 1) {
                        $res['res'] = 0;
                        $res['err'] = "Participant Has Been Voted !";
                    } else {
                        $res['id'] = $data1['id'];
                        $res['vote_id'] = $data1['vote_id'];
                        $res['card'] = $data1['card'];
                        $res['name'] = $data1['name'];
                        $res['department_id'] = $data1['department_id'];
                        $res['division_id'] = $data1['division_id'];
                        $res['position_id'] = $data1['position_id'];
                    }
                }
            } else {
                $data = $this->db->query($query)->row_array();
                $status = $data['status'];

                if ($status == 1) {
                    $res['res'] = 0;
                    $res['err'] = "Participant Has Been Voted !";
                } else {
                    $res['id'] = $data['id'];
                    $res['vote_id'] = $data['vote_id'];
                    $res['card'] = $data['card'];
                    $res['name'] = $data['name'];
                    $res['department_id'] = $data['department_id'];
                    $res['division_id'] = $data['division_id'];
                    $res['position_id'] = $data['position_id'];
                }
            }
        }

        return $res;
    }

    public function get($param, $obj)
    {
        $res = array();

        if ($param == "inLocation") {
            $query = "SELECT `id`, `name`, `location` FROM m_vote_location WHERE vote_id = '" . $obj . "' ORDER BY name";
            $row = $this->db->query($query)->num_rows();

            if ($row > 0) {
                $res["res"] = $this->db->query($query)->result_array();
            } else {
                return FALSE;
            }
        } else if ($param == "candidate") {
            $query = "SELECT `id`, vote_id, employee_id, `no`, `image`, remark FROM m_vote_candidate a WHERE a.vote_id = '" . $obj . "' ORDER BY `no`";
            $row = $this->db->query($query)->num_rows();

            if ($row > 0) {
                $res["res"] = $this->db->query($query)->result_array();
            } else {
                return FALSE;
            }
        }

        return $res;
    }

    public function save($param, $obj)
    {
        $res = array();

        if ($param == 'vote') {
            $datax = explode("|", $obj);
            $employee_id = $datax[0];
            $vote_id = $datax[1];
            $vote_candidate_id = $datax[2];
            $location_id = $datax[3];

            //update status data participant
            $data = array(
                'status' => 1,
                'created_by' => $this->session->userdata['user_id'],
                'created_at' => date("Y-m-d H:i:s")
            );

            $this->db->db_debug = false;

            $this->db->where("id", $employee_id);
            $this->db->where("vote_id", $vote_id);

            if ($this->db->update("m_vote_participant", $data)) {
                //update data vote_count

                $query = "UPDATE 
                            t_vote_count 
                            SET 
                            total = total + 1,
                            created_by = '" . $this->session->userdata['user_id'] . "',
                            created_at = '" . date("Y-m-d H:i:s") . "' 
                            WHERE 
                            vote_id = '" . $vote_id . "' AND 
                            vote_candidate_id = '" . $vote_candidate_id . "'";

                if ($this->db->query($query)) {
                    //insert data vote_detail
                    $data = array(
                        'location_id' => $location_id,
                        'vote_id' => $vote_id,
                        'candidate_id' => $vote_candidate_id,
                        'created_by' => $this->session->userdata['user_id']
                    );

                    $this->db->db_debug = false;

                    if ($this->db->insert("t_vote_detail", $data)) {
                        $res['res'] = 'success';
                    } else {
                        $res['res'] =  $this->db->error();
                        $res['res'] = $data['res']['message'];
                    }

                    $res['res'] = 'success';
                } else {
                    $res['res'] =  $this->db->error();
                    $res['res'] = $data['res']['message'];
                }

                $data['res'] = 'success';
            } else {
                $data['res'] =  $this->db->error();
                $data['res'] = $data['res']['message'];
            }

            return $res;
        }
    }
}
