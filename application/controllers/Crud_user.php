<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_user extends CI_Controller {

  function __construct()
	{
 parent::__construct();
 $this->load->model('m_user', '', TRUE);
  $this->load->model('m_rate', '', TRUE);
  $this->load->helper(array('form', 'url'));

	}

  public function index()
	{
    $x['datas']=$this->m_rate->get_rate();
    $x['default']=$this->m_user->get_pass();
    $this->load->view('v_header');
    $this->load->view('v_sidebar');
    $this->load->view('v_user',$x);
    $this->load->view('v_footer');
	}

  public function ajax_list()
	{
    	$this->load->model('m_user','user');
		$list = $this->m_user->get_datatables();
		$data = array();
    $data2 = array();
		$no = $_POST['start'];

		foreach ($list as $pekerja) {
			$no++;
			$row = array();
      $row[] = '<i class="fas fa-plus-circle"></i>';
      $row[] = $no;
      $row[] = $pekerja->user_name;
			$row[] = $pekerja->full_name;
			$row[] = $pekerja->user_email;
			$row[] = $pekerja->user_city;
      $row[] = $pekerja->position;
      $row[] = '<a href="'.base_url().'crud_user/edit/'. $pekerja->user_name.'"><button  class="btn btn-primary  btn-sm">
      <i class="fas fa-edit fa-sm"></i></button></a>
      <a data-target="#hapusmodal" data-toggle="modal" class="trash">
      <button class="btn btn-danger  btn-sm"><i class="fas fa-trash fa-sm"></i> </button></a>';

      $row[] = $pekerja->nip;
      $row[] = $pekerja->user_address;
      $row[] = $pekerja->telephone;
			$data[] = $row;

		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_user->count_all(),
						"recordsFiltered" => $this->m_user->count_filtered(),

						"data" => $data,

				);
		//output to json format
		echo json_encode($output);
	}

  public function data()
  {

		$data = array ('success' => false, 'messages' => array());

		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_name', 'User_name', 'trim|required|callback_user_check');
    //$this->form_validation->set_rules('password','PASSWORD','required');
		//$this->form_validation->set_rules('confirm_password','PASSWORD','required|matches[password]');
    //$this->form_validation->set_rules('nama_pekerja', 'Nama_pekerja', 'trim|required|min_length[5]|max_length[12]|callback_namadata_check');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    if($this->session->userdata("user_type") == "sa"){
      $superadmin = $this->input->post('user_type');
    }
    else {$superadmin = 'staff';}
		if($this->form_validation->run()) {
				$data = array (
					  'user_name' => $this->input->post('user_name'),
					  'password' => md5($this->input->post('passw')),
            'nip' => $this->input->post('nip'),
					  'full_name' => $this->input->post('full_name'),
          	'user_email' => $this->input->post('email'),
            'telephone' => $this->input->post('telephone'),
            'user_city' => $this->input->post('city'),
            'user_address' => $this->input->post('address'),
            'user_type' => $superadmin,
            'id_rate' => $this->input->post('position')
					       );
				$this->m_user->insert_all('user',$data);
        $data['success'] = true;
		    } else {
			       foreach ($_POST as $key => $value) {
			 	          $data['messages'][$key] = form_error($key);
			             }
		            }
		         echo json_encode($data);
	 }

   public function user_check($nim)
   {
       $where = array ('user_name'=>$nim);
       $check = $this->m_user->check_all('user',$where,1);
             if ($check)
             {
                     $this->form_validation->set_message('user_check', 'User {field} already exists');
                     return FALSE;
             }
             else
             {
                     return TRUE;
             }
  }

  function hapus(){
    $id_pekerja=$this->input->post('id_pekerja');
		$where = array('user_name' => $id_pekerja);
		$this->m_user->hapus_data($where,'user');
		redirect('crud_user');
	}

  function edit($project_code){
  $data['datas']=$this->m_rate->get_rate();
  $where = array('user_name' => $project_code);
  $data['user'] = $this->m_user->edit_data($where,'user')->result();
  $data['default']=$this->m_user->get_pass();
  $this->load->view('v_header');
  $this->load->view('v_sidebar');
  $this->load->view('v_user_edit',$data);
  $this->load->view('v_footer');
  }

  public function update_user()
    {

    $data = array ('success' => false, 'messages' => array());

    $this->load->library('form_validation');
    $this->form_validation->set_rules('user_name', 'User_name', 'trim|required');
    //$this->form_validation->set_rules('nama_pekerja', 'Nama_pekerja', 'trim|required|min_length[5]|max_length[12]|callback_namadata_check');
    //$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pekerja.email]');
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    if($this->session->userdata("user_type") == "sa"){
      $superadmin = $this->input->post('user_type');
    }
    else {$superadmin = 'staff';}

    if($this->form_validation->run()) {
      $data = array (
          'nip' => $this->input->post('nip'),
          'full_name' => $this->input->post('full_name'),
          'user_email' => $this->input->post('email'),
          'telephone' => $this->input->post('telephone'),
          'user_city' => $this->input->post('city'),
          'user_address' => $this->input->post('address'),
          'id_rate' => $this->input->post('position'),
          'user_type' => $superadmin,
               );
        $where = array ('user_name' => $this->input->post('user_name'),);
        $this->m_user->update_data($where,$data,'user');
        $data['success'] = true;
        } else {
             foreach ($_POST as $key => $value) {
                  $data['messages'][$key] = form_error($key);
                   }
                }
             echo json_encode($data);
      }

      public function reset_password()
        {

        $data = array ('success' => false, 'messages' => array());
            $this->load->library('form_validation');
        $this->form_validation->set_rules('user_name', 'User_name', 'trim|required');
        //$this->form_validation->set_rules('nama_pekerja', 'Nama_pekerja', 'trim|required|min_length[5]|max_length[12]|callback_namadata_check');
        //$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pekerja.email]');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

        if($this->form_validation->run()) {
          $x=$this->m_user->get_pass();
          foreach($x ->result() as $row){
            $pass= $row->information_name;
          }
          $data = array (
              'password' => md5($pass),
              'validate' => NULL
                   );
            $where = array ('user_name' => $this->input->post('user_name'),);
            $this->m_user->update_data($where,$data,'user');
            $data['success'] = true;
            } else {
                 foreach ($_POST as $key => $value) {
                      $data['messages'][$key] = form_error($key);
                       }
                    }
                 echo json_encode($data);
          }
}
