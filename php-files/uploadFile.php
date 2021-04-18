<?php
//return array of response and file uploaded
function uploadFile($tmp_name, $name, $size) {
    $target_dir = "assets/img/project-icons/";
    $target_file = $target_dir . basename($name);
    $uploadOk = true;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $response = "";

    // Check if image file is a actual image or fake image
      $check = getimagesize($tmp_name);
      if($check !== false) {
        $uploadOk = true;
      } else {
        $response = "File is not an image.";
        $uploadOk = false;
      }

    // Check if file already exists
    while (file_exists($target_file)) {
        //make random filename
        $numbers = range(0, 9);
        shuffle($numbers);
        for ($i = 0; $i < 10; $i++) {
            global $digits;
            $filename .= $numbers[$i];
        }
      $target_file = $target_dir . $filename . "." . $imageFileType;
    }

    // Check file size
    if ($size > 500000) {
      $response = "Sorry, your file is too large.";
      $uploadOk = false;
    }

    // Only allow jpg, png, jpeg, and gif
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      $response = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = false;
    }

    if ($uploadOk == true) {
      if (!move_uploaded_file($tmp_name, $target_file)) {
        $response = "Sorry, there was an error uploading your file.";
      }
  }
  return [$response, $target_file];
}


?>
