<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_client extends CI_Controller {

  function __construct()
	{
 parent::__construct();
 $this->load->model('m_client', '', TRUE);
  $this->load->helper(array('form', 'url'));

	}

  public function index()
	{
    $this->load->view('v_header');
    $this->load->view('v_sidebar');
    $this->load->view('v_client');
    $this->load->view('v_footer');
	}

  public function hapus()
  {  $id_pekerja=$this->input->post('id_pekerja');
		$where = array('client_id' => $id_pekerja);
		$this->m_client->hapus_data($where,'client');
		redirect('crud_client');
   }




    public function ajax_list()
  	{
      	$this->load->model('m_client','client');
  		$list = $this->m_client->get_datatables();
  		$data = array();
  		$no = $_POST['start'];
      if($this->session->userdata("user_type") == "sa"){
      $superadmin = '<a data-target="#hapusmodal" data-toggle="modal" class="trash">
      <button class="btn btn-danger  btn-sm"><i class="fas fa-trash fa-sm"></i>
      </button></a></center>';}
      else {$superadmin = '</center>';}

  		foreach ($list as $pekerja) {
  			$no++;
  			$row = array();
        $row[] = '<i class="fas fa-plus-circle"></i>';
        $row[] = $no;
  			$row[] = $pekerja->client_name;
  			$row[] = $pekerja->client_city;
  			$row[] = $pekerja->client_pic;
  			$row[] = $pekerja->client_phone;
        $row[] = $pekerja->client_id;
        $row[] = '<center><a href="'.base_url().'crud_client/edit/'. $pekerja->client_id.'"><button  class="btn btn-primary  btn-sm">
        <i class="fas fa-edit fa-sm"></i></button></a>'.$superadmin;
        $row[] = $pekerja->client_address;
        $row[] = $pekerja->email_client;
        $row[] = $pekerja->npwp;
        $row[] = $pekerja->bank;
        $row[] = $pekerja->rek;

  			$data[] = $row;
  		}

  		$output = array(
  						"draw" => $_POST['draw'],
  						"recordsTotal" => $this->m_client->count_all(),
  						"recordsFiltered" => $this->m_client->count_filtered(),
  						"data" => $data,
  				);
  		//output to json format
  		echo json_encode($output);
  	}

    function edit($id_client){
    $where = array('client_id' => $id_client);
    $data['client'] = $this->m_client->edit_data($where,'client')->result();
    $this->load->view('v_header');
    $this->load->view('v_sidebar');
    $this->load->view('v_client_edit',$data);
    $this->load->view('v_footer');
    }

    public function update_client()
    {

      $data = array ('success' => false, 'messages' => array());
      $this->load->library('form_validation');
      $this->form_validation->set_rules('client_name2', 'Client_name2', 'trim|required');
      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

      if($this->form_validation->run()) {
          $data = array (
              'client_name' => $this->input->post('client_name2'),
              'client_address' => $this->input->post('address'),
              'client_city' => $this->input->post('city'),
              'client_pic' => $this->input->post('client_pic'),
              'client_phone' => $this->input->post('phone'),
              'email_client' => $this->input->post('email'),
              'npwp' => $this->input->post('npwp'),
              'bank' => $this->input->post('bank'),
              'rek' => $this->input->post('rek'),
                   );
          $where = array ('client_id' => $this->input->post('client_id'));
          $this->m_client->update_data($where,$data,'client');
          $data['success'] = true;
          } else {
               foreach ($_POST as $key => $value) {
                    $data['messages'][$key] = form_error($key);
                     }
                  }
               echo json_encode($data);
     }


}
