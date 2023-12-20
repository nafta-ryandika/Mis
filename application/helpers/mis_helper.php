<?php

function checkLogin()
{
    $ci3 = get_instance();
    if (!$ci3->session->userdata('user_id')) {
        redirect('auth');
    } else {
        $role_id = $ci3->session->userdata('role_id');
        $menu = $ci3->uri->segment(1);

        $data_menu = $ci3->db->get_where('m_menu', ['menu' => $menu])->row_array();
        $menu_id = $data_menu['id'];

        $data_access = $ci3->db->get_where('m_access', ['role_id' => $role_id, 'menu_id' => $menu_id]);

        if ($data_access->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}
