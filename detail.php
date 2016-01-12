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

date_default_timezone_set('America/Chicago');

// error_reporting(E_ALL); //
// ini_set('display_errors', 1); //


// import_request_variables(gp); //
set_time_limit(0);




$action = $_GET["action"];
if ($action == "") {$action = $_POST["action"];}
if ($action == "Copy") {$action = "Add";}

$refer = $_GET["refer"];
if ($refer == "") {$refer = $_POST["refer"];}

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$cell_phone = $_POST["cell_phone"];
$carrier = $_POST["carrier"];
$other_phone = $_POST["other_phone"];
$email = $_POST["email"];
$contact_preference = $_POST["contact_preference"];
$income = $_POST["income"];
$income2 = $_POST["income2"];
$lifetime_loans = $_POST["lifetime_loans"];
$lifetime_loans2 = $_POST["lifetime_loans2"];
$loan_id = $_POST["loan_id"];
$write_date = $_POST["write_date"];
$write_date2 = $_POST["write_date2"];
$due_date = $_POST["due_date"];
$due_date2 = $_POST["due_date2"];
$redeem_date = $_POST["redeem_date"];
$redeem_date2 = $_POST["redeem_date2"];
$loan_amount = $_POST["loan_amount"];
$loan_amount2 = $_POST["loan_amount2"];
$loan_fees = $_POST["loan_fees"];
$loan_fees2 = $_POST["loan_fees2"];
$status = $_POST["status"];
$status_old = $_POST["status_old"];
$comments = $_POST["comments"];
$ss = $_POST["ss"];
$B1 = $_POST["B1"];

$ss = str_replace('\\','',$ss);



if ($B1 != "Text") {if ($B1 != "Email") {
$income= preg_replace('/[\$,]/', '', $income);
$loan_amount= preg_replace('/[\$,]/', '', $loan_amount);
$loan_fees= preg_replace('/[\$,]/', '', $loan_fees);
$comments= str_replace("'", "\'", $comments);
}}


// Build Search String //
if ($B1 == "Search" || $B1 == "Download") {

   $ss = "";


   if ($first_name != "") {if ($ss == "") {$ss = "first_name='$first_name'";} else {$ss = "$ss AND first_name='$first_name'";}}
   if ($last_name != "") {if ($ss == "") {$ss = "last_name='$last_name'";} else {$ss = "$ss AND last_name='$last_name'";}}

   if ($cell_phone != "") {if ($ss == "") {$ss = "cell_phone='$cell_phone'";} else {$ss = "$ss AND cell_phone='$cell_phone'";}}
   if ($carrier != "") {if ($ss == "") {$ss = "carrier='$carrier'";} else {$ss = "$ss AND carrier='$carrier'";}}
   if ($other_phone != "") {if ($ss == "") {$ss = "other_phone='$other_phone'";} else {$ss = "$ss AND other_phone='$other_phone'";}}

   if ($email != "") {if ($ss == "") {$ss = "email='$email'";} else {$ss = "$ss AND email='$email'";}}

   if ($contact_preference != "") {if ($ss == "") {$ss = "contact_preference ='$contact_preference'";} else {$ss = "$ss AND contact_preference='$contact_preference'";}}

   if ($income != "") {if ($ss == "") {$ss = "income>='$income'";} else {$ss = "$ss AND income>='$income'";}}
   if ($income2 != "") {if ($ss == "") {$ss = "income<='$income2'";} else {$ss = "$ss AND income<='$income2'";}}

   if ($lifetime_loans != "") {if ($ss == "") {$ss = "lifetime_loans>='$lifetime_loans'";} else {$ss = "$ss AND lifetime_loans>='$lifetime_loans'";}}
   if ($lifetime_loans2 != "") {if ($ss == "") {$ss = "lifetime_loans<='$lifetime_loans2'";} else {$ss = "$ss AND lifetime_loans<='$lifetime_loans2'";}}

   if ($loan_id != "") {if ($ss == "") {$ss = "loan_id='$loan_id'";} else {$ss = "$ss AND loan_id='$loan_id'";}}

   if ($write_date != "") {$write_date = strtotime($write_date); if ($ss == "") {$ss = "write_date>='$write_date'";} else {$ss = "$ss AND write_date>='$write_date'";}}
   if ($write_date2 != "") {$write_date2 = strtotime($write_date2); if ($ss == "") {$ss = "write_date<='$write_date2'";} else {$ss = "$ss AND write_date<='$write_date2'";}}

   if ($due_date != "") {$due_date = strtotime($due_date); if ($ss == "") {$ss = "due_date>='$due_date'";} else {$ss = "$ss AND due_date>='$due_date'";}}
   if ($due_date2 != "") {$due_date2 = strtotime($due_date2); if ($ss == "") {$ss = "due_date<='$due_date2'";} else {$ss = "$ss AND due_date<='$due_date2'";}}

   if ($redeem_date != "") {$redeem_date = strtotime($redeem_date); if ($ss == "") {$ss = "redeem_date>='$redeem_date'";} else {$ss = "$ss AND redeem_date>='$redeem_date'";}}
   if ($redeem_date2 != "") {$redeem_date2 = strtotime($redeem_date2); if ($ss == "") {$ss = "redeem_date<='$redeem_date2'";} else {$ss = "$ss AND redeem_date<='$redeem_date2'";}}

   if ($loan_amount != "") {if ($ss == "") {$ss = "loan_amount>='$loan_amount'";} else {$ss = "$ss AND loan_amount>='$loan_amount'";}}
   if ($loan_amount2 != "") {if ($ss == "") {$ss = "loan_amount<='$loan_amount2'";} else {$ss = "$ss AND loan_amount<='$loan_amount2'";}}

   if ($loan_fees != "") {if ($ss == "") {$ss = "loan_fees>='$loan_fees'";} else {$ss = "$ss AND loan_fees>='$loan_fees'";}}
   if ($loan_fees2 != "") {if ($ss == "") {$ss = "loan_fees<='$loan_fees2'";} else {$ss = "$ss AND loan_fees<='$loan_fees2'";}}

   if ($status != "") {if ($ss == "") {$ss = "status='$status'";} else {$ss = "$ss AND status='$status'";}}
   if ($comments != "") {if ($ss == "") {$ss = "comments LIKE '%25$comments%25'";} else {$ss = "$ss AND comments LIKE '%25$comments%25'";}}

   if ($B1 == "Search") {header("Location: https://www.ezchx.com/loans/home.php?ss=$ss");}
}



// Update Loan //
if ($B1 == "Update") {if ($dbase != "demo") {

   $write_date = strtotime($write_date);
   $due_date = strtotime($due_date);
   $redeem_date = strtotime($redeem_date);
   $pay_date = strtotime($pay_date);


   mysql_connect(localhost,$username,$password);
   @mysql_select_db($database) or die( "Unable to select database");
   $query = "UPDATE customers_$dbase SET
	loan_id = '$loan_id',
	first_name = '$first_name',
	last_name = '$last_name',
	cell_phone = '$cell_phone',
	carrier = '$carrier',
	other_phone = '$other_phone',
	email = '$email',
	contact_preference = '$contact_preference',
	income = '$income',
	lifetime_loans = '$lifetime_loans',
	write_date = '$write_date',
	due_date = '$due_date',
	redeem_date = '$redeem_date',
	loan_amount = '$loan_amount',
	loan_fees = '$loan_fees',
	status = '$status',
	comments = '$comments'
      WHERE ref = '$refer'";

   mysql_query($query);
   mysql_close();
   $B1 = "";

   if ($status_old == "Active") {if ($status == "Closed") {if ($loan_id != "") {$action = "Add";}}}
   if ($action != "Add") {header("Location: https://www.ezchx.com/loans/home.php");}

}}


// Delete Loan //
if ($B1 == "Delete") {if ($dbase != "demo") {

   mysql_connect(localhost,$username,$password);
   @mysql_select_db($database) or die( "Unable to select database");
   $query = "DELETE FROM customers_$dbase WHERE ref = '$refer'";
   mysql_query($query);
   mysql_close();
   $B1 = "";
   header("Location: https://www.ezchx.com/loans/home.php");

}}


// Add Loan //
if ($B1 == "Add") {if ($dbase != "demo") {

   $write_date = strtotime($write_date);
   $due_date = strtotime($due_date);
   $redeem_date = strtotime($redeem_date);
   $pay_date = strtotime($pay_date);

   mysql_connect(localhost,$username,$password);
   @mysql_select_db($database) or die( "Unable to select database");

   $query = "INSERT INTO customers_$dbase VALUES (
      '',
      '$loan_id',
      '$first_name',
      '$last_name',
      '$cell_phone',
      '$carrier',
      '$other_phone',
      '$email',
      '$contact_preference',
      '$income',
      '$lifetime_loans',
      '$write_date',
      '$due_date',
      '$redeem_date',
      '$loan_amount',
      '$loan_fees',
      '$status',
      '$comments')";
   mysql_query($query);
   $B1 = "";

   mysql_close();
   header("Location: https://www.ezchx.com/loans/home.php");
}}



// Download Customers//
if ($B1 == "Download") {
   mysql_connect(localhost,$username,$password);
   @mysql_select_db($database) or die( "Unable to select database");
   $query="SELECT * FROM customers_$dbase WHERE $ss";
   $result=mysql_query($query);
   $num = mysql_num_fields($result);
   mysql_close();

   $html = array();

   // Extract field names //

   for ($i = 0; $i < $num; $i++) {
      $html_titles .= "<td>" . mysql_field_name($result, $i) . "</td>";
   }

   $html[] = $html_titles;

   while($row = mysql_fetch_array($result, MYSQL_NUM))
   {
      $html[] = "<tr><td>" .implode("</td><td>", $row) . "</td></tr>";
   }

   $html = "<table>" . implode("\r\n", $html) . "</table>";
   $fileName = 'loans.xls';
   header('Content-type: application/vnd.ms-excel'); 
   header("Content-Disposition: attachment; filename=$fileName");
   echo $html;
   exit;
}


if ($refer != "") {

   if ($B1 == "") {
      // Retrieve Customer Data //

      mysql_connect(localhost,$username,$password);
      @mysql_select_db($database) or die( "Unable to select database");
      $query="SELECT * FROM customers_$dbase WHERE ref= '$refer'";
      $result=mysql_query($query);
      $num=mysql_numrows($result);
      mysql_close();

	if ($num != '') {

		$ref = mysql_result($result,0,"ref");
		$loan_id = mysql_result($result,0,"loan_id");
		$first_name = mysql_result($result,0,"first_name");
		$last_name = mysql_result($result,0,"last_name");
		$cell_phone = mysql_result($result,0,"cell_phone");
		$carrier = mysql_result($result,0,"carrier");
		$other_phone = mysql_result($result,0,"other_phone");
		$email = mysql_result($result,0,"email");
		$contact_preference = mysql_result($result,0,"contact_preference");
		$income = mysql_result($result,0,"income");
		if ($income != "") {$income = "$" . number_format($income,0);}
		$lifetime_loans = mysql_result($result,0,"lifetime_loans");
		$loan_id = mysql_result($result,0,"loan_id");
		$write_date = mysql_result($result,0,"write_date");
		$due_date = mysql_result($result,0,"due_date");
		$redeem_date = mysql_result($result,0,"redeem_date");
		$loan_amount = mysql_result($result,0,"loan_amount");
		if ($loan_amount != "") {$loan_amount = "$" . number_format($loan_amount,2);}
		$loan_fees = mysql_result($result,0,"loan_fees");
		if ($loan_fees != "") {$loan_fees = "$" . number_format($loan_fees,2);}
		$status = mysql_result($result,0,"status");
		$status_old = mysql_result($result,0,"status");
		$comments = mysql_result($result,0,"comments");

		if ($write_date != "") {$write_date = date('m/d/y', $write_date);}
		if ($due_date != "") {$due_date = date('m/d/y', $due_date);}
		if ($redeem_date != "") {$redeem_date = date('m/d/y', $redeem_date);}

	}

   }

}


if ($B1=="Text") {if ($cell_phone !="") {if ($carrier !="") {if ($dbase != "demo") {

	if ($carrier=="AT&T") {$text_email=$cell_phone . "@mms.att.net";}
	if ($carrier=="Boost") {$text_email=$cell_phone . "@myboostmobile.com";}
	if ($carrier=="Cricket") {$text_email=$cell_phone . "@mms.mycricket.com";}
	if ($carrier=="Metro PCS") {$text_email=$cell_phone . "@mms.mymetropcs.com";}
	if ($carrier=="Sprint") {$text_email=$cell_phone . "@pm.sprint.com";}
	if ($carrier=="T-Mobile") {$text_email=$cell_phone . "@tmomail.net";}
	if ($carrier=="Verizon") {$text_email=$cell_phone . "@vzwpix.com";}
	// open new window 
	echo "<script language=\"javascript\">window.open(\"https://www.ezchx.com/loans/text_msgr.php?sender=$user_email&receiver=$text_email\",\"_blank\",\"status=no, toolbar=no, location=no, menubar=no, resizeable=no, statusbar=no, height=140, width=520, top=200, left=600\");</script>"; 

        $ref = $refer;
}}}}


if ($B1=="Email") {if ($email !="") {if ($dbase != "demo") {

	// open new window 
	echo "<script language=\"javascript\">window.open(\"https://www.ezchx.com/loans/text_msgr.php?sender=$user_email&receiver=$email\",\"_blank\",\"status=no, toolbar=no, location=no, menubar=no, resizeable=no, statusbar=no, height=140, width=520, top=200, left=600\");</script>"; 

        $ref = $refer;
}}}


if ($action == "Add") {

        $ref = "";
	$loan_id = "";
	$lifetime_loans = $lifetime_loans + 1;
	$write_date = time();
	$write_date = date('m/d/y', $write_date);
	$due_date = "";
	$redeem_date = "";
	$loan_amount = "";
	$loan_fees = "";
	$status = "Active";
	$comments = "";
}


?>







<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>EZ Checks Loan Log</title>

<style type="text/css">
a
{
text-decoration: none;
color: 000000;
font-family: Arial;
}
a:hover
{
text-decoration: underline;
color: C0C0C0;
cursor: pointer;
}


INPUT{ 

font-family: arial, verdana, ms sans serif; 
font-size: 8pt;
}

</style>

<SCRIPT LANGUAGE="JavaScript" SRC="CalendarPopup.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">var cal = new CalendarPopup();</SCRIPT>

</head>

<body bgcolor="#FFFFFF" style="font-family: Arial; color: #003366; padding-left: 20px;">




<table border="0" cellpadding="0" cellspacing="0" width="500">
   <tr>
      <td height="70" width="250"><div style="padding-left:0px; padding-top:5px"><a href="home.php"><img src="logo.jpg" border="0"></a></div></td>
      <td height="70" width="250" valign="bottom" align="right"><p style="margin-bottom: 15px; margin-right: 0px"><form action="https://www.ezchx.com/loans" method="post"><input type="submit" value="Logout" style="font-size: 9pt"></form></p></td>
   </tr>

</table>

<table border="0" cellpadding="0" cellspacing="0" style="margin-left: 20 px;">


   <tr>
      <td width="" height="27" valign="middle" align="left" style="border-left: 0 solid #B6BFC6" bgcolor=""><a href="home.php" style="font-size : 9 pt; color: 003366; font-family: Arial; margin-left: 0px; margin-right: 10px">Home</a></td>
      <td width="10" height="27" valign="middle" align="center" background=""><p style="margin-bottom: 2px"><font color="#B6BFC6">|</font></p></td>
      <td width="" height="27" valign="middle" align="left"><a href="detail.php?action=Add" style="font-size : 9 pt; color: 003366; font-family: Arial; margin-left: 10px; margin-right: 10px">Add</a></td>
      <td width="10" height="27" valign="middle" align="center"><p style="margin-bottom: 2px"><font color="#B6BFC6">|</font></p></td>
      <td width="" height="27" valign="middle" align="left" background=""><a href="detail.php?action=Search" style="font-size : 9 pt; color: 003366; font-family: Arial; margin-left: 10px; margin-right: 10px">Search</a></td>
      <td width="10" height="27" valign="middle" align="center" background=""><p style="margin-bottom: 2px"><font color="#B6BFC6">|</font></p></td>
      <td width="" height="27" valign="middle" align="left" background=""><a href="detail.php?action=Download" style="font-size : 9 pt; color: 003366; font-family: Arial; margin-left: 10px; margin-right: 10px">Download</a></td>
   </tr>

    <tr>
      <td width="" height="20" colspan="7">
         <p style="font-size: 12pt; font-family: Arial; color: #FF0000"><? if ($dbase == "demo") {echo "Demo mode - certain functions are disabled.";} ?>&nbsp;</p>
      </td>
    </tr>

</table>
 
 
 
<table border="0" cellpadding="0" cellspacing="0" width="500" style="margin-left: 20 px;">

<form method="POST" action="">

    <tr>
      <td width="100%" valign="middle" align="center" bgcolor="#618499" height="22" style="border-left: 1pt solid #B6BFC6; border-right: 1pt solid #B6BFC6" colspan="2">
         <p style="margin-right: 0; margin-bottom: 0; font-size:9pt; font-family: Arial Unicode MS; color: #FFFFFF"><? echo $action; ?></p>
      </td>
    </tr>
    
    <tr>
      <td width="100%" height="40" style="border-left: 1pt solid #B6BFC6; border-right: 1pt solid #B6BFC6" colspan="2">
         <p style="font-size: 7pt; font-family: Arial Unicode MS; color: #808080">&nbsp;</p>
      </td>
    </tr>


  <? if ($action == "Update" || $action == "Add" || $action == "Delete") { ?>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Loan ID</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=1 name="loan_id" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $loan_id; ?>"></td>
     </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">First Name</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=2 name="first_name" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $first_name; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Last Name</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=3 name="last_name" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $last_name; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Cell Phone</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=4 name="cell_phone" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $cell_phone; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Cell Carrier</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; ; padding-right: 65px; padding-top: 0px; margin-left: 0px; padding-left: 0px;"><select tabindex=5 name="carrier" style="width: 79%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 0">
        <option value="<? echo $carrier; ?>"><? echo $carrier; ?></option>
        <? if ($carrier != "") { ?><option value=""></option><? } ?>
        <? if ($carrier != "AT&T") { ?><option value="AT&T">AT&T</option><? } ?>
        <? if ($carrier != "Boost") { ?><option value="Boost">Boost</option><? } ?>
        <? if ($carrier != "Cricket") { ?><option value="Cricket">Cricket</option><? } ?>
        <? if ($carrier != "Metro PCS") { ?><option value="Metro PCS">Metro PCS</option><? } ?>
        <? if ($carrier != "Sprint") { ?><option value="Sprint">Sprint</option><? } ?>
        <? if ($carrier != "T-Mobile") { ?><option value="T-Mobile">T-Mobile</option><? } ?>
        <? if ($carrier != "Verizon") { ?><option value="Verizon">Verizon</option><? } ?>
        <input type="submit" value="Text" style="font-size: 9px; width: 5em; margin-left: 4px;" name="B1">
        </td>

    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Other Phone</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=6 name="other_phone" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $other_phone; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Email</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=7 name="email" style="width: 78.8%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0; margin-right: 0;" value="<? echo $email; ?>">
        <input type="submit" value="Email" style="font-size: 9px; width: 5em;margin-left: 0px;" name="B1">
      </td>
    </tr>
    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6; padding-top: 0px"><p style="margin-left: 65px"><font face="Arial" size="1">Contact Preference</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; ; padding-right: 65px; padding-top: 0px; margin-left: 0px; padding-left: 0px"><select tabindex=8 name="contact_preference" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 0">
        <option value="<? echo $contact_preference; ?>"><? echo $contact_preference; ?></option>
        <? if ($contact_preference != "") { ?><option value=""></option><? } ?>
        <? if ($contact_preference != "Cell Phone") { ?><option value="Cell Phone">Cell Phone</option><? } ?>
        <? if ($contact_preference != "Text") { ?><option value="Text">Text</option><? } ?>
        <? if ($contact_preference != "Other Phone") { ?><option value="Other Phone">Other Phone</option><? } ?>
        <? if ($contact_preference != "Email") { ?><option value="Email">Email</option><? } ?>
        <? if ($contact_preference != "Do Not Call") { ?><option value="Do Not Call">Do Not Call</option><? } ?>
        </td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Income</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=9 name="income" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $income; ?>"></td>
     </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1"># of Loans</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=10 name="lifetime_loans" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $lifetime_loans; ?>"></td>
     </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Write Date</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=11 name="write_date" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $write_date; ?>" onClick="cal.select(write_date,'anchor1','MM/dd/yy'); return false;" ID="anchor1"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Due Date</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=12 name="due_date" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $due_date; ?>" onClick="cal.select(due_date,'anchor2','MM/dd/yy'); return false;" ID="anchor2"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Redeem Date</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=13 name="redeem_date" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $redeem_date; ?>" onClick="cal.select(redeem_date,'anchor4','MM/dd/yy'); return false;" ID="anchor4"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Loan Amount</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=14 name="loan_amount" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $loan_amount; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Loan Fees</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=15 name="loan_fees" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $loan_fees; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6; padding-top: 0px"><p style="margin-left: 65px"><font face="Arial" size="1">Status</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px; padding-top: 0px; padding-left: 0px"><select tabindex=16 name="status" size="1" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 0">
        <option value="<? echo $status; ?>"><? echo $status; ?></option>
        <? if ($status != "Active") { ?><option value="Active">Active</option><? } ?>
        <? if ($status != "Closed") { ?><option value="Closed">Closed</option><? } ?>
        </td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px;"><font face="Arial" size="1">Comments</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><textarea tabindex=17 name="comments" rows="5" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;"><? echo $comments; ?></textarea></td>
    </tr>


  <? } ?>



  <? if ($action == "Search" || $action == "Download") { ?>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Loan ID</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=1 name="loan_id" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $loan_id; ?>"></td>
     </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">First Name</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=2 name="first_name" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $first_name; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Last Name</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=3 name="last_name" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $last_name; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Cell Phone</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=4 name="cell_phone" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $cell_phone; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Cell Carrier</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; ; padding-right: 65px; padding-top: 0px; margin-left: 0px; padding-left: 0px"><select tabindex=5 name="carrier" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 0">
        <option value="<? echo $carrier; ?>"><? echo $carrier; ?></option>
        <? if ($carrier != "") { ?><option value=""></option><? } ?>
        <? if ($carrier != "AT&T") { ?><option value="ATT">AT&T</option><? } ?>
        <? if ($carrier != "Boost") { ?><option value="Boost">Boost</option><? } ?>
        <? if ($carrier != "Cricket") { ?><option value="Cricket">Cricket</option><? } ?>
        <? if ($carrier != "Metro PCS") { ?><option value="Metro PCS">Metro PCS</option><? } ?>
        <? if ($carrier != "Sprint") { ?><option value="Sprint">Sprint</option><? } ?>
        <? if ($carrier != "T-Mobile") { ?><option value="T-Mobile">T-Mobile</option><? } ?>
        <? if ($carrier != "Verizon") { ?><option value="Verizon">Verizon</option><? } ?>
        </td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Other Phone</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=6 name="other_phone" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $other_phone; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Email</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=7 name="email" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $email; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6; padding-top: 0px"><p style="margin-left: 65px"><font face="Arial" size="1">Contact Preference</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px; padding-top: 0px; padding-left: 0px"><select tabindex=8 name="contact_preference" size="1" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 0">
        <option value="<? echo $contact_preference; ?>"><? echo $contact_preference; ?></option>
        <? if ($contact_preference != "") { ?><option value=""></option><? } ?>
        <? if ($contact_preference != "Cell Phone") { ?><option value="Cell Phone">Cell Phone</option><? } ?>
        <? if ($contact_preference != "Text") { ?><option value="Text">Text</option><? } ?>
        <? if ($contact_preference != "Other Phone") { ?><option value="Other Phone">Other Phone</option><? } ?>
        <? if ($contact_preference != "Email") { ?><option value="Email">Email</option><? } ?>
        <? if ($contact_preference != "Do Not Call") { ?><option value="Do Not Call">Do Not Call</option><? } ?>
        </td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Income</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=9 name="income" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $income; ?>">
      <font face="Arial" size="1">to&nbsp;</font><input type="text" tabindex=10 name="income2" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2" value="<? echo $income2; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1"># of Loans</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=11 name="lifetime_loans" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $lifetime_loans; ?>">
      <font face="Arial" size="1">to&nbsp;</font><input type="text" tabindex=12 name="lifetime_loans2" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2" value="<? echo $lifetime_loans2; ?>"></td>
    </tr>


    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Write Date</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=13 name="write_date" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $write_date; ?>" onClick="cal.select(write_date,'anchor1','MM/dd/yy'); return false;" ID="anchor1">
      <font face="Arial" size="1">to&nbsp;</font><input type="text" tabindex=14 name="write_date2" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2" value="<? echo $write_date2; ?>" onClick="cal.select(write_date2,'anchor2','MM/dd/yy'); return false;" ID="anchor2"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Due Date</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=15 name="due_date" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $due_date; ?>" onClick="cal.select(due_date,'anchor3','MM/dd/yy'); return false;" ID="anchor3">
      <font face="Arial" size="1">to&nbsp;</font><input type="text" tabindex=16 name="due_date2" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2" value="<? echo $due_date2; ?>" onClick="cal.select(due_date2,'anchor4','MM/dd/yy'); return false;" ID="anchor4"></td>
    </tr>


    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Redeem Date</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=17 name="redeem_date" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $redeem_date; ?>" onClick="cal.select(redeem_date,'anchor7','MM/dd/yy'); return false;" ID="anchor7">
      <font face="Arial" size="1">to&nbsp;</font><input type="text" tabindex=18 name="redeem_date2" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2" value="<? echo $redeem_date2; ?>" onClick="cal.select(redeem_date2,'anchor8','MM/dd/yy'); return false;" ID="anchor8"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Loan Amount</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=19 name="loan_amount" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $loan_amount; ?>">
      <font face="Arial" size="1">to&nbsp;</font><input type="text" tabindex=20 name="loan_amount2" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2" value="<? echo $loan_amount2; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Loan Fees</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><input type="text" tabindex=21 name="loan_fees" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;" value="<? echo $loan_fees; ?>">
      <font face="Arial" size="1">to&nbsp;</font><input type="text" tabindex=22 name="loan_fees2" style="width: 46%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2" value="<? echo $loan_fees2; ?>"></td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6; padding-top: 0px"><p style="margin-left: 65px"><font face="Arial" size="1">Status</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px; padding-top: 0px; padding-left: 0px"><select tabindex=23 name="status" size="1" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 0">
        <option value="<? echo $status; ?>"><? echo $status; ?></option>
        <? if ($status != "Active") { ?><option value="Active">Active</option><? } ?>
        <? if ($status != "Closed") { ?><option value="Closed">Closed</option><? } ?>
        </td>
    </tr>

    <tr>
      <td width="40%" align="left" style="border-left: 1pt solid #B6BFC6"><p style="margin-left: 65px"><font face="Arial" size="1">Comments</font></p></td>
      <td width="60%" align="left" style="border-right: 1pt solid #B6BFC6; padding-right: 65px;"><textarea tabindex=24 name="comments" rows="5" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 8pt; font-family: Arial; padding-left: 2; margin-left: 0;"><? echo $comments; ?></textarea></td>
    </tr>

  <? } ?>


    
    <tr>
      <td width="100%" valign="middle" align="center" style="border-left: 1pt solid #B6BFC6; border-right: 1pt solid #B6BFC6; border-bottom: 1pt solid #B6BFC6" colspan="2">
        <p style="margin-top: 35; margin-bottom: 35"><input type="submit" value="<? echo $action; ?>" name="B1"></p>
      </td>
    </tr>


    <input type="hidden" name="refer" value=<? echo $ref; ?>>
    <input type="hidden" name="action" value=<? echo $action; ?>>
    <input type="hidden" name="status_old" value=<? echo $status_old; ?>>
    <input type="hidden" name="ss" value="<? echo $ss; ?>">



</form>

</table>








<table border="0" cellpadding="0" cellspacing="0" width="500" style="margin-left: 20 px;">

    <tr>
      <td width="500" height="25">
         <p style="font-size: 7pt; font-family: Arial; color: #808080">&nbsp;</p>
      </td>
    </tr>

    <tr>
      <td width="500" valign="bottom" align="center" height="35" style="border-top: 1pt solid #B6BFC6">
          <p style="margin-bottom: 5; font-size: 7pt; font-family: Arial; color: #808080">2015 Houston EZ Checks LLC</p>
      </td>
    </tr>
</table>
 

 
</body>

</html>