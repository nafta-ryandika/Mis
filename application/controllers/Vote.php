<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vote extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();
        $this->load->model("Vote_M");
    }

    public function index()
    {
        $data['title'] = 'Vote';
        $data['user'] = $this->db->get_where('m_user', ['user_id' => $this->session->userdata('user_id')])->row_array();
        $data['vote'] = $this->db->get('m_vote')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('vote/index', $data);
        $this->load->view('templates/footer');
        $this->load->view('templates/script', $data);
    }

    public function get()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        $data = $this->Vote_M->get($param, $obj);

        echo (json_encode($data));
    }

    public function check()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        $data = $this->Vote_M->check($param, $obj);

        echo (json_encode($data));
    }

    public function viewData()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        $query = "SELECT 
                    *,
                    (SELECT vote FROM m_vote WHERE id = a.vote_id) AS vote,
                    (SELECT remark FROM m_vote_candidate WHERE id = a.vote_candidate_id) AS `name`
                    FROM t_vote_count a 
                    WHERE vote_id = '" . $param . "'";

        $data['vote'] = $this->db->query($query)->result_array();

        $this->load->view('vote/view_data', $data);
    }

    public function save()
    {
        $param = $this->input->post('param');
        $obj = $this->input->post('obj');

        if ($param == 'vote') {
            $data = $this->Vote_M->save($param, $obj);
        }

        echo (json_encode($data));
    }
}
