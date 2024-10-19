<?php require_once('header.php'); ?>

<div class="page">
    <div class="container">
        <div class="row">            
            <div class="col-md-12">
                <p>
                    <h2 style="text-align:center;"><img src="image/success.gif" alt="Description of the GIF" width="250" height="230"></h2>
                    <!--
                    <h2 style="margin-top:10px; text-align:center;"><i class="fa fa-check fa-5x success animated-icon"></i></h2>
                    -->
                    <h2 style="text-align:center;" class="success animated-icon">Order successful...</h2>
                    
                    <audio id="successAudio" autoplay>
                            <source src="audio/success_alert2.mp3" type="audio/mpeg">
                            Your browser does not support the audio element.
                    </audio>
                    
                         <style>
                        /* Define the keyframes for the size animation */
                        @keyframes iconZoom {
                            0% {
                                transform: scale(0.0); /* Small size */
                            }
                            100% {
                                transform: scale(1); /* Full size */
                            }
                        }
                        
                        /* Apply the animation to the icon */
                        .animated-icon {
                            animation: iconZoom 1s ease-in-out; /* Animation duration and easing */
                        }
                        
                        </style>

                   
                    <br><br>
                </p>
            </div>
        </div>
    </div>
</div>

<p style="text-align:right; "><a href="customer-order.php" class="btn btn-primary"><?php echo "Check Order Status!"; ?></a></p>

<?php require_once('view_product.php'); ?>
<?php require_once('footer.php'); ?>