<?php

// ---------------------------------------------------------------------------
// Mail to USER
//

function sendMail($mail_to, $subject, $text, $vorname, $name, $email) {

	// für HTML-E-Mails muss der 'Content-type'-Header gesetzt werden
	$MailHeader .= "From: singpoint.de <info@singpoint.de>" . "\r\n";
	$MailHeader .= "Reply-To: " .$email. "\r\n";
	$MailHeader .= "MIME-Version: 1.0" . "\r\n";
	$MailHeader .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
  
  $mailHtml = "<HTML>"
             ."<HEAD>\n"
             ."</HEAD>\n"
             ."<BODY>"
             .$text
             ."</BODY>"
             ."</HTML>";
             
  // info@singpoint.de

  return (mail($mail_to, $subject, $text, $MailHeader));
  
}

function sendNow() {
	$anrede  = $_POST['anrede'];
	$name    = $_POST['nachname'];
	$vorname = $_POST['vorname'];
	$email   = $_POST['email'];
	$telefon = $_POST['telefon'];
	$text    = $_POST['text'];
	$betreff = $_POST['betreff'];
	$newsletter = $_POST['newsletter'];
	$br = "<br />";
	
	
	$msg     = "<b>Datum: </b>".date('d.m.y').' <b>um: </b>'.strftime('%H:%M:%S').$br;
	$msg    .= "<b>Betreff: </b>".$betreff.$br;
	$msg    .= "<b>Von: </b>".$anrede.' '.$vorname." ".$name.$br;
	$msg    .= "<b>E-Mail: </b>".$email.$br;
	$msg    .= "<b>Telefon: </b>".$telefon.$br;
	$msg    .= "<b>Newsletter: </b>".$newsletter.$br;
	$msg    .= "<h2>Nachricht: </h2>"."<p>".$text."</p>";

	sendMail("info@singpoint.de","Anfrage vom ".date('d.m.y').' '.strftime('%H:%M:%S'), $msg, $vorname, $name, $email);
	
	
	
	if(!testEmail($email)) {	
		// do nothing ...	
	} else {
		$msg     = "<h1>Hallo $vorname,</h1>";
 		$msg    .= "vielen Dank für das Interesse.$br
					Wir werden die Anfrage vom ".date('d.m.y')." so schnell wie möglich bearbeiten und uns anschließend mit Dir in
					Verbindung setzen.".$br.$br;
		$msg    .= 'Unser <a href="http://www.singpoint.de/onlinebooking/index.php">interaktiver Onlineberater</a> bietet in einer persönlichen Videotour aktuelle Informationen zu passenden Terminen, Standorten und der Preisgestaltung.<br><br><a href="http://www.singpoint.de/onlinebooking/index.php">Hier geht es zur interaktiven Onlineberatung.</a>'.$br.$br;
		
		$msg    .= "Für eine schnellere Beratung können wir gerne alles Weitere auch telefonisch besprechen. Wir sind Mo. - So. von 
					9:00 - 22:00 Uhr telefonisch unter 01805 - 200 252 erreichbar.".$br.$br;
		$msg    .= "Viele Grüße".$br;
		$msg    .= "Dein Singpoint Team".$br.$br.$br;
		$msg    .= '<img src="http://singpoint.de/img/logo_singpoint.gif">';
		
		sendMail($email, "Deine Singpoint Anfrage vom ".date('d.m.y'), $msg, $vorname, $name, $email);
	}
	
}

function testEmail($email) {
  $nonascii      = "\x80-\xff";
  $nqtext        = "[^\\\\$nonascii\015\012\"]";
  $qchar         = "\\\\[^$nonascii]";
  $protocol      = '(?:mailto:)';
  $normuser      = '[a-zA-Z0-9][a-zA-Z0-9_.-]*';
  $quotedstring  = "\"(?:$nqtext|$qchar)+\"";
  $user_part     = "(?:$normuser|$quotedstring)";
  $dom_mainpart  = '[a-zA-Z0-9][a-zA-Z0-9._-]*\\.';
  $dom_subpart   = '(?:[a-zA-Z0-9][a-zA-Z0-9._-]*\\.)*';
  $dom_tldpart   = '[a-zA-Z]{2,5}';
  $domain_part   = "$dom_subpart$dom_mainpart$dom_tldpart";
  $regex         = "$protocol?$user_part\@$domain_part";

  return preg_match("/^$regex$/",$email);
}

function test($param) {
  if (isset($_POST[$param]) && ($_POST[$param] != "")) {
    return true;
  } 
  else return false;  
}


// ----------------------- M  A  I  N  --------------------------------

if(isset($_POST["senden"]) && ($_POST["senden"] == "ok")) {
	/*
	if(!testEmail($_POST["email"])) {	
		$error["mail"] = "ungültig!";	
	}
	
	if(!test("name")) {	
		$error["name"] = "*";	
	}
	
	if(!test("vorname")) {	
		$error["vorname"] = "*";	
	}
	
	if(!test("telefon")) {	
		$error["name"] = "*";	
	}
	
	if(!test("betreff")) {	
		$error["vorname"] = "*";	
	}
	
	if(!test("anrede")) {	
		$error["vorname"] = "*";	
	}
	
	if(!test("text")) {	
		$error["text"] = "*";	
	}

	*/
	if(sizeof($error) < 1)  {
		sendNow();
		header("Location: contact_danke.html");
	} else {
		header("Location: contact.html");
		//$errMsg = "Bitte vervollständigen Sie das Formular!";
	}
}

?>