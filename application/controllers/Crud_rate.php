<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_rate extends CI_Controller {

  function __construct()
	{
 parent::__construct();
  $this->load->model('m_rate', '', TRUE);
  $this->load->helper(array('form', 'url'));

	}
  public function index()
  {
    $this->load->view('v_header');
    $this->load->view('v_sidebar');
    $this->load->view('v_rate');
    $this->load->view('v_footer');
  }

  public function ajax_list()
  {

    $list = $this->m_rate->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $pekerja) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $pekerja->id_rate;
      $row[] = $pekerja->position;
      $row[] = number_format($pekerja->rate,0,".",".");
      $row[] = '<center><a href="'.base_url().'crud_rate/edit/'. $pekerja->id_rate.'"><button  class="btn btn-primary  btn-sm">
      <i class="fas fa-edit fa-sm"></i></button></a>
      <a data-target="#hapusmodal" data-toggle="modal" class="trash">
      <button class="btn btn-danger  btn-sm"><i class="fas fa-trash fa-sm"></i>
      </button></a>
      </center>';

      $data[] = $row;
    }

    $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->m_rate->count_all(),
            "recordsFiltered" => $this->m_rate->count_filtered(),
            "data" => $data,
        );
    //output to json format
    echo json_encode($output);
  }

  public function data()
  {

		$data = array ('success' => false, 'messages' => array());
		$this->load->library('form_validation');
		$this->form_validation->set_rules('position', 'Position', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');


		if($this->form_validation->run()) {
				$data = array (
					  'position' => $this->input->post('position'),
					  'rate' => str_replace(".", "",$this->input->post('rate'))
					       );
				$this->m_rate->insert_all('rate',$data);
        $data['success'] = true;

		    } else {
			       foreach ($_POST as $key => $value) {
			 	          $data['messages'][$key] = form_error($key);
			             }
		            }
		         echo json_encode($data);
	 }

   function edit($id_client){
   $where = array('id_rate' => $id_client);
   $data['rate'] = $this->m_rate->edit_data($where,'rate')->result();
   $this->load->view('v_header');
   $this->load->view('v_sidebar');
   $this->load->view('v_rate_edit',$data);
   $this->load->view('v_footer');
   }

   public function update()
   {

     $data = array ('success' => false, 'messages' => array());
 		$this->load->library('form_validation');
 		$this->form_validation->set_rules('position', 'Position', 'trim|required');
 		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');


 		if($this->form_validation->run()) {
 				$data = array (
 					  'position' => $this->input->post('position'),
 					  'rate' => str_replace(".", "",$this->input->post('rate'))
 					       );
        $where = array(
          'id_rate' => $this->input->post('id_rate'));
 				$this->m_rate->update('rate',$data, $where);
         $data['success'] = true;
 		    } else {
 			       foreach ($_POST as $key => $value) {
 			 	          $data['messages'][$key] = form_error($key);
 			             }
 		            }
 		         echo json_encode($data);
      }

      function hapus(){
        $data = array ('success' => false, 'ket' => false);
        $id_pekerja=$this->input->post('id_pekerja');
        $cek = $this->m_rate->cek_data($id_pekerja);
        if($cek->num_rows() == 0) {
          $where = array('id_rate' => $id_pekerja);
          $this->m_rate->hapus_data($where,'rate');
          $data['success'] = true;
          $data['ket'] = true;
        }
        echo json_encode($data);
      }
}
