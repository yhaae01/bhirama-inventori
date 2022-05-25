<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MetodePembayaran_model extends CI_Model
{
    public function getAllMetodePembayaran()
    {
        return $this->db->get('metodePembayaran')->result_array();
    }
}
