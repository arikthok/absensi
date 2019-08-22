<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class M_expense extends CI_Model
{
  var $table = "expense";
  var $column_order = array("project_name","value", "expense_value");
  var $column_search = array("project_code_fk","project_name", "full_name","expense_date", "expense_value", "information_name","note");
  var $order = array('expense_id' => 'DESC'); // default order

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function get_information(){
        $hasil=$this->db->query("SELECT * FROM information where type='expense'");
        return $hasil;
    }

  function insert_all($table,$data) {
  $this->db->insert($table,$data);
  }

  private function _get_datatables_query()
  {

    $this->db->select('expense.*,
    GROUP_CONCAT(`expense_id`) as `expense_id`,
    GROUP_CONCAT(`type_expense`) as `type_expense` ,
    GROUP_CONCAT(`expense_date`) as `expense_date` ,
    GROUP_CONCAT(`user_name_fk`) as `user_name_fk` ,
    GROUP_CONCAT(`note`) as `note`,
    GROUP_CONCAT(`expense_value`) as `expense_value`,
     sum(`expense_value`) AS `total`,
    GROUP_CONCAT(user.full_name) as `full_name`,project.project_name,project.project_type,project.value,GROUP_CONCAT(information.information_name) as information_name');
        $this->db->from($this->table);
        $this->db->group_by('project_code_fk');
        $this->db->join('user','user.user_name=expense.user_name_fk','left');
        $this->db->join('project','project.project_code=expense.project_code_fk','left');
        $this->db->join('information','information.information_id=expense.type_expense','left');


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

  function search_blog($title){
  $this->db->like('project_name', $title , 'both');
  $this->db->or_like('project_code', $title , 'both');
  $this->db->order_by('project_name', 'ASC');
  $this->db->limit(4);
  return $this->db->get('project')->result();
  }

  function hapus_data($where,$table){
  $this->db->where($where);
  $this->db->delete($table);
  }

  function edit_data($where,$table){
    return $this->db->get_where($table,$where);
  }

}
?>
