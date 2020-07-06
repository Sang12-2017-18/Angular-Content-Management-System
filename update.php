<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { die(); }
require './config/connect.php';  
$response1 = array();
$upload_dir1 = './Allfiles/';
$server_url1 = 'http://127.0.0.1:80/';
$data=json_decode(file_get_contents("php://input"));
$fname=0;
if(isset($data->idf) || $_FILES["newfile"]["name"])
{
    /*
    $fname= $_POST['idf'];
    $newfile_name = $_FILES["newfile"]["name"];
    $newfile_tmp_name = $_FILES["newfile"]["tmp_name"];
    $newfile_type=$_FILES["newfile"]["type"];
    $error = $_FILES["newfile"]["error"];
     * 
     */
    $fname=$_POST['idf'];
    $newfile_name=$_FILES['newfile']['name'];
    $newfile_tmp_name = $_FILES['newfile']['tmp_name'];
    $newfile_type=$_FILES['newfile']['type'];
    $error=$_FILES['newfile']['error'];
    if($error > 0){
        $response1 = array(
            "status" => "error",
            "error" => true,
            "message" => "Error uploading!"
        );
    }
    else 
    {
        $random_name = $newfile_name;
        $upload_name = $upload_dir1.$random_name;
        //$upload_name = preg_replace('/\s+/', '-', $upload_name);
        
        //Uploading the new file
        if(move_uploaded_file($newfile_tmp_name , $upload_name)) {
            
            $response1 = array(
                "status" => "success",
                "error" => false,
                "message" => "File uploaded successfully",
                "url" => $server_url1."/".$upload_name
              );
        
         $file_to_delete1 = './Allfiles/'.$fname;
         unlink($file_to_delete1);
         //Updating the DBMS record
            $query1="UPDATE Content set `File Name/Link`='$random_name', Type='$newfile_type'"
                    . " where `File Name/Link`='$fname';";
            $res=mysqli_query($con,$query1);
            if(!$res)
            {
                $response1 = array(
                "status" => "error",
                "error" => true,
                "message" => "Error uploading(DBMS)!".mysqli_error($con) 
                );
            }
            
        } else
        {
            $response1 = array(
                "status" => "error",
                "error" => true,
                "message" => "Error uploading the file:!".$fname
            );
        }
    }
}

else
    {
    $response1 = array(
        "status" => "error",
        "error" => true,
        "message" => "No file was sent!"
    );
}


echo json_encode($response1);
mysqli_close($con);

