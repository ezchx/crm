<?


// Check Cookie //

if (isset($_COOKIE['verify'])) {

	mysql_connect("localhost",$username,$password);
	@mysql_select_db($database) or die( "Unable to select database");
	$query="SELECT * FROM users";
	$result=mysql_query($query);
	$num=mysql_numrows($result);
	mysql_close();

	for ($i = 0; $i < $num; $i++) {
		$key = mysql_result($result,$i,"user_email");
		$val = mysql_result($result,$i,"user_password");
		$lp = ('USE_USERNAME' ? $key : '') .'%' . $val;
		if ($_COOKIE['verify'] == md5($lp)) {
			$found = true;
			$user_email = $key;
			$dbase = mysql_result($result,$i,"dbase");

		}
	}
}


// error_reporting(E_ALL); //
// ini_set('display_errors', 1); //

date_default_timezone_set('America/Chicago');

set_time_limit(0);

$ss = $_GET["ss"];
$sort = $_GET["sort"];

$ss= str_replace("ATT", "AT&T", $ss);

if ($sort == "") {$sort = "due_date";}

$two_days_out = time() + (24*60*60);

$today_day = date(D);
if ($today_day == "Fri") {$two_days_out = $two_days_out + (1*24*60*60);}

$today = date('m/d/y', time());

$today_2 = time();

// Download Customers //

mysql_connect(localhost,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
if ($ss == "") {$query="SELECT * FROM customers_$dbase WHERE (due_date <= $two_days_out AND status = 'Active' AND loan_id != '') OR (due_date <= $today_2 AND status = 'Active' AND loan_id = '') ORDER by $sort";}
if ($dbase == "demo") {$query="SELECT * FROM customers_$dbase WHERE status = 'Active' ORDER by $sort";}
if ($ss != "") {$query="SELECT * FROM customers_$dbase WHERE $ss ORDER by $sort";}
$result=mysql_query($query);
if ($result != "") {$num=mysql_numrows($result);}
mysql_close();


if ($num != "") {
   for ($i = 0; $i < $num; $i++) {
      $ref[$i] = mysql_result($result,$i,"ref");
      $loan_id[$i] = mysql_result($result,$i,"loan_id");
      $first_name[$i] = mysql_result($result,$i,"first_name");
      $last_name[$i] = mysql_result($result,$i,"last_name");
      $write_date[$i] = mysql_result($result,$i,"write_date");
      $due_date[$i] = mysql_result($result,$i,"due_date");
      $loan_amount[$i] = mysql_result($result,$i,"loan_amount");
      $status[$i] = mysql_result($result,$i,"status");
      $comments[$i] = mysql_result($result,$i,"comments");
      if ($write_date[$i] != "") {$write_date[$i] = date('m/d/y', $write_date[$i]);}
      if ($due_date[$i] != "") {$due_date[$i] = date('m/d/y', $due_date[$i]);}
   }
}



?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>EZ Checks Loan Log</title>

<style type="text/css" media="screen">

a
{
text-decoration: none;
color: 003366;
font-family: Arial;
}
a:hover
{
text-decoration: underline;
color: C0C0C0;
cursor: pointer;
}

INPUT{ 
cursor: pointer;
font-family: arial, verdana, ms sans serif; 
font-size: 7pt;
}

#header-fixed {
  position: fixed;
}

</style>


<script language = "javascript">

function lockscroll() {

document.getElementById("thediv").style.overflow = "hidden";

}

</script>

</head>

<body bgcolor="#FFFFFF" style="font-family: Arial; color: #003366; padding-left: 20px;">


<table border="0" cellpadding="0" cellspacing="0" width="900">
   <tr>
      <td height="70" width="250"><div style="padding-left:0px; padding-top:5px"><a href="home.php"><img src="logo.jpg" border="0"></a></div></td>
      <td height="70" width="670" valign="bottom" align="right"><p style="margin-bottom: 15px; margin-right: 0px"><form action="https://www.ezchx.com/loans" method="post"><input type="submit" value="Logout" style="font-size: 9pt"></form></p></td>
   </tr>

</table>

<table border="0" cellpadding="0" cellspacing="0" style="margin-left: 20 px;">


   <tr style="bgcolor: #000000">
      <td width="" height="27" valign="middle" align="left" style="border-left: 0 solid #B6BFC6" bgcolor=""><a href="home.php" style="font-size : 9 pt; color: 003366; font-family: Arial; margin-left: 0px; margin-right: 10px">Home</a></td>
      <td width="10" height="27" valign="middle" align="center"><p style="margin-bottom: 2px"><font color="#B6BFC6">|</font></p></td>
      <td width="" height="27" valign="middle" align="left"><a href="detail.php?action=Add" style="font-size : 9 pt; color: 003366; font-family: Arial; margin-left: 10px; margin-right: 10px">Add</a></td>
      <td width="10" height="27" valign="middle" align="center"><p style="margin-bottom: 2px"><font color="#B6BFC6">|</font></p></td>
      <td width="" height="27" valign="middle" align="left"><a href="detail.php?action=Search" style="font-size : 9 pt; color: 003366; font-family: Arial; margin-left: 10px; margin-right: 10px">Search</a></td>
      <td width="10" height="27" valign="middle" align="center"><p style="margin-bottom: 2px"><font color="#B6BFC6">|</font></p></td>
      <td width="" height="27" valign="middle" align="left"><a href="detail.php?action=Download" style="font-size : 9 pt; color: 003366; font-family: Arial; margin-left: 10px; margin-right: 10px">Download</a></td>

   </tr>

    <tr>
      <td width="" height="20" colspan="7">
         <p style="font-size: 12pt; font-family: Arial; color: #FF0000"><? if ($dbase == "demo") {echo "Demo mode - certain functions are disabled.";} ?>&nbsp;</p>
      </td>
    </tr>

</table>
 
 
<table border="0" cellpadding="0" cellspacing="0" width="900" style="margin-left: 20 px">

    <tr>
      <td colspan="12"><p style="margin-top: 0px; margin-bottom: 10px"><font size="1" face="Arial"><? echo "Search Results - $num items"; ?></font></td>
    </tr>


    <tr>
      <td width="25" bgcolor="#618499" align="left"><p style="margin-left: 13px"><font size="1" face="Arial" color="#FFFFFF">&nbsp;</font></p></td>
      <td width="75" bgcolor="#618499" align="left"><font size="1" face="Arial" color="#FFFFFF"><a href="home.php?sort=loan_id&ss=<? echo $ss; ?>" style="color: #FFFFFF">Loan ID</a></font></td>
      <td width="125" bgcolor="#618499" align="left"><font size="1" face="Arial" color="#FFFFFF"><a href="home.php?sort=last_name&ss=<? echo $ss; ?>" style="color: #FFFFFF">Last Name</a></font></td>
      <td width="100" bgcolor="#618499" align="left"><font size="1" face="Arial" color="#FFFFFF"><a href="home.php?sort=first_name&ss=<? echo $ss; ?>" style="color: #FFFFFF">First Name</a></font></td>
      <td width="75" bgcolor="#618499" align="left"><font size="1" face="Arial" color="#FFFFFF"><a href="home.php?sort=write_date&ss=<? echo $ss; ?>" style="color: #FFFFFF">Write Date</a></font></td>
      <td width="75" bgcolor="#618499" align="left"><font size="1" face="Arial" color="#FFFFFF"><a href="home.php?sort=due_date&ss=<? echo $ss; ?>" style="color: #FFFFFF">Due Date</a></font></td>
      <td width="75" bgcolor="#618499" align="right"><p style="margin-right: 25px"><font size="1" face="Arial" color="#FFFFFF"><a href="home.php?sort=loan_amount&ss=<? echo $ss; ?>" style="color: #FFFFFF">Loan Amt</a></font></p></td>
      <td width="180" bgcolor="#618499" align="center"><font size="1" face="Arial" color="#FFFFFF">Comments</font></td>
      <td width="170" bgcolor="#618499" align="left"><font size="1" face="Arial" color="#FFFFFF">&nbsp;</font></td>
    </tr>

    <tr>
      <td colspan="12" style="border-left: 1 solid #B6BFC6; border-right: 1 solid #B6BFC6"><p style="font-size:0px">&nbsp;</p></td>
    </tr>


</table>


<div="thediv">
</div>

<table border="0" cellpadding="0" cellspacing="0" width="900" style="margin-left: 20 px">

<? $i = 0; ?>
<? while ($i < $num) { ?>


<form action="detail.php" method="post" style="margin-top: 0px; margin-bottom: 0px; margin-left: 0px; margin-right: 0px">

    <? $bg = "#FFFFFF"; ?>
    <? if(strtotime($due_date[$i]) < strtotime($today)) {if ($ss == "") {$bg = "#FFFF00";}} ?>

    <tr bgcolor="<? echo $bg; ?>">
      <td width="25" align="left" style="border-left: 1pt solid #B6BFC6; border-bottom: 1pt solid #B6BFC6"><p style="margin-left: 10px"><font size="1" face="Arial">&nbsp;</font></p></td>
      <td width="75" align="left" style="border-bottom: 1pt solid #B6BFC6"><font size="1" face="Arial"><? echo $loan_id[$i]; ?>&nbsp;</font></td>
      <td width="125" align="left" style="border-bottom: 1pt solid #B6BFC6"><font size="1" face="Arial"><? echo $last_name[$i]; ?>&nbsp;</font></td>
      <td width="100" align="left" style="border-bottom: 1pt solid #B6BFC6"><font size="1" face="Arial"><? echo $first_name[$i]; ?>&nbsp;</font></td>
      <td width="75" align="left" style="border-bottom: 1pt solid #B6BFC6"><font size="1" face="Arial"><? echo $write_date[$i]; ?>&nbsp;</font></td>
      <td width="75" align="left" style="border-bottom: 1pt solid #B6BFC6"><font size="1" face="Arial"><? echo $due_date[$i]; ?>&nbsp;</font></td>
      <td width="75" align="right" style="border-bottom: 1pt solid #B6BFC6"><p style="margin-right: 25px"><font size="1" face="Arial"><? if ($loan_amount[$i] != '') { ?>$<? } ?><? echo $loan_amount[$i]; ?>&nbsp;</font></p></td>
      <td width="180" align="left" style="border-bottom: 1pt solid #B6BFC6"><font size="1" face="Arial"><p style="margin-right: 10px"><? echo $comments[$i]; ?>&nbsp;</font></td>
      <td width="170" align="center" style="border-right: 1pt solid #B6BFC6; border-bottom: 1pt solid #B6BFC6"><input type="submit" name = "action" value="Update">&nbsp;<input type="submit" name = "action" value="Copy">&nbsp;<input type="submit" name = "action" value="Delete"></td>
    </tr>
    <input type="hidden" name="refer" value=<? echo $ref[$i]; ?>>

</form>



<? $i++;} ?>

</table>



<table border="0" cellpadding="0" cellspacing="0" width="900" style="margin-left: 20 px; margin-top: 50px">

    <tr>
      <td width="900" height="25">
         <p style="font-size: 7pt; font-family: Arial; color: #808080">&nbsp;</p>
      </td>
    </tr>

    <tr>
      <td width="900" valign="bottom" align="center" height="35" style="border-top: 1 solid #B6BFC6">
          <p style="margin-bottom: 5; font-size: 7pt; font-family: Arial; color: #808080">2015 Houston EZ Checks LLC</p>
      </td>
    </tr>
</table>
 

 
</body>

</html>