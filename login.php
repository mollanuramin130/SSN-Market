<?php require_once('header.php'); ?>
<!-- fetching row banner login -->
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_login = $row['banner_login'];
}
?>
<!-- //login form -->
<?php
if(isset($_POST['form1'])) {
        
    if(empty($_POST['cust_phone']) || empty($_POST['cust_password'])) {
        $error_message = LANG_VALUE_132.'<br>';
    } else {
        
        $cust_phone = strip_tags($_POST['cust_phone']);
        $cust_password = strip_tags($_POST['cust_password']);

        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_phone=?");
        $statement->execute(array($cust_phone));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $cust_status = $row['cust_status'];
            $row_password = $row['cust_password'];
        }

        if($total == 0) {
            $error_message .= $cust_phone .'<br>This mobile number is not registered. <br><br><a href="registration.php" class="btn btn-info">Click here to register</a><br>';
        }
        else {
            //using MD5 form
            if( $row_password != $cust_password ) {
                $error_message .= LANG_VALUE_139.'<br>';
            } else {
                if($cust_status == 0) {
                    $error_message .= LANG_VALUE_148.'<br>';
                } else {
                    $_SESSION['customer'] = $row;

                   header("location: ".BASE_URL."checkout.php");
                   //header("location: https://ssnmarket.com");

                }
            }
            
        }
    }
}
?>

<div class="page-banner" style="background-color:#444;background-image: url(assets/uploads/<?php echo $banner_login; ?>);">
    <div class="inner">
        <h1><?php echo LANG_VALUE_10; ?></h1>
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
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <?php
                                if($error_message != '') {
                                    echo "<div class='error' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$error_message."</div>";
                                }
                                if($success_message != '') {
                                    echo "<div class='success' style='padding: 10px;background:#f1f1f1;margin-bottom:20px;'>".$success_message."</div>";
                                }
                                ?>
                                <!--
                                <div class="form-group">
                                    <label for=""><?php echo "Mobile Number"; ?> *</label>
                                    <input type="tel" class="form-control" name="cust_phone">
                                </div>
                                -->
                                <div class="form-group">
                                    <label for=""><?php echo "Mobile Number"; ?> *</label>
                                    <input type="tel" class="form-control" name="cust_phone" 
                                    value="<?php if(isset($_POST['cust_phone'])){echo $_POST['cust_phone'];} ?>" 
                                    pattern="[1-9][0-9]{9}" 
                                    maxlength="10" 
                                    title="Please enter a 10-digit phone number that doesn't start with 0" 
                                    required>
                                </div>

                                <div class="form-group">
                                    <label for=""><?php echo LANG_VALUE_96; ?> *</label>
                                    <input type="password" class="form-control" name="cust_password">
                                </div>
                                <div class="form-group">
                                    <label for=""></label>
                                    <input type="submit" class="btn btn-primary" style="width:100% " value="<?php echo "Login"; ?>" name="form1">
                                    
                                </div>
                                <a href="forget-password.php" style="color:#e4144d;"><?php echo LANG_VALUE_97; ?></a>
                                <br>
                                <br>
                                <h2>New User Click Here to Register</h2>
                              
                                <div class="item-box text-right">
                                    <ul><a href="registration.php" style="width:50% " class="btn btn-warning">Register</a></ul>
                                </div>
                                
                            </div>
                        </div>                        
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>