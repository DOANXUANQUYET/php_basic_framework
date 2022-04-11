<?php

abstract class Database
{
    protected $connection = null;
    protected $host = '';
    protected $user = '';
    protected $pass = '';
    protected $name = '';
    protected $table = '';

    public function __construct($config)
    {
        include_once ('libraries/database/QueryBuilder.php');

        $this->host = $config['host'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->name = $config['name'];

    }

    abstract protected function connect();
    abstract protected function insert($data);
    abstract protected function update($data, $where);
    abstract protected function delete($where);
    abstract protected function delete_all();

}
