<?php
require_once 'library/config.php';
require_once 'library/cart-functions.php';
$successAdd = '';
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : 'view';
if( isset($_POST['btnUpdate'])){
	$action = 'update';
}
switch ($action) {
	case 'add' :
		addToCart();
		echo "<script>alert('".$_SESSION['showCartStatus']."')<script>";
		break;
	case 'update' :
		updateCart();
		break;	
	case 'delete' :
		deleteFromCart();
		break;
	case 'view' :
}

$cartContent = getCartContent();
$numItem = count($cartContent);

$pageTitle = 'Shopping Cart';
require_once 'include/header.php';

// show the error message ( if we have any )
displayError();

if ($numItem > 0 ) {
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ; ?>" method="post" name="frmCart" id="frmCart">
 <table width="780" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr class="entryTableHeader"> 
   <td colspan="2" align="center">รายการ</td>
   <td align="center">ราคา</td>
   <td width="75" align="center">จำนวน</td>
   <td align="center">รวม</td>
  <td width="75" align="center">&nbsp;</td>
 </tr>
 <?php
$subTotal = 0;
for ($i = 0; $i < $numItem; $i++) {
	extract($cartContent[$i]);
	$productUrl = "index.php?c=$cat_id&p=$pd_id";
	$subTotal += $pd_price * $ct_qty;
?>
 <tr class="content"> 
  <td width="80" align="center"><a href="<?php echo $productUrl; ?>"><img src="<?php echo $pd_thumbnail; ?>" border="0"></a></td>
  <td><a href="<?php echo $productUrl; ?>"><?php echo $pd_name; ?></a></td>
   <td align="right"><?php echo displayAmount($pd_price); ?></td>
  <td width="75"><input name="txtQty[]" type="text" id="txtQty[]" size="5" value="<?php echo $ct_qty; ?>" class="box" onKeyUp="checkNumber(this);">
  <input name="hidCartId[]" type="hidden" value="<?php echo $ct_id; ?>">
  <input name="hidProductId[]" type="hidden" value="<?php echo $pd_id; ?>">
  </td>
  <td align="right"><?php echo displayAmount($pd_price * $ct_qty); ?></td>
  <td width="75" align="center"> <input name="btnDelete" type="button" id="btnDelete" value="&nbsp;ลบ&nbsp;" onClick="window.location.href='<?php echo $_SERVER['PHP_SELF'] . "?action=delete&cid=$ct_id"; ?>';" class="box"> 
  </td>
 </tr>
 <?php
}
?>
 <tr class="content"> 
  <td colspan="4" align="right">รวมย่อย</td>
  <td align="right"><?php echo displayAmount($subTotal); ?></td>
  <td width="75" align="center">&nbsp;</td>
 </tr>
<tr class="content"> 
   <td colspan="4" align="right">ค่าจัดส่ง </td>
  <td align="right"><?php echo displayAmount($shopConfig['shippingCost']); ?></td>
  <td width="75" align="center">&nbsp;</td>
 </tr>
<tr class="content"> 
   <td colspan="4" align="right">รวมสุทธิ </td>
  <td align="right"><?php echo displayAmount($subTotal + $shopConfig['shippingCost']); ?></td>
  <td width="75" align="center">&nbsp;</td>
 </tr>  
 <tr class="content"> 
  <td colspan="5" align="right">&nbsp;</td>
  <td width="75" align="center">
<input name="btnUpdate" type="submit" id="btnUpdate" value="อัพเดท" class="box"></td>
 </tr>
</table>
</form>
<?php
} else {
	
?>
<p>&nbsp;</p><table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
 <tr>
  <td><p align="center">ตะกร้าสินค้าว่างเปล่า</p>
   <p>ถ้าคุณพบว่าไม่สามารถใส่สินค้าลงในตะกร้าได้ กรุณาตรวจสอบว่าบราวเซอร์ของคุณได้อนุญาตให้ใช้งาน cookies หรือมีโปรแกรมรักษาความปลอดภัยอื่นๆ ได้บล็อคการใช้งาน session เอาไว้.</p></td>
 </tr>
</table>
<?php
}

$shoppingReturnUrl = isset($_SESSION['shop_return_url']) ? $_SESSION['shop_return_url'] : 'index.php';
?>
<table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
 <tr align="center"> 
  <td><input name="btnContinue" type="button" id="btnContinue" value="&lt;&lt; ช็อปปิ้งต่อ" onClick="window.location.href='<?php echo $shoppingReturnUrl; ?>';" class="box"></td>
<?php 
if ($numItem > 0) {
?>  
  <td><input name="btnCheckout" type="button" id="btnCheckout" value="เช็คเอ้าท์ &gt;&gt;" onClick="checkOutCart()" class="box"></td>
<?php
}
?>  
 </tr>
</table>
<?php
require_once 'include/footer.php';
?>
<script>
function checkOutCart(){
	//สั่งให้อัพเดทตะกร้าสินค้าก่อน จะได้ตรวจสอบว่ามีการสั่งซื้อเกินจำนวนสต๊อคหรือไม่
	document.getElementById('btnUpdate').click();
	//เข้าสู่กระบวนการเช็คเอาท์ขั้นตอนแรก
	
	window.location.href='checkout.php?step=1';
}
</script>
