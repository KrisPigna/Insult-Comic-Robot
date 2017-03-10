<?php

function detectFace($img_url) {

    $url = "https://westus.api.cognitive.microsoft.com/face/v1.0/detect?returnFaceId=true&returnFaceLandmarks=true&returnFaceAttributes=age,gender,facialHair,glasses,smile";
    $data = array('url' => $img_url);
    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_POST, 1); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER,    
                array('Content-Type: application/json',
                'Ocp-Apim-Subscription-Key: a35da0405dd748d7b7bc20ee856f1913') 
               ); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    $result = curl_exec($ch); 
    curl_close($ch);
    echo '<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Insult Comic Robot</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
   
   <body>
   <div class="content-section-a">
        <div class="container">

            <div class="row">
                <div class="col-lg-5 col-sm-6">
        <textarea id="json" cols="20" rows="20" style="display: none">'.$result.'</textarea>
        <img id="before" style="display: none;" src="'.$img_url.'">
        <canvas id="myCanvas" class="img-responsive"></canvas>
</div>
                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
     <p id="robot" class="triangle-isosceles">Analyzing...</p>
     <img src="http://lamp.cse.fau.edu/~kpigna1/ws_project1/img/robot.jpg" class="img-responsive">
     </div>
     </div>
     </div>
     </div>
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="./js/imageDrawing.js"</script>
    <script src="./js/exif/exif.js"</script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>';
}

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
       // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        detectFace("http://lamp.cse.fau.edu/~kpigna1/ws_project1/uploads/". basename( $_FILES["fileToUpload"]["name"]));
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
