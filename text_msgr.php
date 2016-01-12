?<?

$sender = $_GET["sender"];
if ($sender == "") {$sender = $_POST["sender"];}

$receiver = $_GET["receiver"];
if ($receiver == "") {$receiver = $_POST["receiver"];}


$B1 = $_POST["B1"];
$message = $_POST["message"];
$message = base64_encode($message);

if ($B1 == "Send") {

	$header = "Content-Transfer-Encoding: base64\r\n\r\n";
	$from = "-f" . $sender;
	mail($receiver,'',$message,$header,$from);
	echo "<script>window.close();</script>";

}



?>


<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title></title>

<style type="text/css">

INPUT{ 

font-family: arial, verdana, ms sans serif; 
font-size: 10pt;
}

</style>


</head>

<body bgcolor="#FFFFFF" style="font-family: Arial; color: #003366;">

<form method="POST" action="">

<table border="0" cellpadding="0" cellspacing="0" width="500">

<tr>
	<td><textarea name="message" rows="5" style="width: 100%; box-sizing: border-box; -webkit-box-sizing:border-box; -moz-box-sizing: border-box; font-size: 10pt; font-family: Arial;"><? echo $message; ?></textarea></td>
</tr>

<tr>
	<td width="100%" valign="middle" align="center">
		<input type="submit" value="Send" name="B1">
	</td>
</tr>


</table>

<input type="hidden" name="sender" value=<? echo $sender; ?>>
<input type="hidden" name="receiver" value=<? echo $receiver; ?>>

</form>




</body>
</html>