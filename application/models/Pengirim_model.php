<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pengirim_model extends CI_Model
{
    public function getAllPengirim()
    {
        return $this->db->get('pengirim')->result_array();
    }
}
