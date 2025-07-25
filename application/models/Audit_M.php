<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit_M extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        checkLogin();

        date_default_timezone_set('Asia/Jakarta');
    }
}
