<?php
/**
 * Created by PhpStorm.
 * User: Abadon
 * Date: 6/8/2018
 * Time: 3:32 PM
 */





            if ($_SERVER['CONTENT_LENGTH'] < 8380000) {
                /* Location */

                // Count total files
                $countfiles = count($_FILES['file']['name']);
                if(!is_dir($location)) {
                    mkdir($location,0777, true);
                }
                $filename_arr = array();
                // Looping all files
                for ($i = 0; $i < $countfiles; $i++) {

                    $path = $_FILES['file']['name'][$i];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $filename = $subid."_".$order."_".$no."_".$status."_".($i+1).".".$ext ; //   $_FILES['file']['name'][$i];

                    // Upload file
                    move_uploaded_file($_FILES['file']['tmp_name'][$i], $location ."/". $filename);
                    $filename_arr[] = $filename;
                }

               // $arr = array('name' => $filename_arr);
                //echo json_encode($arr);
            } else {
                    $err = "ขนาดไฟล์ไม่เกิน 8 mb";
                $arr = array('err' => $err);
                echo json_encode($arr);

            }

