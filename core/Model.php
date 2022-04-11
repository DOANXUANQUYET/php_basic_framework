<?php

class Model {
    protected $db;
    protected $table;

    function __construct()
    {
        $databaseDriverName = DATABASE['database_default']['driver'].'Driver';
        $this->db = new $databaseDriverName( DATABASE['database_default']);
    }
}
