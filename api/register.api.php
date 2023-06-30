<?php

set_include_path(get_include_path() . PATH_SEPARATOR . realpath(__DIR__ . '/../class/'));

require_once('driver/MySQLi.class.php');

if(isset($_POST['submit']) && $_POST['submit'] == 'register')
{
    // $email    = isset($_POST['email'])    ? $_POST['email']    : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $age      = isset($_POST['age']) ? $_POST['age'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $mysqli = new driver\MySQLi();
    if($mysqli->connect('cloo_admin', 'ClooAdmin@1234', 'cloo'))
    {
        $result = $mysqli->query('SELECT `name` FROM `cloo`.`user` WHERE `name`=\'' . $username . '\';');
        if(!$result)
        {
            $result = $mysqli->query("INSERT INTO `cloo`.`user`(`name`, `age`, `password`)
                 VALUES('$username', $age, '$password');");
            if($result)
            {
                print('{success: true}');
            }
        }
    }
}

?>
