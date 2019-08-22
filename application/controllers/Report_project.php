<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_project extends CI_Controller {

  function __construct()
	{
    parent::__construct();
    $this->load->model('m_project', '', TRUE);
    $this->load->helper(array('form', 'url'));

	}

  public function index()
	{

    $this->load->view('v_header');
    $this->load->view('v_sidebar');
    $this->load->view('v_report_project');
    $this->load->view('v_footer');
	}
  function detail($project_code){
    $this->load->model('m_report', '', TRUE);
      $where = array('project_code' => $project_code);
      $where2 = array('project_code_fk' => $project_code);
      $data['project'] = $this->m_report->detail_data('project',$where)->result();
      $data['payment'] = $this->m_report->detail_payment('payment',$where2)->result();
      $data['absent'] = $this->m_report->detail_absent('calendar_events',$where2)->result();
      $data['expense'] = $this->m_report->detail_expense('expense',$where2)->result();
  $this->load->view('v_report_project_detail',$data);

  }

  public function ajax_list()
	{
    	$this->load->model('m_project','project');
		$list = $this->m_project->get_datatables();
		$data = array();
		$no = $_POST['start'];
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
      $row[] = '<center><a href="'.base_url().'report_project/detail/'. $pekerja->project_code.'" target="_blank"><button  class="btn btn-primary  btn-sm">
      <i class="fas fa-print fa-sm"></i></button></a></center>';
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
}
