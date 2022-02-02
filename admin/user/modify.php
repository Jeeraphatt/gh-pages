<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if (isset($_GET['userId']) && (int)$_GET['userId'] > 0) {
	$userId = (int)$_GET['userId'];
} else {
	header('Location: index.php');
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

$sql = "SELECT user_name, user_password
        FROM tbl_user
        WHERE user_id = $userId";
$result = dbQuery($sql);		
extract(dbFetchAssoc($result));


?> 
<p class="errorMessage"><?php echo $errorMessage; ?></p>
<form action="processUser.php?action=modify" method="post" enctype="multipart/form-data" name="frmModifyUser" id="frmModifyUser" onSubmit="return checkEditUserForm()">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
   <td width="150" class="label">User Name</td>
   <td class="content"><input name="txtUserName" type="text" class="box" id="txtUserName" value="<?php echo $user_name; ?>" size="20" maxlength="20" disabled="disabled">
    <input name="hidUserId" type="hidden" id="hidUserId" value="<?php echo $userId; ?>"> </td>
  </tr>
  <tr> 
   <td width="150" class="label">Password</td>
   <td class="content"> <input name="txtPassword" type="password" class="box" id="txtPassword" size="20" maxlength="20"></td>
  </tr>
 <tr> 
   <td width="150" class="label">Confirm password</td>
   <td class="content"> <input name="txtPasswordConfirm" type="password" class="box" id="txtPasswordConfirm" size="20" maxlength="20"></td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnModifyUser" type="submit" id="btnModifyUser" value="Modify User"  class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';" class="box">  
 </p>
</form>

<script>
function checkEditUserForm()
{
	theForm = window.document.frmModifyUser;
	if (theForm.txtPassword.value == '') {
		alert('Enter password');
		theForm.txtPassword.focus();
		return false;
	} else if (theForm.txtPasswordConfirm.value == '') {
		alert('Confirm password');
		theForm.txtPasswordConfirm.focus();
		return false;
	} else if (theForm.txtPassword.value != theForm.txtPasswordConfirm.value) {
		alert('Password don\'t match');
		theForm.txtPasswordConfirm.focus();
		return false;
	} else {
		return true;
	}
}
</script>