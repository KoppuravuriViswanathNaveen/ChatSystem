<?php
    session_start();
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);//checking all requied fileds are filled or not
    if(!empty($fname) && !empty($lname) && !empty($email) &&!empty($mobile) && !empty($password)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");//checking if email already exist or not
            if(mysqli_num_rows($sql) > 0){
                echo "$email - This email already exist!";
            }else{  //checking whether user upload file or not
                if(isset($_FILES['image'])){ //if file is uploaded
                    $img_name = $_FILES['image']['name'];//getting user uploaded img name
                    $img_type = $_FILES['image']['type'];//getting user uploaded img type
                    $tmp_name = $_FILES['image']['tmp_name'];//temporary name is used to save file in our folder
                    //expoloiding the image and get the last extension as like jpg png
                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode);//here we get the extension for the user uploaded img file
    
                    $extensions = ["jpeg", "png", "jpg"];
                    if(in_array($img_ext, $extensions) === true){//checking extension is matched or not
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true){
                            $time = time();//will return the current time
                            $new_img_name = $time.$img_name;
                            if(move_uploaded_file($tmp_name,"images/".$new_img_name)){//if user uploaded file we move to our folder
                                $ran_id = rand(time(), 100000000);
                                $status = "Active now";
                                $encrypt_pass = md5($password);//encrypting password
                                //inserting all the user data in to the table
                                $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email,mobile, password, img, status)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}','{$mobile}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                                if($insert_query){//if the data inserted or not
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    if(mysqli_num_rows($select_sql2) > 0){
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        $_SESSION['unique_id'] = $result['unique_id'];
                                        echo "success";
                                    }else{
                                        echo "This email address not Exist!";
                                    }
                                }else{
                                    echo "Something went wrong. Please try again!";
                                }
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        }else{
            echo "$email is not a valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>