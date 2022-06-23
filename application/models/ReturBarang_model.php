<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ReturBarang_model extends CI_Model
{

    public $table = 'retur_barang';
    public $id    = 'id_retur_barang';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }
}

/* End of file ReturBarang_model.php */