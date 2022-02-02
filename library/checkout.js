function setPaymentInfo(isChecked)
{
	with (window.document.frmCheckout) {
		if (isChecked) {
			txtPaymentFirstName.value  = txtShippingFirstName.value;
			txtPaymentLastName.value   = txtShippingLastName.value;
			txtPaymentAddress1.value   = txtShippingAddress1.value;
			txtPaymentAddress2.value   = txtShippingAddress2.value;
			txtPaymentPhone.value      = txtShippingPhone.value;
			txtPaymentState.value      = txtShippingState.value;			
			txtPaymentCity.value       = txtShippingCity.value;
			txtPaymentPostalCode.value = txtShippingPostalCode.value;
			
			txtPaymentFirstName.readOnly  = true;
			txtPaymentLastName.readOnly   = true;
			txtPaymentAddress1.readOnly   = true;
			txtPaymentAddress2.readOnly   = true;
			txtPaymentPhone.readOnly      = true;
			txtPaymentState.readOnly      = true;			
			txtPaymentCity.readOnly       = true;
			txtPaymentPostalCode.readOnly = true;			
		} else {
			txtPaymentFirstName.readOnly  = false;
			txtPaymentLastName.readOnly   = false;
			txtPaymentAddress1.readOnly   = false;
			txtPaymentAddress2.readOnly   = false;
			txtPaymentPhone.readOnly      = false;
			txtPaymentState.readOnly      = false;			
			txtPaymentCity.readOnly       = false;
			txtPaymentPostalCode.readOnly = false;			
		}
	}
}


function checkShippingAndPaymentInfo()
{
	with (window.document.frmCheckout) {
		if (isEmpty(txtShippingFirstName, 'กรุณากรอกชื่อ')) {
			return false;
		} else if (isEmpty(txtShippingLastName, 'กรุณากรอกนามสกุล')) {
			return false;
		} else if (isEmpty(txtShippingAddress1, 'กรุณาการที่อยู่จัดส่งสินค้า')) {
			return false;
		} else if (isEmpty(txtShippingPhone, 'กรุณากรอกเบอร์โทรศัพท์')) {
			return false;
		} else if (isEmpty(txtShippingState, 'กรุณากรอกอำเภอหรือเขต')) {
			return false;
		} else if (isEmpty(txtShippingCity, 'กรุณากรอกจังหวัด')) {
			return false;
		} else if (isEmpty(txtShippingPostalCode, 'กรุณากรอกรหัสไปรษณีย์')) {
			return false;
		} else if (isEmpty(txtPaymentFirstName, 'กรุณากรอกชื่อ')) {
			return false;
		} else if (isEmpty(txtPaymentLastName, 'กรุณากรอกนามสกุล')) {
			return false;
		} else if (isEmpty(txtPaymentAddress1, 'กรุณากรอกที่อยู่ผู้ชำระสินค้า')) {
			return false;
		} else if (isEmpty(txtPaymentPhone, 'กรุณากรอกเบอร์โทรศัพท์')) {
			return false;
		} else if (isEmpty(txtPaymentState, 'กรุณากรอกอำเภอหรือเขต')) {
			return false;
		} else if (isEmpty(txtPaymentCity, 'กรุณากรอกจังหวัด')) {
			return false;
		} else if (isEmpty(txtPaymentPostalCode, 'กรุณากรอกรหัสไปรษณีย์ของผู้ซื้อสินค้า')) {
			return false;
		} else {
			return true;
		}
	}
}
