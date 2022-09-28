<?php

include "dbconfig.php";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
session_start();

if(isset($_COOKIE['user_login']) && !isset($_SESSION['user_login']))
{
    $_SESSION['user_login'] = unserialize($_COOKIE['user_login']);
}

$user_check = unserialize($_COOKIE['user_login']);
$user_check = $user_check['username'];
$ses_sql = mysqli_query($conn,"SELECT username, id FROM users WHERE username = '$user_check' ") or die(mysqli_error($conn));

$row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
$count = mysqli_num_rows($ses_sql);

$login_session = $row['username'];
$login_user_id =  $row['id'];

$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/creativehope-authentication\/';

if($count === 1)
{
    if(!isset($user_check))
    {
        header("location:{$root}");
        die();
        exit();
    }
}
else
{
    header("location:{$root}");
    die();
    exit();
}

?>