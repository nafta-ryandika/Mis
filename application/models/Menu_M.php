<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_M extends CI_Model
{
    public function getSubmenu()
    {
        $query = "SELECT a.*, b.menu 
                    FROM m_submenu a 
                    JOIN m_menu b
                    ON a.menu_id = b.id";

        return $this->db->query($query)->result_array();
    }
}
