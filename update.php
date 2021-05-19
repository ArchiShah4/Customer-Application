<?php
require_once "config.php";
 
$name = $dob = $gender = $phone = $email = "";
$name_err = $dob_err = $gender_err = $phone_err = $email_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){

    $id = $_POST["id"];
    
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    $input_dob = trim($_POST["date_of_birth"]);
    if(empty($input_dob)){
        $dob_err = "Please enter Date of Birth.";     
    } else{
        $dob = $input_dob;
    }
    
    $input_gender = trim($_POST["gender"]);
    if(empty($input_gender)){
        $gender_err = "Please enter the Gender.";     
    } else{
        $gender = $input_gender;
    }

    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Please enter the phone number.";     
    } else{
        $phone = $input_phone;
    }

    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter the Email.";     
    } else{
        $email = $input_email;
    }
    
    if(empty($name_err) && empty($dob_err) && empty($gender_err) && empty($phone_err) && empty($email_err)){

        $sql = "UPDATE customers SET name=?, date_of_birth=?, gender=?, phone=?, email=? WHERE id=?";
 
        if($stmt = $mysqli->prepare($sql)){

            $stmt->bind_param("sssssi", $param_name, $param_dob, $param_gender, $param_phone, $param_email, $param_id);
            
            $param_name = $name;
            $param_dob = $dob;
            $param_gender = $gender;
            $param_phone = $phone;
            $param_email = $email;
            $param_id = $id;
            
            if($stmt->execute()){

                header("location: welcome.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        $stmt->close();
    }

    $mysqli->close();
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM customers WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){

            $stmt->bind_param("i", $param_id);
            
            $param_id = $id;
            
            if($stmt->execute()){
                $result = $stmt->get_result();
                
                if($result->num_rows == 1){

                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    
                    $name = $row["name"];
                    $dob = $row["date_of_birth"];
                    $gender = $row["gender"];
                    $phone = $row["phone"];
                    $email = $row["email"];
                } else{
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        $stmt->close();

        $mysqli->close();
    }  else{

        header("location: error.php");
        exit();
    }
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the customer record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Date of Birth</label>
                            <input type="text" name="date_of_birth" class="form-control <?php echo (!empty($dob_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dob; ?>">
                            <span class="invalid-feedback"><?php echo $dob_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <input type="text" name="gender" class="form-control <?php echo (!empty($gender_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $gender; ?>">
                            <span class="invalid-feedback"><?php echo $gender_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="number" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone; ?>">
                            <span class="invalid-feedback"><?php echo $phone_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="welcome.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>