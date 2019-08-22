<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_absent extends CI_Controller {

  function __construct()
	{
      parent::__construct();
      $this->load->model('m_absent', '', TRUE);
      $this->load->model('m_project', '', TRUE);
      $this->load->helper(array('form', 'url'));
  }

  public function index()
	{
    $x['datas']=$this->m_absent->get_information()->result();
    $this->load->view('v_header');

    $this->load->view('v_absent',$x);
    $this->load->view('v_footer');
	}

  public function get_events()
 {
     // Our Start and End Dates
     $start = $this->input->get("start");
     $end = $this->input->get("end");

     $startdt = new DateTime('now'); // setup a local datetime
     $startdt->setTimestamp($start); // Set the date based on timestamp
     $start_format = $startdt->format('Y-m-d H:i:s');

     $enddt = new DateTime('now'); // setup a local datetime
     $enddt->setTimestamp($end); // Set the date based on timestamp
     $end_format = $enddt->format('Y-m-d H:i:s');
     $where = $this->session->userdata("id_user");

     $events = $this->m_absent->get_events($start_format, $end_format, $where);

     $data_events = array();

     foreach($events->result() as $r) {
       if ($r->project_code_fk=="absent")
       {
         $sambung = "absent-".$r->description;
         $endd = substr($r->end,0,10);
         $startt = substr($r->start,0,10);
         $data_events[] = array(
               "id" => $r->ID,
               "title" => $sambung,
               "description" => $r->description,
               "end" => $endd,
               "start" => $startt,
               "name" => "absent",

               "project_code" => "absent",
               "datestart" => $r->start,
               "dateend" => $r->end,
               "color"=> "red"

           );

       }
       else {
         $timesub = substr($r->start,11,2);
         $endtimesub = substr($r->end,11,2);
         $sambung = $timesub.'-'.$endtimesub.' '.$r->project_name;
         $endd = substr($r->end,0,10);
         $startt = substr($r->start,0,10);
         $data_events[] = array(
               "id" => $r->ID,
               "title" => $sambung,
               "description" => $r->description,
               "end" => $endd,
               "start" => $startt,
               "name" => $r->project_name,

               "project_code" => $r->project_code_fk,
               "datestart" => $r->start,
               "dateend" => $r->end,
               "color"=> $r->color

           );

       }

     }

     echo json_encode(array("events" => $data_events));
     exit();
 }

 public function add_event()
    {
      $absent = intval($this->input->post("checkbox"));
      $start_date = $this->input->post("start_date", TRUE);
      $end_date = $this->input->post("end_date", TRUE);
      $data = array ('success' => false, 'messages' => array(), 'absent' => false);

      $this->load->library('form_validation');

      if(!$absent) {

        $start_time = $this->input->post("start_time", TRUE);
        $end_time = $this->input->post("end_time", TRUE);
        $time_start = $start_date.' '.$start_time;
        $time_end = $end_date.' '.$end_time;

          $this->form_validation->set_rules('end_date', 'End_date', 'trim|required|callback_start_date_check');
          $this->form_validation->set_rules('project_name_code', 'Project_name_code', 'trim|required|callback_project_check');
      }
      else {

        $time_start = $start_date.' 00:00:00';

        $tambahhari = date('Y-m-d', strtotime('+1 days', strtotime($end_date)));
        $time_end = $tambahhari.' 00:00:00';

        $reason = $this->input->post("reason", TRUE);
        $this->form_validation->set_rules('checkbox', 'Checkbox', 'trim|required');
        $this->form_validation->set_rules('reason', 'Reason', 'trim|required');
        if ($reason == "other")
        {
          $this->form_validation->set_rules('other', 'Other', 'trim|required');
        }
      }
      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

      if($this->form_validation->run()) {

        /* Our calendar data */
        if(!$absent) {
        $name = $this->input->post("project_name_code", TRUE);
        $desc = $this->input->post("description", TRUE);



        $date_start_bantu = new DateTime($start_time);
        $date_end_bantu = new DateTime($end_time);
        $pengurangan = $date_end_bantu->diff($date_start_bantu)->format("%h");
      }
      else
      {
        $name = "absent";
        $desc = $this->input->post("reason", TRUE);
        if ($desc == "other")
        {
          $desc = $this->input->post("other", TRUE);
        }
        $pengurangan = "0";
        $data['absent'] = true;
      }
      $user_name_fk = $this->session->userdata("id_user");

        $this->m_absent->add_event(array(
           "project_code_fk" => $name,
           "description" => $desc,
           "start" => $time_start,
           "end" => $time_end,
           "user_name_fk" => $user_name_fk,
           "sisa" =>$pengurangan,

           )
        );
        $data['success'] = true;
        }else {
			       foreach ($_POST as $key => $value) {
			 	          $data['messages'][$key] = form_error($key);
			             }
		            }

        echo json_encode($data);

        //
    }

    public function start_date_check($start_date)
    {
        $user = $this->session->userdata("id_user");
        $start_time = $this->input->post("start_time", TRUE);
        $where = array ('user_name_fk'=>$user,'date(`start`)'=>$start_date, 'time(`end`) >'=>$start_time);
        $check = $this->m_absent->check_all('calendar_events',$where,1);
              if ($check)
              {

                      $this->form_validation->set_message('start_date_check', 'Time has created');
                      return FALSE;
              }
              else
              {
                      return TRUE;
              }
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

    public function edit_event()
       {
         $data = array ('success' => false, 'messages' => array(), 'absent' => false);
            $eventid = intval($this->input->post("eventid"));
            $event = $this->m_absent->get_event($eventid);
            if($event->num_rows() == 0) {
                 echo"Invalid Event";
                 exit();
            }

            $event->row();

            /* Our calendar data */
            $code = $this->input->post("project_name_code", TRUE);
            $desc = $this->input->post("description", TRUE);
            $start_date = $this->input->post("start_date", TRUE);
            $start_time = $this->input->post("start_time", TRUE);
            $end_date = $this->input->post("end_date", TRUE);
            $end_time = $this->input->post("end_time", TRUE);
            $delete = intval($this->input->post("delete"));

            $date_start_bantu = new DateTime($start_time);
            $date_end_bantu = new DateTime($end_time);
            $pengurangan = $date_end_bantu->diff($date_start_bantu)->format("%h");

            if(!$delete) {

                 if(!empty($start_date)) {
                      $time_start = $start_date.' '.$start_time;

                 }
                 if(!empty($end_date)) {
                    $time_end = $end_date.' '.$end_time;
                 }

                 $this->m_absent->update_event($eventid, array(
                      "project_code_fk" => $code,
                      "description" => $desc,
                      "start" => $time_start,
                      "end" => $time_end,
                      "sisa" =>$pengurangan,
                      )
                 );

            } else {
                 $this->m_absent->delete_event($eventid);
                 $data['success'] = true;

            }

            echo json_encode($data);
       }
}
