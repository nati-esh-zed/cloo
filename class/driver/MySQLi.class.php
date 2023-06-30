<?php

namespace driver;

// define(default_mysql_host, 'localhost');
// define(default_mysql_port, 3306);

class MySQLi 
{
    private $_connection = null;
    
    private $_host = null;
    private $_port = null;
    private $_user = null;
    private $_pass = null;
    private $_db   = null;

    public function get_host()     { return $this->_host; }
    public function get_port()     { return $this->_port; }
    public function get_user()     { return $this->_user; }
    public function get_database() { return $this->_db; }

    public function
    __construct()
    {}

    public function
    __destruct()
    {
        $this->close();
    }

    public function
    connect($user_, $pass_, $database_ = null, $host_ = 'localhost', $port_ = 3306)
    {
        \mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $connection_ = \mysqli_connect($host_, $user_, $pass_, $database_, $port_);
        if($connection_)
        {
            $this->_host = $host_;
            $this->_port = $port_;
            $this->_user = $user_;
            $this->_pass = $pass_;
            $this->_db   = $database_;
            $this->_connection = $connection_;
            return true;
        }
        else
        {
            return \mysqli_error($connection_);
        }
        return false;
    }

    public function
    close()
    {
        if($this->_connection)
        {
            \mysqli_close($this->_connection);
            $this->_connection = null;
        }
    }

    public function
    is_connected() { return $this->_connection != null; }

    public function
    query($sql_)
    {
        if($this->is_connected())
        {
            $query_result = \mysqli_query($this->_connection, $sql_);
            if(is_bool($query_result))
            {
                return $query_result;
            }
            else
            {

                $nfields      = \mysqli_num_fields($query_result);
                $nrows        = \mysqli_num_rows($query_result);
                if($nrows > 0)
                {
                    $result = array(
                        // 'fields'  => \mysqli_fetch_fields($query_result),
                        // 'rows'    => array(),
                        'rows'    => array(),
                        'nfileds' => $nfields,
                        'nrows'   => $nrows,
                    );
                    $fields = array();
                    while($field = \mysqli_fetch_field($query_result))
                    {
                        array_push($fields, $field->name);
                    }
                    array_push($result['rows'], $fields);
                    while($row = \mysqli_fetch_array($query_result, MYSQLI_NUM))
                    {
                        array_push($result['rows'], $row);
                    }
                    // var_dump($result);
                    return $result;
                }
            }
            return null;
        }
        return false;
    }

};

?>
