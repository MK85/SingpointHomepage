<?php
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");	

	require  'KoolUploader/kooluploader.php';
	//Create handle object and edit upload settings.
	$kulhandle = new KoolUploadHandler();
	$kulhandle->targetFolder = 'Z:/Netzwerk/Playbacks/Projektarchiv_Singpoint/Feedbackdaten/';
	$kulhandle->allowedExtension = 'zip,rar';
	//Call the handle function to handle the request from client
	echo $kulhandle->handleUpload();
?>