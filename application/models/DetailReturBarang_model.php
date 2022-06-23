<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DetailReturBarang_model extends CI_Model
{

    public $table = 'detail_retur_barang';
    public $id    = 'id_detail_retur_barang';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }
}

/* End of file DetailReturBarang_model.php */