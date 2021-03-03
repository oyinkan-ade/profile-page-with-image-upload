<?php

    // CONNECT TO DATABASE ON THE LOCALHOST SERVER
    $db = mysqli_connect('localhost', 'root', '', 'profiledb');
    
    // INITIALIZE A MESSAGE VARIABLE
    $message = "";

    // IF FORM IS SUBMITTED....
    if(isset($_POST['submit'])){
        // GET NAME FROM INPUT
        $name = mysqli_real_escape_string($db, $_POST['name']);
        // GET EMAIL FROM INPUT
        $email= mysqli_real_escape_string($db, $_POST['email']);
        // GET PASSWORD FROM INPUT
        $password = mysqli_real_escape_string($db, $_POST['password']);
        // GET IMAGE
        $img = time() ."_". $_FILES['profile_image']['name'];

        // DECLARE THE INSERT QUERY
        $insert_sql = "INSERT INTO users (user_name, user_password, user_email, profile_img) VALUES ('$name', '$password', '$email', '$img')";

        // GET IMAGE FILE DIRECTORY
        $target ="images/" .basename($img);

        if (!$name || !$email || !$password || !$img){
            $message = 'Input cannot be empty';
        }
        else{
            // EXECUTE THE QUERY
            if(move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)){
                $result = mysqli_query($db, $insert_sql);
                if($result){
                    $message = "Record Saved Successfully";
                }
            }
            else{
                $message = "Failed to save record";
            }
        }
    }


?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <title>PROFILE REGISTRATION PAGE</title>
</head>
<body>
    <div class="container">
        <h1>Profile registration</h1>

        <p><?php echo $message ?></p><br>
        <form action="profile_reg.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Full name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Full name">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="profile-image">Profile image</label>
                <input type="file" class="form-control-file" name="profile_image" id="profile-image">
            </div>
            <button class="btn btn-primary" name="submit" type="submit">Submit</button>
            <!-- <input > -->
        </form>
    </div>
</body>
</html>