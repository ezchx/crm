<?


unset($_COOKIE['verify']);
setcookie('verify', '', time() - 3600, '/');

// Verify Login and Set Cookie //

if (isset($_POST['user_email'])) {

	$user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
	$user_password = isset($_POST['user_password']) ? $_POST['user_password'] : '';
	$num="0";

	// Compare to Database //
	mysql_connect("localhost",$username,$password);
	@mysql_select_db($database) or die( "Unable to select database");
	$query="SELECT * FROM users WHERE user_email = '$user_email' AND user_password = '$user_password'";
	$result=mysql_query($query);
	if ($result != "") {$num=mysql_numrows($result);}
	mysql_close();

	if ($num == "1") {

		setcookie("verify", md5($user_email.'%'.$user_password), 0, '/');
		header("Location: https://www.ezchx.com/loans/home.php");

	} else {

		$error = "Login Error - Please Try Again!";
		$B1 = "";

	}
}


$demo = $_GET['demo'];

if ($demo) {
  $user_email = "demo@demo.com";
  $user_password = "demo";
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<style type="text/css">
<!--

.style9 {
	color: #6c6b6b;
	font-size: 11px;
	font-family: tahoma;
	font-weight: bold;
}

-->
</style>

<link rel='shortcut icon' type='image/x-icon' href='../favicon.ico' />


<title>EZ Checks Loan Log</title>


</head>

<body bgcolor="#FFFFFF" style="font-family: Arial; color: #003366; padding-left: 20px;">



<table border="0" cellpadding="0" cellspacing="0" width="900">
   <tr>
      <td height="70" width="250"><div style="padding-left:0px; padding-top:5px"><a href="home.php"><img src="logo.jpg" border="0"></a></div></td>
   </tr>

</table>





<form action="" method="post">
<table style="margin-top: 200; margin-bottom: 200; margin-left: 325">
   <tr align="center" valign="middle">
      <td colspan = "2" width="220"><span class="style9"><font face="Arial" size="2" color="Red">&nbsp;<? echo @$error; ?></font></span></td>
   </tr>
   <tr align="center" valign="middle">
      <td colspan="2" width="220"><span class="style9"><font face="Arial" size="2" color="Red"><div style="padding-bottom: 6px;">&nbsp;</div></font></span></td>
   </tr>
   <tr align="left" valign="middle">
      <td width="80"><span class="style9"><font face="Arial" size="2">Email</font></span></td>
      <td width="140"><input type="input" name="user_email" value="<? echo $user_email; ?>" style="width:140px; height:18px; font-family:tahoma; font-size:11px; color:#4F4F4F "></td>
   </tr>
   <tr align="left" valign="middle">
      <td width="80"><span class="style9"><font face="Arial" size="2">Password</font></span></td>
      <td width="140"><input type="password" name="user_password" value="<? echo $user_password; ?>" style="width:140px; height:18px; font-family:tahoma; font-size:11px; color:#4F4F4F "></td>
   </tr>
   <tr align="left" valign="middle">
      <td colspan="2" align="center"><p style="margin-top: 15; margin-bottom: 5"><input type="submit" name="B1" value="Login"></p></td>
   </tr>
</table>
</form>




<table border="0" cellpadding="0" cellspacing="0" width="850" style="margin-left: 20 px;">

    <tr>
      <td width="850" height="25">
         <p style="font-size: 7pt; font-family: Arial; color: #808080">&nbsp;</p>
      </td>
    </tr>

    <tr>
      <td width="850" valign="bottom" align="center" height="35" style="border-top: 1 solid #B6BFC6">
          <p style="margin-bottom: 5; font-size: 7pt; font-family: Arial; color: #808080">2016 Houston EZ Checks LLC</p>
      </td>
    </tr>
</table>
 




</body>

</html>