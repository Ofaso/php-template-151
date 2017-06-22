<!Doctype>
<html>
<head>
	<link rel="stylesheet" href="/Design/design.css">
	<title>Register</title>
</head>
<body>
	<h1>Register</h1>
	<form method="POST">
		<label>
			Email:
			<input type="email" name="email" value="<?= (isset($email)) ? htmlspecialchars($email) : "" ?>" />
		</label>
		<label>
			Passwort:
			<input type="password" name="password">
		</label>
		<input type="submit" name="register" value="register">
	</form>
</body>
</html>
