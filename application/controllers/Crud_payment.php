<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_payment extends CI_Controller {

  function __construct()
	{
      parent::__construct();
      $this->load->model('m_payment', '', TRUE);
      $this->load->model('m_project', '', TRUE);
      $this->load->helper(array('form', 'url'));
  }

  public function index()
	{

    $this->load->view('v_header');
    $this->load->view('v_sidebar');
    $this->load->view('v_payment');
    $this->load->view('v_footer');
	}

  public function data()
  {

  $data = array ('success' => false, 'messages' => array());
  $this->load->library('form_validation');

  $this->form_validation->set_rules('project_name_code', 'project_name', 'trim|required|callback_project_check');
//$this->form_validation->set_rules('client_name', 'Client_name', 'trim|required|callback_client_check');
  //$this->form_validation->set_rules('pic', 'Client_name', 'trim|required|callback_pic_check');
  //$this->form_validation->set_rules('nama_pekerja', 'Nama_pekerja', 'trim|required|min_length[5]|max_length[12]|callback_namadata_check');
  //$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[pekerja.email]');
  $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');


  if($this->form_validation->run()) {
      $data = array (
          'payment' => $this->input->post('Payment'),
          'payment_value' => str_replace(".", "",$this->input->post('value')),
          'date' => $this->input->post('date'),
          'project_code_fk' => $this->input->post('project_name_code')
       );
      $this->m_payment->insert_all('payment',$data);
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
    public function ajax_list()
    {
      $this->load->model('m_payment','payment');
      $list = $this->m_payment->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $pekerja) {
        $no++;
        $row = array();
        $row[] = '<i class="fas fa-plus-circle"></i>';
        $row[] = $no;
        $code = $pekerja->project_code_fk;
        $string1 = substr($code, 0, 5);
        $string2 = substr($code, 5, 6);
        $string = $string1."-".$string2."-".strtoupper($pekerja->project_type)."-".ucfirst($pekerja->project_name);


        $row[] = $string;
        $row[] = number_format($pekerja->value,0,".",".");
        $row[] = number_format($pekerja->payment_value,0,".",".");
        $row[] = $pekerja->id;
        $row[] = $pekerja->payment;
        $row[] = $pekerja->date;
        $row[] = '<center>
        <a data-target="#hapusmodal" data-toggle="modal" class="trash">
        <button class="btn btn-danger  btn-sm"><i class="fas fa-trash fa-sm"></i> </button></a></center>';

        $data[] = $row;

      }

      $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->m_payment->count_all(),
              "recordsFiltered" => $this->m_payment->count_filtered(),
              "data" => $data,
          );
      //output to json format
      echo json_encode($output);
    }

    public function hapus()
    {  $id_pekerja=$this->input->post('id_pekerja');
      $where = array('id_payment' => $id_pekerja);
      $this->m_payment->hapus_data($where,'payment');
      redirect('crud_payment');
     }

     public function cek_max() {
        $data = array ('success' => false, 'messages' => array());
        $datax = array(
        'project_code_fk' => $this->input->post('project_code_fk')
        );
        $this->load->model('m_payment','payment');
        $nilaimax = $this->m_payment->get_max($datax);

        foreach ($nilaimax as $pekerja) {

            $row = $pekerja->pay;
            $data = array ('max' => $row);
        }
        $data['success'] = true;
        if ($data['max']==null)
        {$data['max']='0';}
        //Either you can print value or you can send value to database
        echo json_encode($data);
      }

}
