<?php require_once('header.php'); ?>

<?php
// Check if the customer is logged in or not
if(!isset($_SESSION['customer'])) {
    header('location: '.BASE_URL.'logout.php');
    exit;
} else {
    // If customer is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=? AND cust_status=?");
    $statement->execute(array($_SESSION['customer']['cust_id'],0));
    $total = $statement->rowCount();
    if($total) {
        header('location: '.BASE_URL.'logout.php');
        exit;
    }
}
?>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php require_once('customer-sidebar.php'); ?>
            </div>
            <div class="col-md-12">
                <div class="user-content">
                    <h3><?php echo LANG_VALUE_25; ?></h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr style="font-size:16px; background-color:black; color:white;">
                                    <!--
                                    <th><?php echo LANG_VALUE_7; ?></th>
                                    -->
                                    <th><?php echo "Order Status"; ?></th>
                                    <th><?php echo LANG_VALUE_48; ?></th>
                                    <th><?php echo "Order Date & Time"; ?></th>
                                    <th><?php echo LANG_VALUE_28; ?></th>
                                    <th><?php echo "Amount"; ?></th>
                                    <th><?php echo LANG_VALUE_30; ?></th>
                                    <th><?php echo "Payment Mode"; ?></th>
                                    <th><?php echo LANG_VALUE_32; ?></th>
                                </tr>
                            </thead>
                            <tbody>


            <?php
            /* ===================== Pagination Code Starts ================== */
            $adjacents = 5;

            $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_id=? ORDER BY id DESC");
            $statement->execute(array($_SESSION['customer']['cust_id']));
            $total_pages = $statement->rowCount();

            $targetpage = BASE_URL.'customer-order.php';
            $limit = 10;
            $page = @$_GET['page'];
            if($page) 
                $start = ($page - 1) * $limit;
            else
                $start = 0;
            
            
            $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_id=? ORDER BY id DESC LIMIT $start, $limit");
            $statement->execute(array($_SESSION['customer']['cust_id']));
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
           
            
            if ($page == 0) $page = 1;
            $prev = $page - 1;
            $next = $page + 1;
            $lastpage = ceil($total_pages/$limit);
            $lpm1 = $lastpage - 1;   
            $pagination = "";
            if($lastpage > 1)
            {   
                $pagination .= "<div class=\"pagination\">";
                if ($page > 1) 
                    $pagination.= "<a href=\"$targetpage?page=$prev\">&#171; previous</a>";
                else
                    $pagination.= "<span class=\"disabled\">&#171; previous</span>";    
                if ($lastpage < 7 + ($adjacents * 2))
                {   
                    for ($counter = 1; $counter <= $lastpage; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= "<span class=\"current\">$counter</span>";
                        else
                            $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                    }
                }
                elseif($lastpage > 5 + ($adjacents * 2))
                {
                    if($page < 1 + ($adjacents * 2))        
                    {
                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                        }
                        $pagination.= "...";
                        $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
                        $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
                    }
                    elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                    {
                        $pagination.= "<a href=\"$targetpage?page=1\">1</a>";
                        $pagination.= "<a href=\"$targetpage?page=2\">2</a>";
                        $pagination.= "...";
                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                        }
                        $pagination.= "...";
                        $pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
                        $pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";       
                    }
                    else
                    {
                        $pagination.= "<a href=\"$targetpage?page=1\">1</a>";
                        $pagination.= "<a href=\"$targetpage?page=2\">2</a>";
                        $pagination.= "...";
                        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                        {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";                 
                        }
                    }
                }
                if ($page < $counter - 1) 
                    $pagination.= "<a href=\"$targetpage?page=$next\">next &#187;</a>";
                else
                    $pagination.= "<span class=\"disabled\">next &#187;</span>";
                $pagination.= "</div>\n";       
            }
            /* ===================== Pagination Code Ends ================== */
            ?>


                                <?php
                                $tip = $page*10-10;
                                foreach ($result as $row) {
                                    $tip++;
                                    ?>
                                    <tr>
                                        <!--
                                        <td><?php echo $tip; ?></td>
                                         -->
                                        <td style="background-color:#11619e;">
                                            <span style="background-color:yellow; font-size:15px"><b>Status: </b><br><?php echo $row['order_status']; ?><br>
                                            <span style="background-color:yellow; font-size:15px"><b>Deliver Within:</b><br> <?php echo $row['order_status']; ?></span><br>
                                           <span style="background-color:yellow; font-size:15px"><b>Deliver Partner Name:</b><br> <?php echo $row['order_status']; ?></span><br>
                                           <span style="background-color:yellow; font-size:15px"><b>Contact No:</b><br>
                                           <a href="tel:<?php echo htmlspecialchars($row['phone_no']); ?>"><?php echo htmlspecialchars($row['phone_no']); ?></a></span><br>
                                        </td>
                                        <!-- Order Status need to fatch from database Nur -->
                                       <td style="background-color:#8c7620; color:white;">
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                                            $statement1->execute(array($row['payment_id']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            
                                            foreach ($result1 as $row1) {
                                                // Now fetch the corresponding product image
                                                $statement2 = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
                                                $statement2->execute(array($row1['product_id']));
                                                $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                                                
                                                foreach ($result2 as $row2) {
                                                    // Assuming 'p_featured_photo' contains the filename or path to the image
                                                    $imagePath = 'assets/uploads/' . $row2['p_featured_photo']; // Update the path as per your directory structure
                                                    echo '<img src="' . $imagePath . '" alt="Product Image" style="max-width: 150px; height: auto; border: 2px solid #ccc; padding: 5px; border-radius: 10px;">';
                                                    echo '<br><br>';
                                                    
                                                echo '<b>Product Name:</b><br><span style="color:black; background-color:yellow;">' . $row1['product_name'].'</span>';
                                                echo '<br><b>Size: </b>' . $row1['size'];
                                                echo '<br><b>Color: </b>' . $row1['color'];
                                                echo '<br><b>Quantity: </b>' . $row1['quantity'];
                                                echo '<br><b>Unit Price: </b>' . $row1['unit_price'];
                                                echo '<br><br>';
                                                }
                                            }
                                            ?>
                                        </td>


                                        <td><?php echo $row['payment_date']; ?></td>
                                        <td><?php echo $row['txnid']; ?></td>
                                        <td><?php echo $row['paid_amount']; ?></td>
                                        <td><?php echo $row['payment_status']; ?></td>
                                        <td><?php echo $row['payment_method']; ?></td>
                                        <td><?php echo $row['payment_id']; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>                               
                                
                            </tbody>
                        </table>
                        <div class="pagination" style="overflow: hidden;">
                        <?php 
                            echo $pagination; 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('view_product.php'); ?>
<?php require_once('footer.php'); ?>