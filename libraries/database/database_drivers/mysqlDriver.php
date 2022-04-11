<?php

class mysqlDriver extends Database
{
    private static $query_bulider;
    private $statement = null;

    function __construct($config)
    {
        parent::__construct($config);
        $this->connect();
    }

    protected function connect()
    {
        $this->connection = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->name
        );
        if ($this->connection->connect_errno) {
            exit($this->connection->connect_errno);
        }
    }

    public function table($tableName)
    {
        $this->table = $tableName;
        self::$query_bulider = QueryBuilder::table($tableName);
        return $this;
    }

    public function select($columns)
    {
        // func_get_args() Nó trả về một mảng chứa tất cả các đối số được truyền cho hàm
        $this->columns = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    public function distinct()
    {
        self::$query_bulider->distinct();
        return $this;
    }

    public function join($table, $first, $operator, $second, $type = 'inner')
    {
        self::$query_bulider->join($table, $first, $operator, $second, $type);
        return $this;
    }

    public function left_join($table, $first, $operator, $second, $type = 'left')
    {
        self::$query_bulider->left_join($table, $first, $operator, $second, $type);
        return $this;
    }

    public function right_join($table, $first, $operator, $second, $type = 'right')
    {
        self::$query_bulider->right_join($table, $first, $operator, $second, $type);
        return $this;
    }

    public function where($column, $operator, $value, $boolean = 'AND')
    {
        self::$query_bulider->where($column, $operator, $value, $boolean);
        return $this;
    }

    public function or_where($column, $operator, $value, $boolean = 'OR')
    {
        self::$query_bulider->or_where($column, $operator, $value, $boolean);
        return $this;
    }

    public function groupBy($columns)
    {
        self::$query_bulider->groupBy($columns);
        return $this;
    }

    public function having($column, $operator, $value, $boolean = 'AND')
    {
        self::$query_bulider->having($column, $operator, $value, $boolean);
        return $this;
    }

    public function or_having($column, $operator, $value, $boolean = 'OR')
    {
        self::$query_bulider->or_having($column, $operator, $value, $boolean);
        return $this;
    }

    public function orderBy($columns, $direction = 'ASC')
    {
        self::$query_bulider->orderBy($columns, $direction);
        return $this;
    }

    public function limit($limit)
    {
        self::$query_bulider->limit($limit);
        return $this;
    }

    public function offset($offset)
    {
        self::$query_bulider->offset($offset);
        return $this;
    }

    public function get()
    {
        $sql = self::$query_bulider->get();
        $result = $this->connection->query($sql);
        $this->reset_query();

        $return_data = [];
        if($result->num_rows > 0){
            while ($row = $result->fetch_object()){
                $return_data[] = $row;
            }
        }

        return $return_data;
    }

    public function create_my_sql($sql)
    {
        return $this->connection->query($sql);
    }


    public function insert($data = [])
    {
        $fields = implode(',', array_keys($data));
        //count param number and make param string
        $param_string = implode(',', array_fill(0, count($data), '?'));
        $values = array_values($data);

        $sql = "INSERT INTO $this->table ($fields) VALUES($param_string)";
        $this->statement = $this->connection->prepare($sql);
        $this->statement->bind_param(str_repeat('s', count($data)), ...$values);
        $this->statement->execute();
        $this->reset_query();

        return $this->statement->affected_rows;
    }

    public function update($data = [], $where = '')
    {
        $key_values = [];
        foreach ($data as $key => $value) {
            $key_values[] = $key . ' = ?';
        }
        $set_fields = implode(',', $key_values);
        $values = array_values($data);
        $sql = "UPDATE $this->table SET $set_fields ";
        if(!empty($where)){
            $sql .= " WHERE $where ";
        }

        $this->statement = $this->connection->prepare($sql);
        $this->statement->bind_param(str_repeat('s', count($data)), ...$values) ;
        $this->statement->execute();
        $this->reset_query();

        return $this->statement->affected_rows;
    }


    public function delete($where)
    {
        $sql = "DELETE FROM $this->table WHERE $where";
        $result = $this->connection->query($sql);
        $this->reset_query();
        return $result;

    }

    protected function delete_all()
    {
        $sql = "DELETE FROM $this->table";
        $result = $this->connection->query($sql);
        $this->reset_query();
        return $result;
    }

    private function reset_query()
    {
          $this->table = '';
          self::$query_bulider = null;
    }
}