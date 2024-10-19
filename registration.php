<?php require_once('header.php'); ?>
<?php
session_start(); // Start the session to store user login details

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_registration = $row['banner_registration'];
}

if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    if(empty($_POST['cust_name'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_123."<br>";
    }

    if(empty($_POST['cust_email'])) {
        $valid = 1;
    } else {
        if (filter_var($_POST['cust_email'], FILTER_VALIDATE_EMAIL) === false) {
            $valid = 0;
            $error_message .= LANG_VALUE_134."<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
            $statement->execute(array($_POST['cust_email']));
            $total = $statement->rowCount();                            
            if($total) {
                $valid = 0;
                $error_message .= LANG_VALUE_147."<br>";
            }
        }
    }

    if(empty($_POST['cust_phone'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_124 . "<br>";
    } else {
        if (!preg_match('/^[1-9][0-9]{9}$/', $_POST['cust_phone'])) {
            $valid = 0;
            $error_message .= LANG_VALUE_134 . "<br>";
        } else {
            $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_phone=?");
            $statement->execute(array($_POST['cust_phone']));
            $total = $statement->rowCount();                            
            if($total) {
                $valid = 0;
                $error_message .= "Your number is already registered.<br>";
                $error_message .= '<a href="login.php" class="btn btn-primary">Login</a><br>';
            }
        }
    }

    if(empty($_POST['cust_address'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_125."<br>";
    }

    if(empty($_POST['cust_country'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_126."<br>";
    }

    if(empty($_POST['cust_password']) || empty($_POST['cust_re_password'])) {
        $valid = 0;
        $error_message .= LANG_VALUE_138."<br>";
    }

    if(!empty($_POST['cust_password']) && !empty($_POST['cust_re_password'])) {
        if($_POST['cust_password'] != $_POST['cust_re_password']) {
            $valid = 0;
            $error_message .= LANG_VALUE_139."<br>";
        }
    }

    if($valid == 1) {
        $token = md5(time());
        $cust_datetime = date('Y-m-d h:i:s');
        $cust_timestamp = time();

        // Save into the database
        $statement = $pdo->prepare("INSERT INTO tbl_customer (
                                        cust_name,
                                        cust_cname,
                                        cust_email,
                                        cust_phone,
                                        cust_country,
                                        cust_address,
                                        cust_city,
                                        cust_state,
                                        cust_zip,
                                        cust_b_name,
                                        cust_b_cname,
                                        cust_b_phone,
                                        cust_b_country,
                                        cust_b_address,
                                        cust_b_city,
                                        cust_b_state,
                                        cust_b_zip,
                                        cust_s_name,
                                        cust_s_cname,
                                        cust_s_phone,
                                        cust_s_country,
                                        cust_s_address,
                                        cust_s_city,
                                        cust_s_state,
                                        cust_s_zip,
                                        cust_password,
                                        cust_token,
                                        cust_datetime,
                                        cust_timestamp,
                                        cust_status
                                    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $statement->execute(array(
            strip_tags($_POST['cust_name']),
            '',
            strip_tags($_POST['cust_email']),
            strip_tags($_POST['cust_phone']),
            strip_tags($_POST['cust_country']),
            strip_tags($_POST['cust_address']),
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $_POST['cust_password'],
            $token,
            $cust_datetime,
            $cust_timestamp,
            1
        ));

        // Auto-login process after successful registration
        $cust_id = $pdo->lastInsertId(); // Get the ID of the newly inserted user
        $_SESSION['customer_id'] = $cust_id;
        $_SESSION['customer_name'] = $_POST['cust_name'];
        $_SESSION['customer_email'] = $_POST['cust_email'];
        $_SESSION['customer_phone'] = $_POST['cust_phone'];

        // Redirect the user to the dashboard or another page
        header('Location: '.BASE_URL.'dashboard.php');
        exit();
    }
}
?>

<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/<?php echo $banner_registration; ?>);">
    <div class="inner">
        <h1><?php echo LANG_VALUE_16; ?></h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="user-content">
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>

                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_102; ?> *</label>
                                    <input type="text" class="form-control" name="cust_name" value="<?php if(isset($_POST['cust_name'])){echo $_POST['cust_name'];} ?>">
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_104; ?> *</label>
                                    <input type="tel" class="form-control" name="cust_phone" 
                                           value="<?php if(isset($_POST['cust_phone'])){echo $_POST['cust_phone'];} ?>" 
                                           pattern="[1-9][0-9]{9}" 
                                           maxlength="10" 
                                           title="Please enter a 10-digit phone number that doesn't start with 0" 
                                           required>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for=""><?php echo LANG_VALUE_105; ?> *</label>
                                    <textarea name="cust_address" class="form-control" cols="30" rows="10" style="height:70px;"><?php if(isset($_POST['cust_address'])){echo $_POST['cust_address'];} ?></textarea>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo "Your Area"; ?> *</label>
                                    <select name="cust_country" class="form-control select2">
                                        <option value="">Select Your Area</option>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country ORDER BY country_name ASC");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                                        foreach ($result as $row) {
                                            echo '<option value="'.$row['country_id'].'">'.$row['country_name'].'</option>';
                                        }
                                        ?>    
                                    </select>                                    
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_96; ?> *</label>
                                    <input type="password" class="form-control" name="cust_password">
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for=""><?php echo LANG_VALUE_98; ?> *</label>
                                    <input type="password" class="form-control" name="cust_re_password">
                                </div>

                                <div class="col-md-6 form-group">
                                    <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_15; ?>" name="form1">
                                </div>
                            </div>
                        </div> 
                    </form>
                    <br><br>
                    <h2><a href="login.php">Click Here </a> Back to Login Page..</h2>
                </div>                
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>