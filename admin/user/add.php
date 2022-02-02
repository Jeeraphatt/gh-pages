<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?> 
<p class="errorMessage"><?php echo $errorMessage; ?></p>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>"  method="post" enctype="multipart/form-data" name="frmAddUser" id="frmAddUser" onSubmit="return checkAddUserForm()">
 <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="entryTable">
  <tr> 
   <td width="150" class="label">User Name</td>
   <td class="content"> <input name="txtUserName" type="text" class="box" id="txtUserName" size="20" maxlength="20"></td>
  </tr>
  <tr> 
   <td width="150" class="label">Password</td>
   <td class="content"> <input name="txtPassword" type="password" class="box" id="txtPassword" value="" size="20" maxlength="20"></td>
  </tr>
    <tr> 
   <td width="150" class="label">Confirm Password</td>
   <td class="content"> <input name="txtPasswordConfirm" type="password" class="box" id="txtPasswordConfirm" value="" size="20" maxlength="20"></td>
  </tr>
 </table>
 <p align="center"> 
  <input name="btnAddUser" type="submit" id="btnAddUser" value="Add User" class="box">
  &nbsp;&nbsp;<input name="btnCancel" type="button" id="btnCancel" value="Cancel" onClick="window.location.href='index.php';" class="box">  
 </p>
</form>
<script>
function checkAddUserForm()
{
	theForm = window.document.frmAddUser;
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
