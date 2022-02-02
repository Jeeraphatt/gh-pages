<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$product = getProductDetail($pdId, $catId);

// we have $pd_name, $pd_price, $pd_description, $pd_image, $cart_url
extract($product);
?> 

<script>
function addToMainCart(pdid){	
  var top = (screen.height/2)-(320/2)-50;
  var left = (screen.width/2)-(500/2);
  var stile = "top="+top+",left="+ left +", width=500, height=320";
  var	apri = "include/miniCart.php";
   window.location.href = 'cart.php?action=add&p='+pdid;
   window.open(apri, "", stile);
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="10">
 <tr> 
  <td align="center"><img src="<?php echo $pd_image; ?>" border="0" alt="<?php echo $pd_name; ?>"></td>
  <td valign="middle">
<strong><?php echo $pd_name; ?></strong><br>
ราคา : <?php echo displayAmount($pd_price); ?>  บาท<br>
<?php
// if we still have this product in stock
// show the 'Add to cart' button
if ($pd_qty > 0) {
?>
<input type="button" name="btnAddToCart" value="ใส่ตะกร้า" onClick="addToMainCart(<?php echo $pdId;?>)" class="addToCartButton">
<?php
} else {
	echo 'Out Of Stock';
}
?>
  </td>
 </tr>
 <tr align="left"> 
  <td colspan="2"><?php echo $pd_description; ?></td>
 </tr>
</table>
