<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $pageData['title']; ?></title>
	<meta name="vieport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css" type="text/css"/>
</head>
<body>
  <header>
	<!--Вывод заглоовков -->
	<div class = "row justify-content-center text-center">
  	<h1> <b> To Do List </b></h1>
	</div>
	<div class = "row justify-content-center text-center">
	  <h2> Авторизация </h2>
	</div>
  </header>
	<!--Форма авторизации -->
	<div class = "row justify-content-center text-center">
  <form method="post" class="form_registration">
    <input type="text" name="login" id="login" class="form_registration_login input_form_reg" placeholder="Введите логин" required><br>
    <input type="password" name="password" id="password" class="form_registration_password input_form_reg" placeholder="Введите пароль" required><br>
    <button type="submit" name="submit" class="form_registration_btn btn">Войти</button> <br>
		<!--Если не получилось пишем о том, что некорректно введен логин и/или пароль -->
		<small class="helper-text"> <?php echo $msg; ?> </small>
  </form>
</div>
</body>
</html>
