<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller 
{
    public function index()
    {
        $data['title'] = 'My Profile';
        // $data['user'] = $this->db->get_where('user', [
        //     'username' => $this->session->userdata('username')
        // ])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('profile/index', $data);
		$this->load->view('templates/footer');
    }

}

/* End of file Profile.php */

?>