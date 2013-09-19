<?php
if($_POST['telefon']){
	$text = 'Tschakka,<br><br>die Mail kommt von unserem neuen Rückruf Service. Ein Kunde bittet auf der Singpoint Kontaktseite um einen Rückruf unter folgender Rufnummer:<br><br>'.$_POST['telefon'].'<br><br>. Bitte ruft unseren Kunden so schnell es geht zurück. Vielen Dank!<br><br>Das Singpoint Rückruf System';
	mail('info@singpoint.de', 'Kunde bittet um Rückruf', $text,"From: Singpoint GmbH <info@singpoint.de>\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\nX-Mailer: PHP ". phpversion());
	header("Location: ".$_POST['location']);
}
else{
	header("Location: http://www.singpoint.de/contact.html");
}


?>