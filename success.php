<?php
require_once 'library/config.php';

// if no order id defined in the session
// redirect to main page
if (!isset($_SESSION['orderId'])) {
	header('Location: ' . WEB_ROOT);
	exit;
}

$pageTitle   = 'Checkout Completed Successfully';
require_once 'include/header.php';


// send notification email
if ($shopConfig['sendOrderEmail'] == 'y') {
	$subject = "[New Order] " . $_SESSION['orderId'];
	$email   = $shopConfig['email'];
	$message = "You have a new order. Check the order detail here \n http://" . $_SERVER['HTTP_HOST'] . WEB_ROOT . 'admin/order/index.php?view=detail&oid=' . $_SESSION['orderId'] ;
	mail($email, $subject, $message, "From: $email\r\nReturn-path: $email");
}


unset($_SESSION['orderId']);
?>
<p>&nbsp;</p><table width="500" border="0" align="center" cellpadding="1" cellspacing="0">
   <tr> 
      <td align="left" valign="top" bgcolor="#333333"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
               <td align="center" bgcolor="#EEEEEE"> <p>&nbsp;</p>
                        <p>ขอขอบคุณ ที่ใช้บริการซื้อสินค้าจากทางร้าน เราจะจัดส่งสินค้าให้ท่านด่วนที่สุด หากต้องการซื้อสินค้าอื่นๆ ต่อกรุณา <a href="index.php">คลิกที่นี่ </a></p>
                  <p>&nbsp;</p></td>
            </tr>
         </table></td>
   </tr>
</table>
<br>
<br>
<?php
require_once 'include/footer.php';
?>