<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath(__DIR__ . '/../class/'));

require_once('driver/MySQLi.class.php');

if(isset($_POST['submit']) && $_POST['submit'] == 'login')
{
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $mysqli = new driver\MySQLi();
    if($mysqli->connect('cloo_admin', 'ClooAdmin@1234', 'cloo'))
    {
        $result = $mysqli->query('SELECT `name`, `password` FROM `cloo`.`user` WHERE `name`=\'' . $username . '\';');
        if($result)
        {
            print(json_encode(array(
                'name'     => $result['rows'][1][0],
                'password' => $result['rows'][1][1]
            )));
        }
    }
}

?>
