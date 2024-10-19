<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}
?>

<?php
if(!isset($_SESSION['cart_p_id'])) {
    header('location: cart.php');
    exit;
}
?>
<!--
<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_checkout; ?>); height:20vh; ">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1><?php echo LANG_VALUE_22; ?></h1>
    </div>
</div>
-->
<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                
                
                <?php if(!isset($_SESSION['customer'])): ?>
                    <!--
                    <p>
                        <a href="login.php" class="btn btn-md btn-danger"><?php echo LANG_VALUE_160; ?></a>
                    </p>
                    --><?php
                    header("location: login.php");?>
                <?php else: ?>

                <h3 style="color : red ;font-size:35px;"class="special"><?php echo LANG_VALUE_26; ?></h3>
            
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="success">
                            <th><?php echo "Action"; ?></th>
                            <th><?php echo LANG_VALUE_8; ?></th>
                            <th><?php echo LANG_VALUE_47; ?></th>
                            <th><?php echo LANG_VALUE_157; ?></th>
                            <th><?php echo LANG_VALUE_158; ?></th>
                            <th><?php echo LANG_VALUE_159; ?></th>
                            <th><?php echo LANG_VALUE_55; ?></th>
                            <th class="text-right"><?php echo LANG_VALUE_82; ?></th>
                        </tr>
                        </thead>
                         <?php
                        $table_total_price = 0;

                        $i=0;
                        foreach($_SESSION['cart_p_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_qty'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_qty[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_current_price'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_current_price[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_featured_photo'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_featured_photo[$i] = $value;
                        }
                        ?>
                        <?php for($i=1;$i<=count($arr_cart_p_id);$i++): ?>
                        <tr>
                            <!--
                            <td><?php echo $i; ?></td>
                            -->
                            <td class="text-center">
                                <a onclick="return confirmDelete();" href="cart-item-delete.php?id=<?php echo $arr_cart_p_id[$i]; ?>&size=<?php echo $arr_cart_size_id[$i]; ?>&color=<?php echo $arr_cart_color_id[$i]; ?>" class="trash"><i class="fa fa-trash"></i></a>
                            </td>
                            <td>
                                <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="" style="width:100px; height:70px;">
                            </td>
                            <td><?php echo $arr_cart_p_name[$i]; ?></td>
                            <td><?php echo $arr_cart_size_name[$i]; ?></td>
                            <td><?php echo $arr_cart_color_name[$i]; ?></td>
                            <td><?php echo LANG_VALUE_1; ?><?php echo $arr_cart_p_current_price[$i]; ?></td>
                            <td><?php echo $arr_cart_p_qty[$i]; ?></td>
                            <td class="text-right">
                                <?php
                                $row_total_price = $arr_cart_p_current_price[$i]*$arr_cart_p_qty[$i];
                                $table_total_price = $table_total_price + $row_total_price;
                                ?>
                                <?php echo LANG_VALUE_1; ?><?php echo $row_total_price; ?>
                            </td>
                        </tr>
                        <?php endfor; ?>           
                        <tr class="info">
                            <th colspan="2" class="total-text"><?php echo LANG_VALUE_81; ?></th>
                            <th class="total-amount"><?php echo LANG_VALUE_1; ?><?php echo $table_total_price; ?></th>
                        </tr>
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
                        $statement->execute(array($_SESSION['customer']['cust_country']));
                        $total = $statement->rowCount();
                        if($total) {
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        } else {
                            $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                if($row_total_price<=15){
                                    $shipping_cost=5;
                                }
                                elseif($row_total_price>15 && $row_total_price<=30){
                                    $shipping_cost=10;
                                }
                                else{
                                $shipping_cost = $row['amount'];
                                }
                            }
                        }                        
                        ?>
                        <tr >
                            <td colspan="2" class="total-text"><?php echo "Delivery charges"; ?></td>
                            <td class="total-amount"><?php echo LANG_VALUE_1; ?><?php echo $shipping_cost; ?></td>
                        </tr>
                        <tr class="danger">
                            <th colspan="2" style="color:red; font-size:22px;background-color:yellow;" class="total-text"><?php echo LANG_VALUE_82; ?></th>
                            <th style="color:red; font-size:22px;background-color:yellow;" class="total-amount">
                                <?php
                                $final_total = $table_total_price+$shipping_cost;
                                ?>
                                <?php echo LANG_VALUE_1; ?><?php echo $final_total; ?>
                            </th>
                        </tr>
                    </table> 
                </div>

                	<div class="clear"></div>
                <h3 style="color: green" class="special"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i><?php echo " Select Payment Mode "; ?><i class="fa fa-arrow-down"></i></h3>

                <div class="billing-address">
                    <div class="row">
                       <!--  <div class="col-md-6">
                            
                           
                            <h3 class="special"><?php echo "LANG_VALUE_161"; ?></h3>
                            
                            
                            <table class="table table-responsive table-bordered bill-address">
                                <tr>
                                    <td><?php echo LANG_VALUE_102; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_name']; ?></p></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_103; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_cname']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_104; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_106; ?></td>
                                    <td>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                        $statement->execute(array($_SESSION['customer']['cust_b_country']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            echo $row['country_name'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_105; ?></td>
                                    <td>
                                        <?php echo nl2br($_SESSION['customer']['cust_b_address']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_107; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_city']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_108; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_state']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_109; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_b_zip']; ?></td>
                                </tr>                                
                            </table>
                        </div>
                        -->
                        
                        <div class="col-md-6">
                            
                            <table class="table table-responsive table-bordered bill-address">
                                <colgroup>
                                    <col style="width: 40%;">
                                    <col style="width: 60%;">
                                </colgroup>
                                <tr >
                                    <th colspan="2" class="success" style="text-align:center; font-size:30px;"><i class="fa fa-truck fa-2x" aria-hidden="true"></i> Delivery Address</th>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_102; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_name']; ?></p></td>
                                </tr>
                                
                                <!--
                                <tr>
                                    <td><?php echo "Your Name"; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_cname']; ?></td>
                                </tr>
                                -->
                                <tr>
                                    <td><?php echo "Your Number"; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo "Delivery Name"; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_name']; ?></p></td>
                                </tr>
                                <tr>
                                    <td><?php echo "Delivery Phone"; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo "Delivery Area"; ?></td>
                                    <td>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                        $statement->execute(array($_SESSION['customer']['cust_country']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            echo $row['country_name'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_105; ?></td>
                                    <td>
                                        <?php echo nl2br($_SESSION['customer']['cust_address']); ?>
                                    </td>
                                </tr>
                                
                                <!--
                                <tr>
                                    <td><?php echo LANG_VALUE_107; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_city']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_108; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_state']; ?></td>
                                </tr>
                                <tr>
                                    <td><?php echo LANG_VALUE_109; ?></td>
                                    <td><?php echo $_SESSION['customer']['cust_s_zip']; ?></td>
                                </tr>
                                --><tr>
                                    <td colspan="2"><a href="customer-billing-shipping-update.php" class="btn btn" style="width:100%;"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i><?php echo "Click here to edit the delivery address."; ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>                    
                </div>
               <!--
				<div class="clear"></div>
                <h3 style="color: green" class="special"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i><?php echo " Select Payment Mode "; ?><i class="fa fa-arrow-down"></i>
                </h3>
                -->
                <div class="row">
                    
                    	<?php
		                $checkout_access = 1;
		                if(
		                  /*
		                    ($_SESSION['customer']['cust_b_name']=='') ||
		                    ($_SESSION['customer']['cust_b_cname']=='') ||
		                    ($_SESSION['customer']['cust_b_phone']=='') ||
		                    ($_SESSION['customer']['cust_b_country']=='') ||
		                    ($_SESSION['customer']['cust_b_address']=='') ||
		                   // ($_SESSION['customer']['cust_b_city']=='') ||
		                    ($_SESSION['customer']['cust_b_state']=='') ||
		                    ($_SESSION['customer']['cust_b_zip']=='') || */
		                    ($_SESSION['customer']['cust_name']=='') ||
		                   // ($_SESSION['customer']['cust_s_cname']=='') ||
		                    ($_SESSION['customer']['cust_phone']=='') ||
		                    ($_SESSION['customer']['cust_country']=='') ||
		                    ($_SESSION['customer']['cust_address']=='')
		                   /*
		                    ($_SESSION['customer']['cust_s_city']=='') ||
		                    ($_SESSION['customer']['cust_s_state']=='') ||
		                    ($_SESSION['customer']['cust_s_zip']=='') */
		                ) {
		                    $checkout_access = 0;
		                }
		                ?>
		                <?php if($checkout_access == 0): ?>
		                	<div class="col-md-12">
				                <div style="color:red;font-size:22px;margin-bottom:50px;">
			                        You must have to fill up all the billing and shipping information from your dashboard panel in order to checkout the order. Please fill up the information going to <a href="customer-billing-shipping-update.php" style="color:red;text-decoration:underline;">this link</a>.
			                    </div>
	                    	</div>
	                	<?php else: ?>
	                	
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <!--
                                        <label for=""><?php echo LANG_VALUE_34; ?> *</label>
                                        -->
                                        <div>
                                            <!-- Replaced select with radio buttons -->
                                            <label>
                                                <h4 style="padding-left:50px;">
                                                    <input type="radio" name="payment_method" value="Bank Deposit" id="bank_deposit" class="larger-radio"><i style="padding-left:12px;" class="fa fa-money" style="font-size:30px"></i>
                                                    <?php echo "Cash on Delivery"; ?>
                                                </h4>
                                                <style>
                                                    .larger-radio {
                                                        width: 15px; /* You can adjust the width */
                                                        height: 15px; /* You can adjust the height */
                                                        transform: scale(1.5); /* Adjust the scaling factor to increase size */
                                                        -webkit-transform: scale(1.5); /* For Safari */
                                                        margin-right: 10px; /* Optional: adds space between the button and text */
                                                    }
                                                </style>

                                            </label><br>
                                            
                                            <!-- Paypal Option -->
                                            <label>
                                                <h4 style="padding-left:45px;">
                                                <!--
                                                <input type="radio" name="payment_method" value="PayPal" id="paypal" class="larger-radio"> 
                                                <?php echo LANG_VALUE_36; ?>
                                                -->
                                                <input type="radio" name="payment_method" value="PayPal" id="paypal" style="display:none;" class="larger-radio" disabled>
                                                <img src="image/unavailable.png" style="height:25px;width:auto;">
                                                <?php echo "  Pay via UPI App "; ?><span>(Unavailable)</span>
                                                </h4>
                                            </label>
                                        </div>
                                    </div>
                            
                                    <form class="paypal" action="<?php echo BASE_URL; ?>payment/paypal/payment_process.php" method="post" id="paypal_form" target="_blank" style="display:none;">
                                        <input type="hidden" name="cmd" value="_xclick" />
                                        <input type="hidden" name="no_note" value="1" />
                                        <input type="hidden" name="lc" value="UK" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                                        <input type="hidden" name="final_total" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_46; ?>" name="form1">
                                        </div>
                                    </form>
                            
                                    <form action="payment/bank/init.php" method="post" id="bank_form" style="display:none;">
                                        <input type="hidden" name="amount" value="<?php echo $final_total; ?>">
                                        <!--
                                        <div class="col-md-12 form-group">
                                            <label for=""><?php echo LANG_VALUE_43; ?></label><br>
                                            <?php
                                            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
                                            $statement->execute();
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $row) {
                                                echo nl2br($row['bank_detail']);
                                            }
                                            ?>
                                        </div>
                                        -->
                                        <div class="col-md-12 form-group">
                                            <!--
                                            <label for=""><?php echo LANG_VALUE_44; ?> <br><span style="font-size:12px;font-weight:normal;">(<?php echo LANG_VALUE_45; ?>)</span></label>
                                            -->
                                            
                                            <label for=""><?php echo "You can request extra Services.."; ?> 
                                                <br><span style="font-size:12px;font-weight:normal;"><?php echo "(Include water bottle, cold drinks, plates and others)"; ?></span>
                                            </label>
                                            <textarea name="transaction_info" id="transaction_info" class="form-control" cols="10" rows="2" placeholder="Ex: Packaged Water Bottle 1 Litre."></textarea>
                                            
                                            <!-- Assuming you have a submit button -->
                                            
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <button type="submit" name="form3" class="highlight-button" onclick="checkTextarea()">Conform Order</button>
                                            
                                            <script>
                                            function checkTextarea() {
                                                var textarea = document.getElementById('transaction_info');
                                                if (textarea.value.trim() === "") {
                                                    textarea.value = "Nill";
                                                }
                                            }
                                            </script>
                                            
                                            <style>
                                                .highlight-button {
                                                    width: 100%; height: 50px;
                                                    background-color: #28a745;
                                                    color: white;
                                                    border: none;
                                                    padding: 15px 30px;
                                                    font-size: 16px;
                                                    cursor: pointer;
                                                    border-radius: 5px;
                                                    transition: background-color 0.3s ease, transform 0.3s ease;
                                                }
                                                .highlight-button:hover {
                                                    background-color: #218838;
                                                    transform: scale(1.05);
                                                }
                                            </style>
                                        </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            // Add event listeners for the radio buttons to toggle form visibility
                            document.getElementById('paypal').addEventListener('change', function() {
                                document.getElementById('paypal_form').style.display = 'block';
                                document.getElementById('bank_form').style.display = 'none';
                            });
                        
                            document.getElementById('bank_deposit').addEventListener('change', function() {
                                document.getElementById('paypal_form').style.display = 'none';
                                document.getElementById('bank_form').style.display = 'block';
                            });
                        </script>

		                <?php endif; ?>
                        
                </div>
                

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>