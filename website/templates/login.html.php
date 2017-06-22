<!Doctype>
<html>
<head>
	<link rel="stylesheet" href="/Design/design.css">
 	<title>Login</title>
</head>
<body>
	<h1>Login</h1>
	<form method="POST">
		<label>
			Email:
			<input type="email" name="email" value="<?= (isset($email)) ? htmlspecialchars($email) : "" ?>" />
		</label>
		<label>
			Passwort:
			<input type="password" name="password">
		</label>
		<input type="submit" name="login" value="Login">
	</form>
</body>
</html>