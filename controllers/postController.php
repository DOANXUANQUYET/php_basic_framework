<?php
namespace controllers;
use \Request;

class postController extends \Controller
{
    public function __construct()
    {
        $this->load_model('post');
        $this->load_model('category');
    }

    public function index()
    {
        $data['posts'] = $this->postModel->get_list();
        $data['page'] = 'post.list';
        $this->load_view('layout_master',$data);
    }

    public function add()
    {
        $data['categories'] = $this->categoryModel->get_list();
        $data['page'] = 'post.add';
        $this->load_view('layout_master',$data);
    }

    public function edit($id)
    {
        $data['categories'] = $this->categoryModel->get_list();
        $data['post'] = $this->postModel->get_post_by_id($id[0]);
        $data['page'] = 'post.edit';
        $this->load_view('layout_master',$data);
    }

    function create(){
        $data['post_title'] = Request::post('post_title');
        $data['post_content'] = Request::post('post_content');
        $data['id_category_post'] = Request::post('id_category_post');
        $this->postModel->insert($data);
        $this->index();
    }

    function update(){
        $id = Request::post('id_post');
        $data['post_title'] = Request::post('post_title');
        $data['post_content'] = Request::post('post_content');
        $data['id_category_post'] = Request::post('id_category_post');
        $where = "id_post = $id";
        $this->postModel->update($data,$where);
        $this->index();
    }

    function delete($id){
        $where = "id_post = $id[0]";
        $this->postModel->delete($where);
        $this->index();
    }
}