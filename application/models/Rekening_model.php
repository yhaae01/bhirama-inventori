<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rekening_model extends CI_Model 
{
    public $table = 'rekening';
    public $id    = 'id_rekening';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {
        $this->datatables->select('id_rekening,nama_pemilik,bank,nomor_rekening');
        $this->datatables->from('rekening');
        $this->datatables->add_column(
            'action',
            '<div class="btn-group">' .
                form_open('master/Rekening/update/$1') .
                form_button(['type' => 'submit', 'title' => 'Edit', 'class' => 'btn btn-warning', 'content' => '<i class="fas fa-pencil-alt"> </i>']) .
                form_close() . "&nbsp;" .
                form_open('master/Rekening/delete/$1') .
                form_button(['type' => 'submit', 'title' => 'Hapus', 'class' => 'btn btn-danger'], '<i class="fas fa-trash-alt"> </i>', 'onclick="javascript: return confirm(\'Are You Sure ?\')"') .
                form_close() . '</div>',
            'id_rekening'
        );

        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id_rekening', $q);
        $this->db->or_like('nama_pemilik', $q);
        $this->db->or_like('bank', $q);
        $this->db->or_like('nomor_rekening', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_rekening', $q);
        $this->db->or_like('nama_pemilik', $q);
        $this->db->or_like('bank', $q);
        $this->db->or_like('nomor_rekening', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file rekening_model.php */

?>