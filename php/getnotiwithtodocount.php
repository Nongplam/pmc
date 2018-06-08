<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include 'connectDB.php';
$userid = $_SESSION["id"];
