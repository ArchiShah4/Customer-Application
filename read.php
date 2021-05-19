<?php
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

    require_once "config.php";
    
    $sql = "SELECT * FROM customers WHERE id = ?";
    
    if($stmt = $mysqli->prepare($sql)){

        $stmt->bind_param("i", $param_id);

        $param_id = trim($_GET["id"]);
        
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
} else{

    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b><?php echo $row["name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <p><b><?php echo $row["date_of_birth"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Gender</label>
                        <p><b><?php echo $row["gender"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <p><b><?php echo $row["phone"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <p><b><?php echo $row["email"]; ?></b></p>
                    </div>
                    <p><a href="welcome.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>