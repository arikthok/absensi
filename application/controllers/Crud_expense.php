<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_expense extends CI_Controller {

  function __construct()
	{
      parent::__construct();
      $this->load->model('m_expense', '', TRUE);
      $this->load->model('m_project', '', TRUE);
      $this->load->model('m_user', '', TRUE);
      $this->load->helper(array('form', 'url'));
  }

  public function index()
	{
    $x['datas']=$this->m_expense->get_information();
    $this->load->view('v_header');
    $this->load->view('v_sidebar');
    $this->load->view('v_expense',$x);
    $this->load->view('v_footer');
	}

  public function data()
    {

    $data = array ('success' => false, 'messages' => array());

    $this->load->library('form_validation');
    $this->form_validation->set_rules('notes', 'Notes', 'required|min_length[5]');
    $this->form_validation->set_rules('project_name_code', 'project_name', 'trim|required|callback_project_check');
    $this->form_validation->set_rules('full_name_code', 'full_name', 'trim|required|callback_pic_check');
    $this->form_validation->set_rules('value', 'Value', 'trim|required|min_length[4]|max_length[15]');
    //$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pekerja.email]');
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');


    if($this->form_validation->run()) {
        $data = array (
            'expense_date' => $this->input->post('date'),
            'expense_value' => str_replace(".", "",$this->input->post('value')),
            'note' => $this->input->post('notes'),
            'project_code_fk' => $this->input->post('project_name_code'),
            'user_name_fk' => $this->input->post('full_name_code'),
            'type_expense' => $this->input->post('type_expense')
         );
        $this->m_expense->insert_all('expense',$data);
        $data['success'] = true;
        } else {
             foreach ($_POST as $key => $value) {
                  $data['messages'][$key] = form_error($key);
                   }
                }
             echo json_encode($data);
      }

      public function project_check($nim)
        {
            $where = array ('project_code'=>$nim);
            $check = $this->m_project->check_all('project',$where,1);
                  if (!$check)
                  {
                          $this->form_validation->set_message('project_check', 'Project not registered');
                          return FALSE;
                  }
                  else
                  {
                          return TRUE;
                  }
          }

          public function pic_check($nim)
          {
              $where = array ('user_name'=>$nim);
              $check = $this->m_user->check_all('user',$where,1);
                    if (!$check)
                    {
                            $this->form_validation->set_message('pic_check', 'Employee not registered');
                            return FALSE;
                    }
                    else
                    {
                            return TRUE;
                    }
            }

      public function ajax_list()
    	{
        	$this->load->model('m_expense','expense');
    		$list = $this->m_expense->get_datatables();
    		$data = array();
    		$no = $_POST['start'];
    		foreach ($list as $pekerja) {
    			$no++;
    			$row = array();
          $row[] = '<i class="fas fa-plus-circle"></i>';
          $code = $pekerja->project_code_fk;
          $string1 = substr($code, 0, 5);
          $string2 = substr($code, 5, 6);
          $string = $string1."-".$string2."-".strtoupper($pekerja->project_type)."-".ucfirst($pekerja->project_name);


    			$row[] = $string;
          $row[] = number_format($pekerja->value,0,".",".");
          $row[] = number_format($pekerja->total,0,".",".");
          //array
          $row[] = $pekerja->full_name;
          $row[] = $pekerja->expense_value;
          $row[] = $pekerja->expense_date;
          $row[] = $pekerja->information_name;
          $row[] = $pekerja->note;
          $row[] = $pekerja->expense_id;
          $row[] = '<center>
          <a data-target="#hapusmodal" data-toggle="modal" class="trash">
          <button class="btn btn-danger  btn-sm"><i class="fas fa-trash fa-sm"></i> </button></a></center>';

    			$data[] = $row;
    		}

    		$output = array(
    						"draw" => $_POST['draw'],
    						"recordsTotal" => $this->m_expense->count_all(),
    						"recordsFiltered" => $this->m_expense->count_filtered(),
    						"data" => $data,
    				);
    		//output to json format
    		echo json_encode($output);
    	}

      function get_autocomplete(){
    		if (isset($_GET['term'])) {
    		  	$result = $this->m_expense->search_blog($_GET['term']);
    		   	if (count($result) > 0) {
    		    foreach ($result as $row){
            $code = $row->project_code;
            $string1 = substr($code, 0, 5);
            $string2 = substr($code, 5, 6);
            $string = $string1."-".$string2."-".strtoupper($row->project_type)."-".ucfirst($row->project_name);
    		     	$arr_result[] = array(
    					'label'			=> $row->project_name,
    					'description'	=> $row->project_code,
              'string_code' => $string

    				);
          }
    		     	echo json_encode($arr_result);
    		   	}
    		}
    	}

      public function hapus()
      {  $id_pekerja=$this->input->post('id_pekerja');
        $where = array('expense_id' => $id_pekerja);
        $this->m_expense->hapus_data($where,'expense');
        redirect('crud_expense');
       }

       function edit($expense_id){
       $where = array('expense_id' => $expense_id);
       $data['expense'] = $this->m_expense->edit_data($where,'expense')->result();
       $this->load->view('v_header');
       $this->load->view('v_sidebar');
       $this->load->view('v_expense_edit',$data);
       $this->load->view('v_footer');
       }
}
