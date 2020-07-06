<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { die(); }
require './config/connect.php';
/* @var $id string */
$id = htmlspecialchars($_GET['id']);

if(!$id)
{
  return http_response_code(400);
}

$sql1 = "SELECT `File Name/Link` FROM `Content` WHERE `C_ID` ='{$id}' LIMIT 1";
$result1 = mysqli_query($con,$sql1);
if(!$result1)
{
   return http_response_code(404); 
}
$drow=mysqli_fetch_row($result1);
$file_to_delete = './Allfiles/'.$drow['File Name/Link'];
unlink($file_to_delete);
$sql2 = "DELETE FROM `Content` WHERE `C_ID` ='$id' LIMIT 1";

if(mysqli_query($con, $sql2))
{
  return http_response_code(204);
}
else
{
  return http_response_code(422);
}

mysqli_close($con);

