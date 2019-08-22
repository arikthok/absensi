<?php

class Admin extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('m_dashboard', '', TRUE);
		$this->load->helper(array('form', 'url'));

		if($this->session->userdata('status') != "login"){
			redirect(base_url("login"));
		}
	}

	function index(){


		$this->load->view('v_header');
		$this->load->view('v_sidebar');
		$this->load->view('v_dashboard');
		$this->load->view('v_footer');

	}



	function charts(){
		$this->load->view('v_charts');
	}

	function ajax_list()
	{
		$list = $this->m_dashboard->show_project_bar()->result();

		$data2= array();
		$data3= array();
		$data4= array();
		foreach ($list as $pekerja) {
			$row = array();
			$project = $pekerja->project_code;
			$value = $pekerja->value;
			$row = $pekerja->project_name;
			$data[] = $row;
			//menghitung sisa hari
			$project_start = new DateTime($pekerja->project_start);
			$project_end = new DateTime($pekerja->project_end);
			$tgl= new DateTime('now');
			$jangkawaktu = $project_end->diff($project_start)->format("%a");
			$sisawaktu = $tgl->diff($project_end)->format("%r%a");
			$persensisa=$sisawaktu/$jangkawaktu*100;
			if($sisawaktu<0){$persensisa=0;}
			$kurangsisa=100-$persensisa;

			$data4[]=round($kurangsisa,2);

			//cek jumlah expense
				$jumlah_value=$this->m_dashboard->show_expense_bar($project)->result();
				if($jumlah_value != NULL){
				foreach ($jumlah_value as $pekerja2) {

					$row2 = $pekerja2->expense_value;
					$persen=$row2/$value*100;
					$expensebar[] = round($persen,2);
				}
				}
				else {$expensebar[]=0;}


				//cek tgl
					$bantu = 0;
					$tgl_value=$this->m_dashboard->show_absent_bar($project)->result();
					if($tgl_value!=NULL){
						foreach ($tgl_value as $pekerja3) {
							$rate = $pekerja3->rate;
							$date_start = new DateTime($pekerja3->start);
							$date_end = new DateTime($pekerja3->end);
							$pengurangan = $date_end->diff($date_start)->format("%h");
							$kali = $pengurangan * $rate;
							$tambah = $kali + $bantu;
							$persen2=$tambah/$value*100;
							$bantu = $tambah;

						}	$manhourbar[]=round($persen2,2);
					} else {$manhourbar[]=0;}

				//cek jumlah payment
						$payment_value=$this->m_dashboard->show_payment_bar($project)->result();
						if($payment_value != NULL)
						{
							foreach ($payment_value as $pekerja3) {
							$payment = $pekerja3->payment_value;
							$persenpayment=$payment/$value*100;
							$paymentbar[] = round($persenpayment,2);
							}
						}else {$paymentbar[]=0;}






		}

		$jumlah= array();
		for($i=0; $i < count($expensebar); $i++){

      $jumlah[]=round($expensebar[$i],2)+round($manhourbar[$i],2);
		}


		$output = array(
									"project" => $data,
									"sisawaktu"=>$data4,
									"total"=>$jumlah,
									"espense" => $expensebar,
									"manhour" => $manhourbar,
									"payment"=>$paymentbar
								);
		//output to json format
		echo json_encode($output);

	}

	function setting(){

		$x['datas'] = $this->m_dashboard->get_data("password");

		$this->load->view('v_header');
		$this->load->view('v_sidebar');
		$this->load->view('v_setting',$x);
		$this->load->view('v_footer');

	}

	public function data_list()
  {
		$type = $this->uri->segment('3');
    $list = $this->m_dashboard->get_data($type);
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $pekerja) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $pekerja->information_id;
      $row[] = $pekerja->information_name;
      $row[] = '<center>
      <a data-target="#hapusmodal" data-toggle="modal" class="'.$type.'">
      <button class="btn btn-danger data="'.$pekerja->information_id.'" btn-sm"><i class="fas fa-trash fa-sm"></i>
      </button></a>
      </center>';

      $data[] = $row;
    }

    $output = array(

            "data" => $data,
        );
    //output to json format
    echo json_encode($output);
  }

	function hapus(){
		$data = array ('success' => false, 'ket' => false);
		$id_pekerja=$this->input->post('id_pekerja');
		$cek = $this->m_dashboard->cek_data($id_pekerja);
		if($cek->num_rows() == 0) {
			$where = array('information_id' => $id_pekerja);
			$this->m_dashboard->hapus_data($where,'information');
			$data['success'] = true;
			$data['ket'] = true;
		}
		echo json_encode($data);
	}

	public function tambah()
	{

		$data = array ('success' => false, 'messages' => array());
		$this->load->library('form_validation');
		$this->form_validation->set_rules('input_data', 'Input_data', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if($this->form_validation->run()) {
				$data = array (
						'information_name' => $this->input->post('input_data'),
						'type' => $this->input->post('type')
								 );
				$this->m_dashboard->insert_all('information',$data);
				$data['success'] = true;

				} else {
						 foreach ($_POST as $key => $value) {
									$data['messages'][$key] = form_error($key);
									 }
								}
						 echo json_encode($data);
	 }

	 public function default_pass()
	 {

		 $data = array ('success' => false, 'messages' => array());
		 $this->load->library('form_validation');
		 $this->form_validation->set_rules('default', 'Default', 'trim|required');
		 $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		 if($this->form_validation->run()) {

						 $data = array (
								 'information_name' => $this->input->post('default'),
								 'type' =>'password'
											);
						 $this->m_dashboard->insert_pass('information',$data);
						 $data['success'] = true;



				 } else {
							foreach ($_POST as $key => $value) {
									 $data['messages'][$key] = form_error($key);
										}
								 }
							echo json_encode($data);
		}
}
