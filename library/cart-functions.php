<?php
require_once 'config.php';

/*********************************************************
*                 SHOPPING CART FUNCTIONS 
*********************************************************/
 
function addToCart()
{
	$currentStock = 0;
	//แสดงข้อความเมื่อใส่ของในตะกร้าได้ ตอนแรกต้องยังไม่มีข้อความใดๆ
	if(isset($_SESSION['showCartStatus'])){
		 unset($_SESSION['showCartStatus']);
	}
	// make sure the product id exist
	if (isset($_GET['p']) && (int)$_GET['p'] > 0) {
		$productId = (int)$_GET['p'];
	} else {
		header('Location: index.php');
	}
	
	// does the product exist ?
	$sql = "SELECT pd_id, pd_qty
	        FROM tbl_product
			WHERE pd_id = $productId";
	$result = dbQuery($sql);
	
	if (dbNumRows($result) != 1) {
		// the product doesn't exist
		header('Location: cart.php');
	} else {
		// how many of this product we
		// have in stock
		$row = dbFetchAssoc($result);
		$currentStock = $row['pd_qty'];

		if ($currentStock == 0) {
			// we no longer have this product in stock
			// show the error message
			setError('ขออภัย สินค้าที่คุณเลือก ในตอนนี้ยังไม่มีในสต๊อค');
			header('Location: cart.php');
			exit;
		}
		

	}		
	
	
	
	// current session id
	$sid = session_id();
	
	// check if the product is already
	// in cart table for this session
	$sql = "SELECT pd_id, ct_qty
	        FROM tbl_cart
			WHERE pd_id = $productId AND ct_session_id = '$sid'";
	$result = dbQuery($sql);
	$rowCart = dbFetchAssoc($result);
	if (dbNumRows($result) == 0) {
		// put the product in cart table
		$sql = "INSERT INTO tbl_cart (pd_id, ct_qty, ct_session_id, ct_date)
				VALUES ($productId, 1, '$sid', NOW())";
		$result = dbQuery($sql);
	} else if (dbNumRows($result) == 1) {
		if(($rowCart['ct_qty'] + 1)<= $currentStock){
		// update product quantity in cart table
			$sql = "UPDATE tbl_cart 
		        SET ct_qty = ct_qty + 1, ct_date = NOW()
				WHERE ct_session_id = '$sid' AND pd_id = $productId";		
				
			$result = dbQuery($sql);	
		}else {
			//แก้ไขเวลา เพื่อให้สามารถเลือกสินค้าล่าสุดมาแสดงในตะกร้า
			$sql = "UPDATE tbl_cart 
		        SET ct_date = NOW()
				WHERE ct_session_id = '$sid' AND pd_id = $productId";		
			$result = dbQuery($sql);	
			
			setError('ขออภัย สินค้าที่คุณเพิ่ม เกินจำนวนที่มีอยู่ในสต๊อค');
			header('Location: cart.php');
			exit;
		}
	}	
	//$_SESSION['showCartStatus'] = 'เพิ่มสินค้าในตะกร้าเรียบร้อยแล้ว';	
	// an extra job for us here is to remove abandoned carts.
	// right now the best option is to call this function here
	deleteAbandonedCart();
	
	header('Location: ' . $_SESSION['shop_return_url']);				
}

/*
	Get all item in current session
	from shopping cart table
*/
function getCartContent()
{
	$cartContent = array();

	$sid = session_id();
	$sql = "SELECT ct_id, ct.pd_id, ct_qty, pd_name, pd_price, pd_thumbnail, pd.cat_id
			FROM tbl_cart ct, tbl_product pd, tbl_category cat
			WHERE ct_session_id = '$sid' AND ct.pd_id = pd.pd_id AND cat.cat_id = pd.cat_id";
	
	$result = dbQuery($sql);
	
	while ($row = dbFetchAssoc($result)) {
		if ($row['pd_thumbnail']) {
			$row['pd_thumbnail'] = WEB_ROOT . 'images/product/' . $row['pd_thumbnail'];
		} else {
			$row['pd_thumbnail'] = WEB_ROOT . 'images/no-image-small.png';
		}
		$cartContent[] = $row;
	}
	
	return $cartContent;
}

function getMiniCartContent()
{
	$cartContent = array();
	//เลือกรายการสินค้าที่เพิ่งแก้ไขล่าสุดจากตาราง tbl_cart
	$sid = session_id();
	$sql = "SELECT ct_id, ct.pd_id, ct_qty, pd_name, pd_price, pd_thumbnail, pd.cat_id, ct_date
			FROM tbl_cart ct, tbl_product pd, tbl_category cat
			WHERE ct_session_id = '$sid' AND ct.pd_id = pd.pd_id AND cat.cat_id = pd.cat_id ORDER BY ct_date DESC  LIMIT 1";
	
	$result = dbQuery($sql);
	
	while ($row = dbFetchAssoc($result)) {
		if ($row['pd_thumbnail']) {
			$row['pd_thumbnail'] = WEB_ROOT . 'images/product/' . $row['pd_thumbnail'];
		} else {
			$row['pd_thumbnail'] = WEB_ROOT . 'images/no-image-small.png';
		}
		$cartContent[] = $row;
	}
	
	return $cartContent;
}


/*
	Remove an item from the cart
*/
function deleteFromCart($cartId = 0)
{
	if (!$cartId && isset($_GET['cid']) && (int)$_GET['cid'] > 0) {
		$cartId = (int)$_GET['cid'];
	}

	if ($cartId) {	
		$sql  = "DELETE FROM tbl_cart
				 WHERE ct_id = $cartId";

		$result = dbQuery($sql);
	}
	
	header('Location: cart.php');	
}

/*
	Update item quantity in shopping cart
*/
function updateCart()
{
	$cartId     = $_POST['hidCartId'];
	$productId  = $_POST['hidProductId'];
	$itemQty    = $_POST['txtQty'];
	$numItem    = count($itemQty);
	$numDeleted = 0;
	$notice     = '';
	
	for ($i = 0; $i < $numItem; $i++) {
		$newQty = (int)$itemQty[$i];
		if ($newQty < 1) {
			// remove this item from shopping cart
			deleteFromCart($cartId[$i]);	
			$numDeleted += 1;
		} else {
			// check current stock
			$sql = "SELECT pd_name, pd_qty
			        FROM tbl_product 
					WHERE pd_id = {$productId[$i]}";
			$result = dbQuery($sql);
			$row    = dbFetchAssoc($result);
			
			if ($newQty > $row['pd_qty']) {
				// we only have this much in stock
				$newQty = $row['pd_qty'];

				// if the customer put more than
				// we have in stock, give a notice
				if ($row['pd_qty'] > 0) {
					setError('ขออภัย จำนวนสินค้าที่คุณต้องการมากกว่าจำนวนสินค้าที่มีอยู่ในสต๊อค <br>จำนวนสินค้าจะถูกแก้ไขอัตโนมัติให้เท่ากับจำนวนสต๊อคที่มีอยู่');
				} else {
					// the product is no longer in stock
					setError('ขออภัย, สินค้าที่คุณต้องการ (' . $row['pd_name'] . ') ในตอนนี้ไม่มีอยู่ในสต๊อคสินค้าของเรา');

					// remove this item from shopping cart
					deleteFromCart($cartId[$i]);	
					$numDeleted += 1;					
				}
			} 
							
			// update product quantity
			$sql = "UPDATE tbl_cart
					SET ct_qty = $newQty
					WHERE ct_id = {$cartId[$i]}";
				
			dbQuery($sql);
		}
	}
	
	if ($numDeleted == $numItem) {
		// if all item deleted return to the last page that
		// the customer visited before going to shopping cart
		header("Location: $returnUrl" . $_SESSION['shop_return_url']);
	} else {
		header('Location: cart.php');	
	}
	
	exit;
}

function isCartEmpty()
{
	$isEmpty = false;
	
	$sid = session_id();
	$sql = "SELECT ct_id
			FROM tbl_cart ct
			WHERE ct_session_id = '$sid'";
	
	$result = dbQuery($sql);
	
	if (dbNumRows($result) == 0) {
		$isEmpty = true;
	}	
	
	return $isEmpty;
}

/*
	Delete all cart entries older than one day
*/
function deleteAbandonedCart()
{
	$yesterday = date('Y-m-d H:i:s', mktime(0,0,0, date('m'), date('d') - 1, date('Y')));
	$sql = "DELETE FROM tbl_cart
	        WHERE ct_date < '$yesterday'";
	dbQuery($sql);		
}

function goCheckout()
{
	updateCart();
	header("location: checkout.php?step=1");
}
?>