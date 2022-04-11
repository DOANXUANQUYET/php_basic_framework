<?php

class QueryBuilder
{
    private $columns;
    private $from;
    private $distinct = false;     //Từ khóa DISTINCT được sử dụng để chỉ lấy các bản ghi duy nhất trong bảng.
    private $joins;
    private $wheres;
    private $groups;
    private $havings;
    private $orders;
    private $limit;
    private $offset;

    public function __construct($tableName)
    {
        $this->from = $tableName;
    }

    public static function table($tableName)
    {
        return new self($tableName);
    }

    public function select($columns)
    {
        // func_get_args() Nó trả về một mảng chứa tất cả các đối số được truyền cho hàm
        $this->columns = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    public function distinct()
    {
        $this->distinct = true;
    }

    public function join($table, $first, $operator, $second, $type = 'inner')
    {
        $this->joins[] = [$table, $first, $operator, $second, $type];
        return $this;
    }

    public function left_join($table, $first, $operator, $second, $type = 'left')
    {
        $this->joins[] = [$table, $first, $operator, $second, $type];
        return $this;
    }

    public function right_join($table, $first, $operator, $second, $type = 'right')
    {
        $this->joins[] = [$table, $first, $operator, $second, $type];
        return $this;
    }

    public function where($column, $operator, $value, $boolean = 'AND')
    {
        $this->wheres[] = [$column, $operator, $value, $boolean];
        return $this;
    }

    public function or_where($column, $operator, $value, $boolean = 'OR')
    {
        $this->wheres[] = [$column, $operator, $value, $boolean];
        return $this;
    }

    public function groupBy($columns)
    {
        $this->groups = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    public function having($column, $operator, $value, $boolean = 'AND')
    {
        $this->havings[] = [$column, $operator, $value, $boolean];
        return $this;
    }

    public function or_having($column, $operator, $value, $boolean = 'OR')
    {
        $this->havings[] = [$column, $operator, $value, $boolean];
        return $this;
    }

    public function orderBy($columns, $direction = 'ASC')
    {
        $this->orders[] = [$columns, $direction];
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    function get(){
        if(empty($this->from)){
            return false;
        }

        $sql = $this->distinct ? 'SELECT DISTINCT ' : 'SELECT ';

        if(!empty($this->columns) && is_array($this->columns)){
            $sql .= implode(',',$this->columns);
        }else{
            $sql .= '* ';
        }

        $sql .= ' FROM '.$this->from;
        if(!empty($this->joins) && is_array($this->joins)){
            $sql = $this->join_builder($sql);
        }

        if(!empty($this->wheres) && is_array($this->wheres)){
            $sql = $this->where_builder($sql);
        }

        if(!empty($this->groups) && is_array($this->groups)){
            $sql .= ' GROUP BY '.implode(',',$this->groups);
        }

        if(!empty($this->havings) && is_array($this->havings)){
            $sql = $this->having_builder($sql);
        }

        if(!empty($this->orders) && is_array($this->orders)){
            $sql = $this->order_builder($sql);
        }

        if(!empty($this->limit)){
            $sql .= " LIMIT $this->limit ";
        }

        if(!empty($this->offset)){
            $sql .= " OFFSET $this->offset ";
        }

        $this->reset_query();
        return $sql;
    }

    private function join_builder($sql)
    {
        foreach ($this->joins as $join){
            switch (strtolower($join[4])){
                case 'inner' :
                    $sql .= ' INNER JOIN ';
                    break;
                case 'left' :
                    $sql .= ' LEFT JOIN ';
                    break;
                case 'right' :
                    $sql .= ' RIGHT JOIN ';
                    break;
                default:
                    $sql .= ' INNER JOIN ';
            }
            $sql .= " $join[0] ON $join[1] $join[2] $join[3] ";
        }
        return $sql;
    }

    private function where_builder($sql)
    {
        $sql .= ' WHERE ';
        foreach ($this->wheres as $index => $where){
            if($index < (count($this->wheres) - 1)){
                $sql .= " $where[0] $where[1] $where[2] $where[3] ";
            } else{
                $sql .= " $where[0] $where[1] $where[2] ";
            }
        }
        return $sql;
    }

    private function having_builder($sql)
    {
        $sql .= ' HAVING ';
        foreach ($this->havings as $index => $having){
            if($index < (count($this->havings) - 1)){
                $sql .= " $having[0] $having[1] $having[2] $having[3] ";
            } else{
                $sql .= " $having[0] $having[1] $having[2] ";
            }
        }
        return $sql;
    }

    private function order_builder($sql)
    {
        $sql .= ' ORDER BY ';
        foreach ($this->orders as $index => $order){
            if($index < (count($this->orders) - 1)){
                $sql .= " $order[0] $order[1], ";
            } else{
                $sql .= " $order[0] $order[1] ";
            }
        }
        return $sql;
    }

    private function reset_query()
    {
        $this->columns = null;
        $this->from = null;
        $this->distinct = false;     //Từ khóa DISTINCT được sử dụng để chỉ lấy các bản ghi duy nhất trong bảng.
        $this->joins = null;
        $this->wheres = null;
        $this->groups = null;
        $this->havings = null;
        $this->orders = null;
        $this->limit = null;
        $this->offset = null;
    }
}
