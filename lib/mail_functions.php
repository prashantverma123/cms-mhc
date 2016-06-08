<?php
function sendHTMLMail($to, $subject, $body, $from, $bcc = FALSE, $folder = 'true', $host = 'tminus.mobi') {
	if ( !$to ) {
    	return ;
  	}
  	if ( !$from ) {
  		$from = MAILFROM;
  	}
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '.$to. "\r\n";
	$headers .= 'From: tminus<tminus.mobi@gmail.com>' . "\r\n";
	//$headers .= 'Cc: vijayabaswaraj@gmail.com' . "\r\n";
	$headers .= 'Bcc: vijayabaswaraj@gmail.com' . "\r\n";
	// Mail it
	//echo $to.'---'.$subject.'---'.$body.'---'.$headers;
 	mail($to, $subject, $body, $headers);
 	//mail('tminus.mobi@gmail.com', $subject, $body, $headers);
}

function sendHTMLMail1($to, $subject, $body, $from, $bcc = FALSE, $folder = 'true', $host = 'tls://smtp.gmail.com') {
	if ( !$to ) {
    	return ;
  	}
  	if ( !$from ) {
  		$from = MAILFROM;
  	}
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '.$to. "\r\n";
	$headers .= 'From: Trushali<trushali.webwerks@gmail.com>' . "\r\n";
	//$headers .= 'Cc: vijayabaswaraj@gmail.com' . "\r\n";
	$headers .= 'Bcc: trushali1088@gmail.com' . "\r\n";
	// Mail it
	//echo $to.'---'.$subject.'---'.$body.'---'.$headers;
 	mail($to, $subject, $body, $headers);
 	//mail('tminus.mobi@gmail.com', $subject, $body, $headers);
}
?>