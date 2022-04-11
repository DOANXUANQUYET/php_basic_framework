<?php
namespace controllers;
use \Request;

class categoryController extends \Controller
{
    public function __construct()
    {
        $this->load_model('category');
    }

    public function index()
    {
        $data['categories'] = $this->categoryModel->get_list();
        $data['page'] = 'category.list';
        $this->load_view('layout_master',$data);
    }

    public function add()
    {
        $data['page'] = 'category.add';
        $this->load_view('layout_master',$data);
    }

    public function edit($id)
    {
        $data['category'] = $this->categoryModel->get_category_by_id($id[0]);
        $data['page'] = 'category.edit';
        $this->load_view('layout_master',$data);
    }

    public function create()
    {
        $data['title_category_post'] = Request::post('title_category_post');
        $data['desc_category_post'] = Request::post('desc_category_post');
        $this->categoryModel->insert($data);
        $this->index();
    }

    function update(){
        $id = Request::post('id_category_post');
        $data['title_category_post'] = Request::post('title_category_post');
        $data['desc_category_post'] = Request::post('desc_category_post');
        $where = "id_category_post = $id";
        $this->categoryModel->update($data,$where);
        $this->index();
    }

    function delete($id){
        $where = "id_category_post = $id[0]";
        $this->categoryModel->detele($where);
        $this->index();
    }

}
