<?php
include_once("Definitions.php");
/*******************************************************************************
*Name: executeQuary
*Discription: This method get a sql command executes it and returns the result set  
*input: a sql command (as String)
*output: reult set that results from the queary executed
* Author: Amit Eitan
* Date: 6/9/2008 2:19
********************************************************************************/
function executeQuary($sql)
	{		
	 	global $dbServer;
	 	global $dbUser;
	 	global $dbPassword;
	 	global $dbSchemeSelect;
	 	$db = mysql_connect($dbServer,$dbUser,$dbPassword) or die('error message');
		$Bool_val=mysql_select_db($dbSchemeSelect,$db);
		$result = mysql_query($sql,$db); 
		return $result;
	}

/*******************************************************************************
*Name: validate_user_name
*Discription: 
*input: 
*output:
* Author:
* Date: 
********************************************************************************/
function validate_user_name($uname){
	$msg="==> �� ����� ";
	if(isHTML($uname, $msg)){return FALSE;};
	if(isempty($uname, $msg)){return FALSE;};
	if(isRestrictedChars($uname, $msg)){return FALSE;};
	return TRUE;
}

/*******************************************************************************
*Name: validate_pass1
*Discription: 
*input: 
*output:
* Author:
* Date: 
********************************************************************************/
function validate_pass1($pass){
	$msg="==>Password";
	if(isHTML($pass, $msg)){return FALSE;};
	if(isempty($pass, $msg)){return FALSE;};
	if(isRestrictedChars($pass, $msg)){return FALSE;};
	return TRUE;
}
 
/*******************************************************************************
*Name: validate_pass2
*Discription: 
*input: 
*output:
* Author:
* Date: 
********************************************************************************/
function validate_pass2($pass){
	$msg="==>Password (confirm)";
	if(isHTML($pass, $msg)){return FALSE;};
	if(isempty($pass, $msg)){return FALSE;};
	if(isRestrictedChars($pass, $msg)){return FALSE;};
	if(isNotConfirmed($pass,$_REQUEST["pass1"],$msg)){return FALSE;};
	return TRUE;
}

/*******************************************************************************
*Name: isempty
*Discription: 
*input: 
*output:
* Author:
* Date: 
********************************************************************************/
function isempty($var, $msg) {
	global $errors;
	if(empty($var)){
		$errors[]=$msg." ���� ���";
		return TRUE;
	}
	return FALSE;
}
/*******************************************************************************
*Name: isHTML
*Discription: 
*input: 
*output:
* Author:
* Date: 
********************************************************************************/
function isHTML($var, $msg){
	global $errors;
	if(strcmp(htmlspecialchars($var), $var) != 0 || strcmp(strip_tags($var), $var) != 0){
		$var="";
		$errors[]=$msg.": HTML special charaters are not allowed";
		return TRUE;
	}
	return FALSE;
}
/*******************************************************************************
*Name: isNotNum
*Discription: 
*input: 
*output:
* Author:
* Date: 
********************************************************************************/
function isNotNum($var,$msg){
	global $errors;
	if(empty($var))		return FALSE;
	if(!ctype_digit($var)){
		$var="";
		$errors[]=$msg." ���� ����";
		return TRUE;
	}
	return FALSE;
}
/*******************************************************************************
*Name: isNotConfirmed
*Discription: 
*input: 
*output:
* Author:
* Date: 
********************************************************************************/
function isNotConfirmed($var1,$var2, $msg){
	global $errors;
	if(strcmp($var1,$var2) != 0){
		$var1="";$var2="";
		$errors[]=$msg." ����� ����� �� ����";
		return TRUE;
	}
	return FALSE;
}
/*******************************************************************************
*Name: isRestrictedChars
*Discription: 
*input: 
*output:
* Author:
* Date: 
********************************************************************************/
function isRestrictedChars(&$var, $msg){
	global $errors;
	$restricted=FALSE;
	for($i=0; $i<strlen($var);$i++){
		switch($var[$i]){
			case "'": $restricted=TRUE;break;
			case '"': $restricted=TRUE;break;
			case '`': $restricted=TRUE;break;
		}
	}
	if($restricted){
			$errors[]=$msg . ": ����� ` ' \" ���� ������ "; 
	}
	return $restricted;
}

/*******************************************************************************
*Name: echo_errors
*Discription: 
*input: 
*output:
* Author:
* Date: 
********************************************************************************/
function echo_errors()
{
	global $errors;
	foreach($errors as $key=>$err){
		if(strcmp("==>", substr($err,0,3)) == 0){
			echo "<font color=\"red\">".$err. "</font><br/>";
		}
	}
	return count($errors);
}?>