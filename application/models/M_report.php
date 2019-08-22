<?php
class M_report extends CI_Model{

  function detail_data($table,$where){
      $this->db->join('client','project.client_id_fk=client.client_id','left');
		  return $this->db->get_where($table,$where);
    }

  function detail_payment($table,$where){
  		  return $this->db->get_where($table,$where);
      }

  function detail_absent($table,$where){
        $this->db->select('*');
        $this->db->select('SUM(calendar_events.sisa) AS total',FALSE);
        $this->db->group_by('user_name_fk');
        $this->db->join('user','user.user_name=calendar_events.user_name_fk','left');
        $this->db->join('rate','rate.id_rate=user.id_rate','left');
    		return $this->db->get_where($table,$where);

      }
  function detail_expense($table,$where){
        $this->db->select('*');
        $this->db->select('SUM(expense.expense_value) AS total_expense',FALSE);
        $this->db->group_by('type_expense');
        $this->db->join('information','information.information_id=expense.type_expense','left');
        return $this->db->get_where($table,$where);
      }

}
