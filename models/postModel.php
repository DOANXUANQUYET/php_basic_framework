<?php
class postModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tbl_post';
    }

    function get_list()
    {
        return $this->db->table($this->table)
                    ->select('id_post','post_title','post_content','title_category_post')
                    ->join('tbl_category_post','tbl_category_post.id_category_post','=','tbl_post.id_category_post')
                    ->limit(5)
                    ->orderBy('id_post','DESC')
                    ->get();
    }

    function get_post_by_id($id)
    {
        return $this->db->table($this->table)
            ->select('id_post','post_title','post_content','id_category_post')
            ->where('id_post','=',$id)
            ->get();
    }

    function insert($data){
        $this->db->table($this->table)->insert($data);
    }

    function update($data,$where){
        $this->db->table($this->table)->update($data,$where);
    }

    function delete($where){
        $this->db->table($this->table)->delete($where);
    }
}
