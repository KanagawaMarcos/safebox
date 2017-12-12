<?php
session_start();
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 30/11/2017
 * Time: 19:32
 */
if(isset($_SESSION['u_id'])){
    include_once 'interface.php';
}
