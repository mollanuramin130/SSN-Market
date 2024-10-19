<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_forget_password = $row['banner_forget_password'];
}
?>


<?php
/*
if(isset($_POST['form1'])) {

    $valid = 1;
        
    if(empty($_POST['cust_email'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_131."\\n";
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= LANG_VALUE_134."\\n";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($_POST['cust_email']));
            $total = $statement->rowCount();                        
            if(!$total) {
                $valid = 0;
                $error_message .= LANG_VALUE_135."\\n";
            }
        }
    }

    if($valid == 1) {

        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
        foreach ($result as $row) {
            $forget_password_message = $row['forget_password_message'];
        }

        $token = md5(rand());
        $now = time();

        $statement = $pdo->prepare("UPDATE tbl_customer SET cust_token=?,cust_timestamp=? WHERE cust_email=?");
        $statement->execute(array($token,$now,strip_tags($_POST['cust_email'])));
        
        $message = '<p>'.LANG_VALUE_142.'<br> <a href="'.BASE_URL.'reset-password.php?email='.$_POST['cust_email'].'&token='.$token.'">Click here</a>';
        
        $to      = $_POST['cust_email'];
        $subject = LANG_VALUE_143;
        $headers = "From: noreply@" . BASE_URL . "\r\n" .
                   "Reply-To: noreply@" . BASE_URL . "\r\n" .
                   "X-Mailer: PHP/" . phpversion() . "\r\n" . 
                   "MIME-Version: 1.0\r\n" . 
                   "Content-Type: text/html; charset=ISO-8859-1\r\n";

        mail($to, $subject, $message, $headers);

        $success_message = $forget_password_message;
    }
}
*/

if(isset($_POST['form1'])) {

    $valid = 1;
    $error_message = '';
    $success_message = '';
    
    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= "Phone number is required.\\n";
    } else {
        // Validate if phone number is exactly 10 digits and starts between 6 and 9
        if (!preg_match('/^[6-9][0-9]{9}$/', $_POST['cust_phone'])) {
            $valid = 0;
            $error_message .= "Phone number must be exactly 10 digits, and start with a digit between 6 and 9.\\n";
        } else {
            // Check if the phone number exists in the database
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_phone=?");
            $statement->execute(array($_POST['cust_phone']));
            $total = $statement->rowCount();                        
            
            if($total) {
                // Fetch the customer details
                $result = $statement->fetch(PDO::FETCH_ASSOC);
                $cust_password = $result['cust_password'];

                // Show the password to the user
                $success_message = "Your password is: ".$cust_password."\\n";
            } else {
                $valid = 0;
                $error_message .= "This phone number is not registered.\\n";
            }
        }
    }
}


?>


<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/<?php echo $banner_forget_password; ?>);">
    <div class="inner">
        <h1><?php echo LANG_VALUE_97; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <?php
                    if($error_message != '') {
                        echo "<script>alert('".$error_message."')</script>";
                    }
                    if($success_message != '') {
                        echo "<script>alert('".$success_message."')</script>";
                    }
                    ?>
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=""><?php echo "Phone Number"; ?> *</label>
                                    
                                    <!--
                                    <input type="email" class="form-control" name="cust_email">
                                    -->
                                    <div class="container">
                                      <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                          <div class="input-group" style="margin-top: 20px;">
                                            <span class="input-group-addon">
                                              <img src="https://upload.wikimedia.org/wikipedia/en/4/41/Flag_of_India.svg" alt="India Flag" style="width: 20px; height: 15px; margin-right: 5px;">
                                              +91
                                            </span>
                                            <input type="number" class="form-control" name="cust_phone" id="cust_phone" placeholder="Enter 10-digit phone number" maxlength="10" pattern="[6-9][0-9]{9}" title="Phone number must be exactly 10 digits and start with a number between 6 and 9" required oninput="validatePhone(this)">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <script>
                                    function validatePhone(input) {
                                        // Remove any non-numeric characters
                                        input.value = input.value.replace(/[^0-9]/g, '');
                                    
                                        // Ensure the first number is between 6 and 9
                                        if (input.value.length > 0 && !/^[6-9]/.test(input.value)) {
                                            input.value = input.value.substring(1); // Remove invalid first digit
                                        }
                                    }
                                    </script>

                                </div>
                               <div class="form-group ml-3 col-xs-12 col-sm-6">
                                    <button style="width:100px;" type="submit" class="btn btn-success" name="form1">
                                        <?php echo LANG_VALUE_4; ?>
                                    </button>
                                </div>

                                
                            </div>
                        </div >  
                        <p style="text-align:center;"><a href="login.php" style="color:#e4144d;"><?php echo LANG_VALUE_12; ?></a></p>                      
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>