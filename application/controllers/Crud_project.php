<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_project extends CI_Controller {

  function __construct()
	{
 parent::__construct();
 $this->load->model('m_user', '', TRUE);
 $this->load->model('m_project', '', TRUE);
 $this->load->model('m_client', '', TRUE);
  $this->load->helper(array('form', 'url'));

	}

  public function index()
	{
    $this->load->view('v_header');
    $this->load->view('v_sidebar');
    $this->load->view('v_project');
    $this->load->view('v_footer');
	}

  function list_project(){
  $this->load->view('v_header');
  $this->load->view('v_sidebar');
  $this->load->view('v_project_data');
  $this->load->view('v_footer');
  }


  public function data()
    {
    $colors = ['#FF4500','#8A2BE2','#7FFF00','#FF7F50','#6495ED','#DC143C','#800080','#9400D3','#228B22','#FF6347'];
    $getcolor = $this->m_project->get_color();
    $hitungcolor = $getcolor->hitung;


    $data = array ('success' => false, 'messages' => array());

		$this->load->library('form_validation');
		$this->form_validation->set_rules('code', 'Code', 'trim|required|numeric|min_length[5]|max_length[5]|callback_code_check');
    $this->form_validation->set_rules('code2', 'Code', 'trim|required|numeric|min_length[2]|max_length[2]');
    $this->form_validation->set_rules('client_name', 'Client_name', 'trim|required|callback_client_check');
    $this->form_validation->set_rules('pic', 'Client_name', 'trim|required|callback_pic_check');
		//$this->form_validation->set_rules('nama_pekerja', 'Nama_pekerja', 'trim|required|min_length[5]|max_length[12]|callback_namadata_check');
		//$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pekerja.email]');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');


		if($this->form_validation->run()) {
      $code = $this->input->post('code').$this->input->post('code2');
				$data = array (
					  'project_code' => $code,
					  'project_name' => $this->input->post('name'),
					  'project_type' => $this->input->post('type'),
          	'location' => $this->input->post('location'),
            'value' => str_replace(".", "",$this->input->post('value')),
            'pic' => $this->input->post('pic'),
            'project_start' => $this->input->post('start'),
            'project_end' => $this->input->post('end'),
            'client_id_fk' => $this->input->post('client'),
            'color' => $colors[$hitungcolor]

					       );

        if($hitungcolor<9)
        {$hitungcolor++;} else {$hitungcolor=0;}
        $updatecolor = array('hitung' => $hitungcolor);
        $this->m_project->update_color( $updatecolor,'count');

        $this->m_project->insert_all('project',$data);
        $data['success'] = true;

		    } else {
			       foreach ($_POST as $key => $value) {
			 	          $data['messages'][$key] = form_error($key);
			             }
		            }
		         echo json_encode($data);
	    }

      public function client_check($nim)
      {
        	$where = array ('client_name'=>$nim);
			    $check = $this->m_client->check_all('client',$where,1);
                if (!$check)
                {
                        $this->form_validation->set_message('client_check', 'Client not registered');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }

      public function code_check($nim)
      {
        $code = $this->input->post('code').$this->input->post('code2');

        	$where = array ('project_code'=>$code);
			    $check = $this->m_project->check_all('project',$where,1);
                if ($check)
                {
                        $this->form_validation->set_message('code_check', 'Project {field} already exists');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }

        public function pic_check($nim)
        {
          	$where = array ('full_name'=>$nim);
  			    $check = $this->m_user->check_all('user',$where,1);
                  if (!$check)
                  {
                          $this->form_validation->set_message('pic_check', 'PIC not registered');
                          return FALSE;
                  }
                  else
                  {
                          return TRUE;
                  }
          }



  function get_autocomplete(){
		if (isset($_GET['term'])) {
		  	$result = $this->m_project->search_blog($_GET['term']);
		   	if (count($result) > 0) {
		    foreach ($result as $row)
		     	$arr_result[] = array(
					'label'			=> $row->client_name,
					'description'	=> $row->client_id,
				);
		     	echo json_encode($arr_result);
		   	}
		}
	}

  function get_autocomplete2(){
		if (isset($_GET['term'])) {
		  	$result = $this->m_user->search_blog($_GET['term']);
		   	if (count($result) > 0) {
		    foreach ($result as $row)
		     	$arr_result[] = array(
					'label'			=> $row->full_name,
          'description'	=> $row->user_name,
				);
		     	echo json_encode($arr_result);
		   	}
		}
	}


    public function data_client()
    {

      $data = array ('success' => false, 'messages' => array());
      $this->load->library('form_validation');
      $this->form_validation->set_rules('client_name2', 'Client_name2', 'trim|required|callback_name_check');
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
          $this->m_client->insert_all('client',$data);
          $data['success'] = true;
          } else {
               foreach ($_POST as $key => $value) {
                    $data['messages'][$key] = form_error($key);
                     }
                  }
               echo json_encode($data);
     }
     public function name_check($nim)
      {
         $where = array ('client_name'=>$nim);
         $check = $this->m_client->check_all('client',$where,1);
               if ($check)
               {
                       $this->form_validation->set_message('name_check', 'Client {field} already exists');
                       return FALSE;
               }
               else
               {
                       return TRUE;
               }
      }


  public function ajax_list()
	{
    	$this->load->model('m_project','project');
		$list = $this->m_project->get_datatables();
		$data = array();
		$no = $_POST['start'];
    if($this->session->userdata("user_type") == "sa"){
    $superadmin = '<a data-target="#hapusmodal" data-toggle="modal" class="trash">
    <button class="btn btn-danger  btn-sm"><i class="fas fa-trash fa-sm"></i>
    </button></a></center>';}
    else {$superadmin = '</center>';}
		foreach ($list as $pekerja) {
      $code = $pekerja->project_code;
      $string1 = substr($code, 0, 5);
      $string2 = substr($code, 5, 6);
      $string = $string1."-".$string2."-".strtoupper($pekerja->project_type)."-".ucfirst($pekerja->project_name);

			$row = array();
      $row[] = '<i class="fas fa-plus-circle"></i>';
			$row[] = $string;
    	$row[] = $pekerja->location;
      $row[] = number_format($pekerja->value,0,".",".");

			$row[] = $pekerja->project_start;
      $row[] = $pekerja->project_end;
      $row[] = '<center><a href="'.base_url().'crud_project/edit/'. $pekerja->project_code.'">
      <button  class="btn btn-primary  btn-sm">
      <i class="fas fa-edit fa-sm"></i></button></a>'. $superadmin;
      $row[] = $pekerja->pic;
      $row[] = $pekerja->client_name;
      $row[] = $pekerja->client_address;
      $row[] = $pekerja->client_phone;
      $row[] = $pekerja->email_client;
      $row[] = $pekerja->npwp;
      $row[] = $pekerja->bank;
      $row[] = $pekerja->rek;
      $row[] = $pekerja->project_code;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_project->count_all(),
						"recordsFiltered" => $this->m_project->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

  function hapus(){
    $id_pekerja=$this->input->post('id_pekerja');
		$where = array('project_code' => $id_pekerja);
		$this->m_project->hapus_data($where,'project');
		redirect('crud_project/list_project');
	}

  function edit($project_code){
  $where = array('project_code' => $project_code);
  $data['project'] = $this->m_project->edit_data($where,'project')->result();
  $this->load->view('v_header');
  $this->load->view('v_sidebar');
  $this->load->view('v_project_edit',$data);
  $this->load->view('v_footer');
  }

  public function update()
    {

		$data = array ('success' => false, 'messages' => array());

		$this->load->library('form_validation');
		//$this->form_validation->set_rules('code', 'Code', 'trim|required|numeric|min_length[5]|max_length[6]|callback_code_check');
    $this->form_validation->set_rules('client_name', 'Client_name', 'trim|required|callback_client_check');
    $this->form_validation->set_rules('pic', 'Client_name', 'trim|required|callback_pic_check');
		//$this->form_validation->set_rules('nama_pekerja', 'Nama_pekerja', 'trim|required|min_length[5]|max_length[12]|callback_namadata_check');
		//$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pekerja.email]');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');


		if($this->form_validation->run()) {
				$data = array (
					  'project_name' => $this->input->post('name'),
					  'project_type' => $this->input->post('type'),
          	'location' => $this->input->post('location'),
            'value' => str_replace(".", "",$this->input->post('value')),
            'pic' => $this->input->post('pic'),
            'project_start' => $this->input->post('start'),
            'project_end' => $this->input->post('end'),
            'client_id_fk' => $this->input->post('client'),
					   );
        $where = array ('project_code' => $this->input->post('code'));
				$this->m_project->update_data($where,$data,'project');
        $data['success'] = true;
		    } else {
			       foreach ($_POST as $key => $value) {
			 	          $data['messages'][$key] = form_error($key);
			             }
		            }
		         echo json_encode($data);
	    }


}
