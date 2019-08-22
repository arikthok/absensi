<?php
class M_rate extends CI_Model{

 function get_rate(){
       $hasil=$this->db->query("SELECT * FROM rate");
       return $hasil;
   }

   var $table = "rate";
   var $column_order = array("position", "rate");
   var $column_search = array( "position", "rate");

  function insert_all($table,$data) {
     $this->db->insert($table,$data);
  }

  private function _get_datatables_query()
 	{
 			$this->db->from($this->table);
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

    function edit_data($where,$table){
      return $this->db->get_where($table,$where);
    }

    function update($table,$data,$where){
    $this->db->where($where);
    $this->db->update($table,$data);
    }

    function hapus_data($where,$table){
    $this->db->where($where);
    $this->db->delete($table);
    }

    function cek_data($where){
    $this->db->select('user_name,id_rate');
    $this->db->where('id_rate ='.$where);
    $this->db->limit(1);
    return $this->db->get('user');

    }
 }
