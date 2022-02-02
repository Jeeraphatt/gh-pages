<script>
function addToMainCart(pdid){	
  var top = (screen.height/2)-(320/2)-50;
  var left = (screen.width/2)-(500/2);
  var stile = "top="+top+",left="+ left +", width=500, height=320, status=no, menubar=no, toolbar=no, scrollbar=no";
  var	apri = "include/miniCart.php";
   window.location.href = 'cart.php?action=add&p='+pdid;
   window.open(apri, "", stile);
}
</script>
<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$productsPerRow = 2;
$productsPerPage = 4;

//$productList    = getProductList($catId);
$children = array_merge(array($catId), getChildCategories(NULL, $catId));
$children = ' (' . implode(', ', $children) . ')';

$sql = "SELECT pd_id, pd_name, pd_price, pd_thumbnail, pd_qty, c.cat_id
		FROM tbl_product pd, tbl_category c
		WHERE pd.cat_id = c.cat_id AND pd.cat_id IN $children 
		ORDER BY pd_name";
$result     = dbQuery(getPagingQuery($sql, $productsPerPage));
$pagingLink = getPagingLink($sql, $productsPerPage, "c=$catId");
$numProduct = dbNumRows($result);

// the product images are arranged in a table. to make sure
// each image gets equal space set the cell width here
$columnWidth = (int)(100 / $productsPerRow);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="20">
<?php 
if ($numProduct > 0 ) {

	$i = 0;
	while ($row = dbFetchAssoc($result)) {
	
		extract($row);
		if ($pd_thumbnail) {
			$pd_thumbnail = WEB_ROOT . 'images/product/' . $pd_thumbnail;
		} else {
			$pd_thumbnail = WEB_ROOT . 'images/no-image-small.png';
		}
	
		if ($i % $productsPerRow == 0) {
			echo '<tr>';
		}

		// format how we display the price
		$pd_price = displayAmount($pd_price);
		$cart_url = "cart.php?action=add&p=$pd_id";
		
		// if the product is no longer in stock, ปุ่มเพิ่มสินค้าจะใช้ไม่ได้
		$disabledStr = '';
		if ($pd_qty <= 0) {
			$disabledStr = 'disabled = \"disabled\"';
		}
	
		echo "<td width=\"$columnWidth%\" align=\"center\"><a href=\"" . $_SERVER['PHP_SELF'] . "?c=$catId&p=$pd_id" . "\"><img src=\"$pd_thumbnail\" border=\"0\">
		<br>$pd_name</a>&nbsp;<input type=\"button\" name=\"btnAddToCart\" value=\"ใส่ตะกร้า\" onClick=\"addToMainCart(".$pd_id.")\" class=\"addToCartButton\"".$disabledStr.">
		<br>ราคา : $pd_price";




		// if the product is no longer in stock, tell the customer
		if ($pd_qty <= 0) {
			echo "<br><span style='color:red;'>สินค้าหมด</span>";
		}
		
		echo "</td>\r\n";
	
		if ($i % $productsPerRow == $productsPerRow - 1) {
			echo '</tr>';
		}
		
		$i += 1;
	}
	
	if ($i % $productsPerRow > 0) {
		echo '<td colspan="' . ($productsPerRow - ($i % $productsPerRow)) . '">&nbsp;</td>';
	}
	
} else {
?>
	<tr><td width="100%" align="center" valign="center">No products in this category</td></tr>
<?php	
}	
?>
</table>
<p align="center"><?php echo $pagingLink; ?></p>