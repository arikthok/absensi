<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class M_absent extends CI_Model
{

      public function get_events($start, $end, $where)
    {
        $this->db->join('project','calendar_events.project_code_fk=project.project_code','left');
        return $this->db->where("start >=", $start)->where("end <=", $end)->where("user_name_fk=", $where)->get("calendar_events");

    }

    public function add_event($data)
    {
        $this->db->insert("calendar_events", $data);
    }

    public function get_event($id)
    {
        return $this->db->where("ID", $id)->get("calendar_events");
    }

    public function update_event($id, $data)
    {
        $this->db->where("ID", $id)->update("calendar_events", $data);
    }

    public function delete_event($id)
    {
        $this->db->where("ID", $id)->delete("calendar_events");
    }

    function check_all($table,$where,$limit) {
      $query = $this->db->get_where($table,$where,$limit);
        if($query->num_rows()==1)
        {
          return $query->result();
        }
        else {
          return false;
        }
    }

    function get_information(){
          $hasil=$this->db->query("SELECT * FROM information where type='absent'");
          return $hasil;
      }

}
?>
