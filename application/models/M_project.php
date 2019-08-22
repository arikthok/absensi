<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class M_project extends CI_Model
{
	  	var $table = "project";
      var $column_order = array(NULL, "project_code", "location", "value", "project_start","project_end",NULL);
      var $column_search = array( "project_name", "project_code","project_type", "location", "value","pic", "project_start","project_end");
			var $order = array('project_name' => 'asc'); // default order

				public function __construct()
				{
					parent::__construct();
					$this->load->database();
				}

		function insert_all($table,$data) {
				$this->db->insert($table,$data);
		}

		function search_blog($title){
		$this->db->like('client_name', $title , 'both');
		$this->db->order_by('client_name', 'ASC');
		$this->db->limit(5);
		return $this->db->get('client')->result();
		}

		function get_color(){
			$query = $this->db->get('count');
		return $query->row();
		}

		function update_color($data,$table){

		$this->db->update($table,$data);
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

		private function _get_datatables_query()
		{

			$this->db->from($this->table);
			$this->db->join('client','project.client_id_fk = client.client_id','left');

			$i = 0;

			foreach ($this->column_search as $item) // loop column
			{
				if($_POST['search']['value']) // if datatable send POST for search
				{

					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, $_POST['search']['value']);
					}
					else
					{
						$this->db->or_like($item, $_POST['search']['value']);
					}

					if(count($this->column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}

			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			}
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}

		function get_datatables()
		{
			$this->_get_datatables_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}

		function count_filtered()
		{
			$this->_get_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}

		public function count_all()
		{
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}

		function hapus_data($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
		}

		function edit_data($where,$table){
		$this->db->join('client','project.client_id_fk=client.client_id','left');
			return $this->db->get_where($table,$where);
  	}

		function update_data($where,$data,$table){
		$this->db->where($where);
		$this->db->update($table,$data);
	}


	}

?>
