<?php
//Define all functions here
	function __autoload($className){
		if(file_exists(DOCUMENTROOT.'/classes/class.'.$className.'.php')){
			include_once(DOCUMENTROOT.'/classes/class.'.$className.'.php');
		}
	}

	/* Function to take sentences on word boundary's Starts */
	function str_stop($string, $max_length){
	   if (strlen($string) > $max_length){
		   $string = substr($string, 0, $max_length);
		   $pos = strrpos($string, " ");
		   if($pos === false) {
				   return substr($string, 0, $max_length)."...";
			   }
		   return substr($string, 0, $pos)."...";
	   }else{
		   return $string;
	   }
	}
	/* Function to take sentences on word boundary's Ends */

	/* Function to take sentences on character limits Starts */
	function str_substr($string, $max_length){
		$string=trim($string);
	   	if (strlen($string) > $max_length){
		   $newstring= substr($string, 0, $max_length);
		}else{
		   $newstring=$string;
		}
		if(strlen($string)>strlen($newstring)){
			$newstring.='...';
		}
		return $newstring;
	}
	/* Function to take sentences on character limits Ends */

	//Function to remove special characters from text STARTS
	function specialchars($text){
		$newtext = trim($text);
		$newtext = strip_tags($newtext);
		$newtext=htmlspecialchars(str_replace('\\', '', $newtext),ENT_QUOTES);
		$newtext=eregi_replace('&amp;','&',$newtext);
		//$newtext=nl2br($newtext);
		return $newtext;
	}
	//Function to remove special characters from text ENDS


	// REDIRECT FUNCTION
	function client_redirect($url){
		echo "<script language=\"\">";
		echo "window.location.href = \"".$url."\"";
		echo "</script>";
	}

	function arr2json($arr) {
			$str = "{ ";
			$temp = array();
			while ( list( $key, $val ) = each($arr) ){	//echo "<p>".$key."=".$val;
				$val=decodespecialchars($val);
				$encval = encodejson($val);
				$encval=$val;
				$s = "\"$key\" : { \"value\" : \"$encval\"}";
				array_push($temp, $s);
			}

			$str .= implode(',',$temp);
			$str .= "}";
			//echo $str;
			return $str;
	}

	function geteditdatetime($dbdate){
		$tmStamp = strtotime($dbdate);
		$dtSystemDate=date("d-m-Y H:i:s",$tmStamp);
		return $dtSystemDate;
	}

	function getdisplaydatetime($dbdate){
		$tmStamp = strtotime($dbdate);
		$dtSystemDate=date("M d, Y - h:i A",$tmStamp);
		$dtSystemDate=str_replace("-", "at", $dtSystemDate);
		return $dtSystemDate;
	}
	function getcalendardatetime($dbdate){
		$temppublishdate = explode(" ", $dbdate) ;
		$temppublishdate_datepart = explode("-", $temppublishdate[0]);
		$publishdate = $temppublishdate_datepart[2] . '-' . $temppublishdate_datepart[1] . '-'. $temppublishdate_datepart[0] . ' ' . $temppublishdate[1] ;
		return $publishdate;
	}
	function getdisplaydate($dbdate){
		$tmStamp = strtotime($dbdate);
		$dtSystemDate=date("M d, Y ",$tmStamp);
		return $dtSystemDate;
	}

	function getdbdate($dbdate){
		$tmStamp = strtotime($dbdate);
		$dtSystemDate=date("Y-m-d H:i:s",$tmStamp);
		return $dtSystemDate;
	}

	function displayDate($dbdate){
		$tmStamp = strtotime($dbdate);
		return date('l jS \of F Y h:i:s A',$tmStamp);
	}
		//Function to convert date into YYYY-mm-dd hh:mm:ss format
	function dbdate($date){
		$date=explode("-",$date);
		$year=explode(" ",$date[2]);
		$date1=$year[0]."-";
		if($date[1]<10 && (substr($date[1],0,1)!=0))
			$date1.="0".$date[1]."-";
		else
			$date1.=$date[1]."-";
		if($date[0]<10 && (substr($date[0],0,1)!=0))
			$date1.="0".$date[0]." ".$year[1];
		else
		$date1.=$date[0]." ".$year[1];
		return $date1;
	}
	//date without time
	function dbdatenotime($date){
		$date=explode("-",$date);
		$year=explode(" ",$date[2]);
		$date1=$year[0]."-";
		if($date[1]<10 && (substr($date[1],0,1)!=0))
			$date1.="0".$date[1]."-";
		else
			$date1.=$date[1]."-";
		if($date[0]<10 && (substr($date[0],0,1)!=0))
			$date1.="0".$date[0]." ".$year[1];
		else
		$date1.=$date[0];
		return $date1;
	}
//Function to get IP address of user
	function getIP(){
		if(isset($_SERVER["HTTP_TRUE_CLIENT_IP"]))
			$IP = $_SERVER["HTTP_TRUE_CLIENT_IP"];
		elseif(isset($_SERVER["HTTP_NS_REMOTE_ADDR"]))
			$IP = $_SERVER["HTTP_NS_REMOTE_ADDR"];
		else
			$IP = $_SERVER["REMOTE_ADDR"];

			$IP = "127.0.0.1";
			// echo $IP;
		return($IP);
	}

//Function to convert all special chars Starts
function replacespecialchars($str){
	$str=trim($str);
	$str=ereg_replace("&quot;","",$str);
	$str=ereg_replace("&#039;","",$str);
	$str=ereg_replace("&","&amp;",$str);
	$str=ereg_replace("\;","&#59;",$str);
	$str=ereg_replace("-","",$str);
	$str=ereg_replace("#","",$str);
	$str=ereg_replace("\?","",$str);
	$str=ereg_replace('"',"",$str);
	$str=ereg_replace("'","",$str);
	$str=ereg_replace(",","",$str);
	$str=ereg_replace("!","",$str);
	$str=ereg_replace("'","",$str);
	$str=ereg_replace("&","",$str);
	$str=ereg_replace("\/","",$str);
	$str=ereg_replace("\.","",$str);
	$str=ereg_replace(":","",$str);
	$str=ereg_replace(",","",$str);
	$str=ereg_replace(";","",$str);
	$str=ereg_replace("\(","",$str);
	$str=ereg_replace("\)","",$str);
	$str=ereg_replace("!","",$str);
	$str=ereg_replace("\>","",$str);
	$str=ereg_replace("\%","",$str);
	$str=ereg_replace("  "," ",$str);
	$str=ereg_replace(" "," ",$str);
	$str=ereg_replace("�","&#8218;",$str);
	$str=ereg_replace("�","&#402;",$str);
	$str=ereg_replace("�","&#8222;",$str);
	$str=ereg_replace("�","&#8230;",$str);
	$str=ereg_replace("�","&#8224;",$str);
	$str=ereg_replace("�","&#8225;",$str);
	$str=ereg_replace("�","&#710;",$str);
	$str=ereg_replace("�","&#8240;",$str);
	$str=ereg_replace("�","&#352;",$str);
	$str=ereg_replace("�","&#8249;",$str);
	$str=ereg_replace("�","&#338;",$str);
	$str=ereg_replace("�","&#8216;",$str);
	$str=ereg_replace("�","&#8217;",$str);
	$str=ereg_replace("�","&#8220;",$str);
	$str=ereg_replace("�","&#8221;",$str);
	$str=ereg_replace("�","&#8226;",$str);
	$str=ereg_replace("�","&#8211;",$str);
	$str=ereg_replace("�","&#8212;",$str);
	$str=ereg_replace("�","&#732;",$str);
	$str=ereg_replace("�","&#8482;",$str);
	$str=ereg_replace("�","&#353;",$str);
	$str=ereg_replace("�","&#8250;",$str);
	$str=ereg_replace("�","&#339;",$str);
	$str=ereg_replace("�","&#376;",$str);
	$str=strtolower($str);
	return $str;
}
//Function to convert all special chars Ends
//Function to convert HTML entities
function decodespecialchars($str){
	$str = ereg_replace("\n","\\n",$str);
	$str = ereg_replace("\r","\\r",$str);
	$str=ereg_replace("&#039;","'",$str);
	$str=ereg_replace("&amp;","&",$str);
	$str=ereg_replace("&#59;","\;",$str);
	$str=ereg_replace("&#35;","#",$str);
	$str=ereg_replace("&#34;",'"',$str);
	$str=ereg_replace("&#39;","'",$str);
	$str=ereg_replace("&#58;",":",$str);
	$str=ereg_replace("&#47;","\/",$str);
	$str=ereg_replace("&#33;","!",$str);
	$str=ereg_replace("&#63;","\?",$str);
	//special character
	$str=ereg_replace("&#8218;","�",$str);
	$str=ereg_replace("&#402;","�",$str);
	$str=ereg_replace("&#8222;","�",$str);
	$str=ereg_replace("&#8230;","�",$str);
	$str=ereg_replace("&#8224;","�",$str);
	$str=ereg_replace("&#8225;","�",$str);
	$str=ereg_replace("&#710;","�",$str);
	$str=ereg_replace("&#8240;","�",$str);
	$str=ereg_replace("&#352;","�",$str);
	$str=ereg_replace("&#8249;","�",$str);
	$str=ereg_replace("&#338;","�",$str);
	$str=ereg_replace("&#8216;","�",$str);
	$str=ereg_replace("&#8217;","�",$str);
	$str=ereg_replace("&#8220;","�",$str);
	$str=ereg_replace("&#8221;","�",$str);
	$str=ereg_replace("&#8226;","�",$str);
	$str=ereg_replace("&#8211;","�",$str);
	$str=ereg_replace("&#8212;","�",$str);
	$str=ereg_replace("&#732;","�",$str);
	$str=ereg_replace("&#8482;","�",$str);
	$str=ereg_replace("&#353;","�",$str);
	$str=ereg_replace("&#8250;","�",$str);
	$str=ereg_replace("&#339;","�",$str);
	$str=ereg_replace("&#376;","�",$str);
	$str=htmlspecialchars_decode($str);
	return $str;
}

//This function is used to get the headline of the content for Tracklog function Starts
	function getHeadline($id,$columns,$tablename,$idcolumn){
		$headline="";
		if($idcolumn!=""){
			$db =  Database::Instance();
			$dataArr = $db->getDataFromTable(array($idcolumn=>$id),$tablename,$columns);
			$totalData = count($dataArr);
			if($totalData){
				$headline=$dataArr[0][$columns];
			}
		}
		return($headline);
	}
//This function is used to get the headline of the content for Tracklog function Ends

function replacespecialcharsurl($str){
		$str=trim($str);
		$str=ereg_replace("&#039;","",$str);
		$str=ereg_replace("\/","",$str);
		$str=ereg_replace("-","",$str);
		$str=ereg_replace('"',"",$str);
		$str=ereg_replace("'","",$str);
		$str=ereg_replace("!","",$str);
		$str=ereg_replace("#","",$str);
		$str=ereg_replace("\?","",$str);
		$str=ereg_replace(",","",$str);
		$str=ereg_replace("'","",$str);
		$str=ereg_replace("&","",$str);
		$str=ereg_replace("\.","",$str);
		$str=ereg_replace(":","",$str);
		$str=ereg_replace("\(","",$str);
		$str=ereg_replace("\)","",$str);
		$str=ereg_replace("!","",$str);
		$str=ereg_replace("\%","",$str);
		$str=ereg_replace("\>","",$str);
		$str=ereg_replace("  "," ",$str);
		$str=ereg_replace(" ","-",$str);

		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("�","",$str);
		$str=ereg_replace("â€™","",$str);
		$str=ereg_replace("’","",$str);
		$str=strtolower($str);
		return $str;
}


 function getPreviewUrl($flag,$id,$extraParameter=''){
 	switch ($flag) {
		case 'd': $file_name = 'designer_details.php?designer_id=';
				break;
		case 'p': $file_name = 'product_details.php?id=';
				break;
	}
    $return = FRONTEND_SITE_URL.'/'.$file_name.$id.$extraParameter.'&flag=p';
	return($return);
 }

 function strhex($string){
   $hexstr = unpack('H*', $string);
   return array_shift($hexstr);
 }

 function hexstr($hexstr){
   $hexstr = str_replace(' ', '', $hexstr);
   $retstr = pack('H*', $hexstr);
   return $retstr;
 }

 function encryptdata($str){
   return base64_encode(strrev(trim(strhex($str))));
 }

 function decryptdata($str){
   return hexstr(strrev(base64_decode($str)));
 }

 function getthumbnail($imagename,$size){
 	if($imagename != '' && $size != '' ){
		$imgval=explode('.',$imagename);
		$resizethumbval=$imgval[0].'_'.$size.'.'.$imgval[1];
		return $resizethumbval;
	}else{
		return $imagename;
	}
 }

 function callCurlURL($url, $params = array()){

	 try{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT,1);

		if(isset($params['request_type']) && $params['request_type'] == 'post'){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params['post_fields']);
		}

			$content = curl_exec($ch);
			curl_close($ch);
			return $content;

		} catch (Exception $e) {
			   // echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
	}

	function launchBackgroundProcess($call){
		pclose(popen($call . " &", "r"));
		return true;

	}

	function getFeedColor($feed_id){
		$db =  Database::Instance() ;
		$result_module =array();
		$sql = "SELECT color FROM feeds_master where id=".$feed_id;
		$db->query($sql);
		if($db->getRowCount() > 0){
			$result_module = $db->getResultSet();
		}
		return $result_module;
	}

	function get_style_code($id,$category_name,$style_name){
		if($id != ''){
			//echo $category_name.'<br>'.$style_name.'<br>';
			$category_name = strtoupper(substr($category_name, 0,3));
			$style_name = strtoupper(substr($style_name,0, 3));
			$style_no = $category_name.$id.$style_name;
		}else{
			$style_no = '0';
		}
		return $style_no;
	}

	/**
	* checkRole
	*@param (string) roles who can access the page (write in comma separate e.g admin,customer_care)
	*
	**/
	function checkRole($class){
		switch($class):
			case "category" :
				$access = 'admin';
			break;
			case "employee" :
				$access = 'admin';
			break;
			case "city" :
				$access = 'admin';
			break;
			case "CmsUser" :
				$access = 'admin';
			break;
			case "leadsource" :
				$access = 'admin,customer_care';
			break;
			case "leadmanager" :
				$access = 'admin';
			break;
			case "leadstage" :
				$access = 'admin';
			break;
			case "orders" :
				$access = 'admin';
			break;
			case "pricelist" :
				$access = 'admin';
			break;
			case "product" :
				$access = 'admin';
			break;
		endswitch;

		$roles = explode(',',$access);
		$condition ='';
		$i = 1;
		//print_r(count($roles));exit;
		foreach ($roles as $role) {
			if($_SESSION['tmobi']['role']==$role){
				$condition .= true;
			}else{
				$condition .= false;
			}
			//$condition .= $_SESSION['tmobi']['role'] ."==".$role;
			if(count($roles) > $i){
				$condition .= ' || ';
			}else{
				$condition .= '';
			}
			$i++;
		}
		if($condition){
			//"nothing to do";
		}else{
			header('location: '.SITEPATH.'/dashboard/display.php');
			//redirect(SITEPATH.'dashboard/display.php');
		}
	}



?>
