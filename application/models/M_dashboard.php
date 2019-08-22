<?php
class M_dashboard extends CI_Model{

	function show_project_bar(){
    $this->db->select('project_name,project_code,value,project_start,project_end');
		$this->db->order_by('project_end', 'DESC');
		$this->db->limit(4);
    return $this->db->get('project');
	}

  function show_expense_bar($project){
    $this->db->select_sum('expense_value');
		$this->db->where('project_code_fk='.$project);
    return $this->db->get('expense');
	}

  function show_absent_bar($project){
    $this->db->select('calendar_events.start,calendar_events.end,calendar_events.user_name_fk,user.id_rate,rate.rate');
    $this->db->join('user','user.user_name=calendar_events.user_name_fk','left');
    $this->db->join('rate','rate.id_rate=user.id_rate','left');
		$this->db->where('calendar_events.project_code_fk='."$project");
    return $this->db->get('calendar_events');
  }

	function show_payment_bar($project){
    $this->db->select_sum('payment_value');
		$this->db->where('project_code_fk='.$project);
    return $this->db->get('payment');
	}

	function get_data($type)
	{

    $query = $this->db->get_where('information','type="'.$type.'"');
		return $query->result();
	}

	function cek_data($where)
	{
	$this->db->select('user_name_fk');
	$this->db->where('type_expense ='.$where);
	$this->db->limit(1);
	return $this->db->get('expense');
	}

	function hapus_data($where,$table){
	$this->db->where($where);
	$this->db->delete($table);
	}

	function insert_all($table,$data) {
		$query = $this->db->insert($table,$data);
	}

	function insert_pass($table,$data) {
		 $query2 = $this->db->get_where($table,'type="password"');
			if($query2->num_rows()==1)
			{
				$query = $this->db->where('type="password"')->update($table, $data);

			}else{
		 $query = $this->db->insert($table,$data);
	 	}
	}

}
?>
