<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Singpoint - Upload</title>
		<link href="style2.css" rel="stylesheet" type="text/css" />
	</head>
<body>
	<div id="main_wrapper">
    	<p>Sehr geehrte Singpoint-Partner,<br>
			um euer Feedback an uns zu �bermitteln ist ein Login erforderlich. Verwendet dazu bitte eure individuellen Login Daten f�r den Singpoint Partnerbereich.</p>
		<form action="index.php" method="post" >
			<input type="hidden" name="action" value="login" />
			<div class="input">
				<label for="username" style="width: 200px">Benutzername:</label>
                <input type="text" name="login" id="login" />
			</div>
			<div class="input">
				<label for="password" style="width: 200px">Passwort:</label>
				<input type="password" name="password" id="password" />
            </div>
			<br />
			<input type="submit" name="submit" value="Login" />
		</form>
        <br>
	</div>
</body>