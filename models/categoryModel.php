<?php
class categoryModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'tbl_category_post';
    }

    public function get_list()
    {
        return $this->db->table($this->table)
                    ->select('id_category_post','title_category_post')
                    ->orderBy('id_category_post','ASC')
                    ->get();
    }

    public function get_category_by_id($id)
    {
        return $this->db->table($this->table)
            ->select('id_category_post','title_category_post','desc_category_post')
            ->where('id_category_post','=',$id)
            ->get();
    }

    public function insert($data){
        $this->db->table($this->table)->insert($data);
    }

    public function update($data,$where){
        $this->db->table($this->table)->update($data,$where);
    }

    public function detele($where){
        $this->db->table($this->table)->delete($where);
    }
}
