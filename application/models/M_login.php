<?php

class M_login extends CI_Model{
	function cek_login($table,$where){
		return $this->db->get_where($table,$where);
	}

	function update_password($where,$data,$table){
	$this->db->where($where);
	$this->db->update($table,$data);
	}
}
