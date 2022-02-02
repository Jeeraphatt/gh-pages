<?php

require_once '../library/config.php';
require_once '../library/cart-functions.php';

if (!defined('WEB_ROOT')) {
	exit;
}

$cartContent = getMiniCartContent();

$numItem = count($cartContent);	
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
    <link href="../include/shop.css" rel="stylesheet" type="text/css">
	<script language="JavaScript" type="text/javascript" src="../library/common.js"></script>
    <script>
     	function gotoURL(url){
     		var parent = window.opener;
			parent.location = url;
			window.close(); 
    	 }
</script>
</head>
<body>

<?php
if(@count($_SESSION['plaincart_error'])==0){
 
	if ($numItem > 0) {
?>

<?php
		$subTotal = 0;
		extract($cartContent[0]);
		$url = "index.php?c=$cat_id&p=$pd_id";
		$subTotal = $pd_price * $ct_qty;

?>
<img src="<?php echo $pd_thumbnail; ?>" style="float:left;padding:10px;">
ได้เพิ่มสินค้า :  <span style="color:red;font-size:2em;"><?php echo $pd_name; ?></span> 
<br>ลงในตะกร้าเรียบร้อยแล้ว
<br>
<div style="clear:both;float:left">
<table width="80%" border="1" cellspacing="0" cellpadding="2" id="minicart">
 <tr>
  <td>ราคา</td>
  <td>จำนวน</td>
  <td>รวม</td>
 </tr>
 <tr>
   <td><?php echo $pd_price; ?></td>
   <td><?php echo $ct_qty; ?></td>
  <td width="30%" align="right"><?php echo displayAmount($ct_qty * $pd_price); ?></td>
 </tr>
   
<?php	
	} else {
?>
  <tr><td colspan="4" align="center" valign="middle">Shopping Cart Is Empty</td></tr>
<?php
	}
?> 
</table>
<?php
} else {
	displayError();
}
?>


<?php 
$shoppingReturnUrl = isset($_SESSION['shop_return_url']) ? $_SESSION['shop_return_url'] : 'index.php';
?>
<br>
<button onclick="gotoURL('<?php echo $shoppingReturnUrl; ?>')" class="box" id="goShoppingBtn">ชอปปิ้งต่อ</button>
<button onclick="gotoURL('../cart.php?action=view')" class="box" id="goToCartBtn">เช็คเอาท์</button>

</div>
</body>
</html>