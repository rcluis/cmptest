<?php

namespace Cmptest;

class DAO
{

    /**
    * Initializes the database
    *
    */
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
    * Inserts the data to the database in the especified table
    *
    * @param  string $table
    * @param  array $data
    *
    * @return array
    */
    public function insert($table, $data)
    {
        if(isset($_SESSION[$table])) {
            array_push($_SESSION[$table], $data);
        }
        else {
            $_SESSION[$table][] = $data;
        }
    }

    /**
    * Returns all the data from a "table"
    *
    * @param  string $table
    *
    * @return array
    */
    public function selectAll($table)
    {
        $result = [];

        if(isset($_SESSION[$table]))
        {
            $result = $_SESSION[$table];
        }

        return $result;
    }

    /**
    * Close the database "connection"
    *
    * @return boolean
    */
    public function close()
    {
        return session_destroy();
    }
}
