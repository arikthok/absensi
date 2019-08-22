<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class M_information extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }
  function get_information(){
        $hasil=$this->db->query("SELECT * FROM information");
        return $hasil;
    }
}
?>
