<?php
require_once "config.php";
 
$height = $weight = $bp = "";
$height_err = $weight_err = $bp_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_height = trim($_POST["height"]);
    if(empty($input_height)){
        $height_err = "Please enter the height.";     
    } elseif(!ctype_digit($input_height)){
        $height_err = "Please enter a positive integer value.";
    } else{
        $height = $input_height;
    }
    
    $input_weight = trim($_POST["weight"]);
    if(empty($input_weight)){
        $weight_err = "Please enter the weight.";     
    } elseif(!ctype_digit($input_weight)){
        $weight_err = "Please enter a positive integer value.";
    } else{
        $weight = $input_weight;
    }

    $input_bp = trim($_POST["blood_pressure"]);
    if(empty($input_bp)){
        $bp = "0";     
    } elseif(!ctype_digit($input_bp)){
        $bp_err = "Please enter a positive integer value.";
    } else{
        $bp = $input_bp;
    }
    

    if(empty($height_err) && empty($weight_err) && empty($bp_err)){

        $sql = "INSERT INTO measurements (height, weight, blood_pressure) VALUES (?, ?, ?)";
 
        if($stmt = $mysqli->prepare($sql)){

            $stmt->bind_param("sss", $param_height, $param_weight, $param_bp);
            
            $param_height = $height;
            $param_weight = $weight;
            $param_bp = $bp;
            
            if($stmt->execute()){
                header("location: measurements.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        $stmt->close();
    }

    $mysqli->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add customer measurements to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Height</label>
                            <input type="number" name="height" class="form-control <?php echo (!empty($height_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $height; ?>">
                            <span class="invalid-feedback"><?php echo $height_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Weight</label>
                            <input type="number" name="weight" class="form-control <?php echo (!empty($weight_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $weight; ?>">
                            <span class="invalid-feedback"><?php echo $weight_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Blood Pressure</label>
                            <input type="number" name="blood_pressure" class="form-control <?php echo (!empty($bp_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $bp; ?>">
                            <span class="invalid-feedback"><?php echo $bp_err;?></span>
                        </div>


                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="measurements.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>