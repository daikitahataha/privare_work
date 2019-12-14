<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Admin_abstract.php');

class Category extends Admin_abstract{

  public function __construct(){
    parent::__construct();
    $this->load->model('bll/Bll_category');
  }

  public function index(){
    $where_array['delete_flg'] = 0;
    $data['category'] = $this->Bll_category->get_category($where_array);

    $this->load->view('admin/category/index', $data);
  }

	public function create(){
		$this->load->view('admin/category/create');
	}

  public function register(){

    $res = $this->_form_validation();

    if($res)
    {
      $post = $this->input->post();

      $ret = $this->Bll_category->create_category($post);

      if($ret){
        $this->load->view('admin/category/register');
      }
    }
    else
    {
      $this->create();
      return;
    }


  }

  public function edit($id){

    $data['category'] = $this->Bll_category->get_category($id);

    $this->load->view('admin/category/edit', $data);
  }

  public function update(){

    $res = $this->_form_validation();

    if($res)
    {
        $post = $this->input->post();
        $ret = $this->Bll_category->update_category($post);

        if($ret)
        {
            $this->load->view('admin/category/update');
        }
        else
        {
            $this->index();
            return;
        }
    }
  }

    public function delete($id){
      $res = $this->Bll_category->delete($id);

      if($res)
      {
          $this->load->view('admin/category/index');
      }
    }


  private function _form_validation(){
    $this->form_validation->set_rules('category_name', 'カテゴリ名', 'required');

    $error_msg = array(
      'required' => 'カテゴリ名を入力してください'
    );

    $this->form_validation->set_message($error_msg);
    $res = $this->form_validation->run();

    return $res;
  }
}
