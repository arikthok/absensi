<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class M_payment extends CI_Model
{
  var $table = "payment";
  var $column_order = array(NULL, NULL,"project_code_fk", "value", "payment_value");
  var $column_search = array("project_code_fk" ,"project_name");
  var $order = array('date' => 'DESC'); // default order

  function insert_all($table,$data) {
  $this->db->insert($table,$data);
  }

  private function _get_datatables_query()
  {

    $this->db->select('payment.*,
    GROUP_CONCAT(`id_payment`) as `id`,
    GROUP_CONCAT(`payment_value`) as `payment`,
    GROUP_CONCAT(`date`) as `date`,
    project.value as value,project.project_name , project.project_type');
    $this->db->select('SUM(payment.payment_value) as payment_value');
    $this->db->group_by('project_code_fk');
    $this->db->from($this->table);
    $this->db->join('project','project.project_code=payment.project_code_fk');
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

  function get_max($where){
  $this->db->select("max(payment) as pay");
  $this->db->where($where);
  $query = $this->db->get("payment");
  return $query->result();

  }

}
?>
