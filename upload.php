<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require './config/connect.php';  
$response = array();
$upload_dir = './Allfiles/';
$server_url = 'http://127.0.0.1:80/';
if($_FILES['avatar'])
{
    $avatar_name = $_FILES["avatar"]["name"];
    $avatar_tmp_name = $_FILES["avatar"]["tmp_name"];
    $avatar_type=$_FILES["avatar"]["type"];
    $error = $_FILES["avatar"]["error"];
    if($error > 0){
        $response = array(
            "status" => "error",
            "error" => true,
            "message" => "Error uploading!"
        );
    }else 
    {
        $random_name = $avatar_name;
        $upload_name = $upload_dir.$random_name;
        //$upload_name = preg_replace('/\s+/', '-', $upload_name);
    
        if(move_uploaded_file($avatar_tmp_name , $upload_name)) {
            $response = array(
                "status" => "success",
                "error" => false,
                "message" => "File uploaded successfully",
                "url" => $server_url."/".$upload_name
              );
            $query="INSERT INTO Content(`File Name/Link`,Type,User_ID) values"
                    . " ('$avatar_name','$avatar_type',1);";
            $res=mysqli_query($con,$query);
            if(!$res)
            {
                $response = array(
                "status" => "error",
                "error" => true,
                "message" => "Error uploading(DBMS)!".mysqli_error($con) 
                );
            }
            
        } else
        {
            $response = array(
                "status" => "error",
                "error" => true,
                "message" => "Error uploading the file:!" . $error
            );
        }
    }
}

else{
    $response = array(
        "status" => "error",
        "error" => true,
        "message" => "No file was sent!"
    );
}

echo json_encode($response);
mysqli_close($con);
