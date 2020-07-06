<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require './config/connect.php';
$content = [];
$sql = "SELECT C_ID,`File Name/Link`,Type,Date_Modified from Content;";
$result= mysqli_query($con, $sql);
if($result)
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $content[$cr]['id'] = $row['C_ID'];
    $content[$cr]['Fname'] = $row['File Name/Link'];
    $content[$cr]['Type'] = $row['Type'];
    $content[$cr]['DMof'] = $row['Date_Modified'];
    $cr++;
  }
  echo json_encode(['data'=>$content]);
  
}
 else {
    http_response_code(404);   
}
mysqli_close($con);