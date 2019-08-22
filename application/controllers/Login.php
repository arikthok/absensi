<?php

class Login extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('m_login');

	}

	function index(){
		$this->load->view('v_login');
	}

	function aksi_login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'user_name' => $username,
			'password' => md5($password)
			);

		$cek = $this->m_login->cek_login("user",$where);
		if($cek ->num_rows() > 0)
		{
			$where2 = array('user_name' => $username,'validate' => NULL);
			$cek2 = $this->m_login->cek_login("user",$where2);
			$data_username = array(
				'id_user' => $username
				);
			$this->session->set_userdata($data_username);
			if($cek2 ->num_rows() < 1){
						$data=$cek->row_array();
						$data_session = array(
							'nama' => $data['full_name'],
							'status' => "login",
							'id_user' => $username,
							'user_type' => $data['user_type']
							);

						$this->session->set_userdata($data_session);

						if($this->session->userdata("user_type") == "staff"){
							redirect(base_url("crud_absent"));
						}
						else {
						redirect(base_url("admin"));
						}
				}
				else
					{
						//ganti password
					redirect(base_url('login/ganti_password/'));
					}
		}else{
			$url=base_url();
      echo $this->session->set_flashdata('msg','<p class="text-danger"> Username Atau Password Salah !!!</p>');
      redirect($url);
		}
	}

	function ganti_password(){
	$this->load->view('v_ganti_password');
	}

	public function update_password()
    {

    $data = array ('success' => false, 'messages' => array());

    $this->load->library('form_validation');
		$this->form_validation->set_rules('password','PASSWORD','required');
		$this->form_validation->set_rules('comfirm_password','PASSWORD','required|matches[password]');
		//$this->form_validation->set_rules('nama_pekerja', 'Nama_pekerja', 'trim|required|min_length[5]|max_length[12]|callback_namadata_check');
    //$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pekerja.email]');
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    if($this->form_validation->run()) {
      $data = array (
          'password' =>  md5($this->input->post('password')),
          'validate' => "1"
               );
        $where = array ('user_name' => $this->session->userdata("id_user"));
        $this->m_login->update_password($where,$data,'user');
        $data['success'] = true;
        } else {
             foreach ($_POST as $key => $value) {
                  $data['messages'][$key] = form_error($key);
                   }
                }
             echo json_encode($data);
      }

	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}
