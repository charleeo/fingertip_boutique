<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/phpecommerce/core/init.php';
unset($_SESSION['SBuser']);
header('Location: login.php');
?>