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
	<div class = "container-fluid">

		<!-- Шапка -->
<header class="header">
		<div class = "row justify-content-center text-center">
			  	<!-- Название приложения -->
					<div class="col-lg-6 four" > <h1> <b> To Do List </b></h1> </div>
					<!-- Если нет пользователя выводим кнопку авторизации -->
						<?php if(!isset($_SESSION['user'])) :?>
						<div class="col-lg-2"></div>
						<div class="col-lg-2"><a href="/login"><button class="btn btn-header"> Авторизация </button> </a> </div>
						<?php else:?>
						<!-- Если есть - здороваемся и выводим кнопку выхода -->
						<?php
						echo '<div class="show-user-header col-lg-2">';
						echo 'Добро пожаловать, ';
						echo $_SESSION['user'];
						echo '</div>';?>
						<div class="col-lg-2 "><a href="/logout"><button class="btn btn-header">Выход</button> </a>	</div>
			  		<?php endif; ?>
		</div>
		<hr>
</header>
		<!-- Основной контент -->

	<div class = "row justify-content-center text-center">
		<!-- Форма добавления записей -->
		<div class="col-md-12">
		  <form method="post" class="form_create_todoitem" >
				<div class="form-row">
		     <div class="col-md-3"> <input type="text" name="username" class="form_create_todoitem_username" placeholder="Введите имя" required oninvalid="setCustomValidity('Это поле обязательно для заполнения')" oninput="setCustomValidity('')"></div>
		     <div class="col-md-3"><input type="email" name="email" class="form_create_todoitem_email" placeholder="Введите email" required></div>
		     <div class="col-md-3"><input type="text" name="task" class="form_create_todoitem_task" placeholder="Введите задачу" required oninvalid="setCustomValidity('Это поле обязательно для заполнения')" oninput="setCustomValidity('')"></div>
		     <div class="col-md-1"> <button type="submit" name="submit" id="add_btn" class="form_create_todoitem_btn btn">Создать</button></div>
					<div class="col-md-2"><small class="helper-text">
						<?php
						if (isset($_COOKIE["InsertMes"]))
						{
							echo 'Новая запись успешно добавлена!';
							unset($_COOKIE["InsertMes"]);
							setcookie("InsertMes", null, -1, '/');
						}
						?>
					</small>
					</div>
				</div>
		  </form>
		</div>
	</div>

<div class = "row justify-content-center text-center">
			<!-- Форма для кнопок, отвечающих за сортировку  -->
			<form method="post">
				<p> Сортировать по:
				<select name="sort">
					<option value=""  selected disabled>  </option>
					<option value="name_desc"> Имя пользователя &#8593; </option>
					<option value="name_asc"> Имя пользователя &#8595; </option>
					<option value="email_desc"> Email &#8593; </option>
					<option value="email_asc"> Email &#8595;</option>
					<option value="status_desc"> Статус выполнения &#8593;</option>
					<option value="status_asc"> Статус выполнения &#8595;</option>
				</select>
				<button type="submit" name="submit" id="sort_btn" class="btn_submit_sort btn">Выбрать</button>
				</p>
			</form>
			<a href="/unset_cookie"><button type="submit" name="submit_clean" id="sort_submit_btn" class="btn_submitclean_sort btn">Очистить</button></a>
	</div>

			<div class = "row justify-content-center ">
				<!-- Вывод контента из БД

			 -->
			 <!-- Шапка контента (навзание столбцов) -->
						<div class="col-md-3 text-center head-row-task"> Имя </div>
						<div class="col-md-3 text-center head-row-task"> Email </div>
						<div class="col-md-3 text-center head-row-task"> Задача </div>
						<div class="col-md-3"> Статус выполнения </div>
			</div>

			<div class = "row justify-content-center text-center">
				 <?php
				 $row = array();
				 #Цикл вывода данных из БД
				  	foreach($data as $row)
				  	{
							#Если пользователь не установлен, то запрещаем ему что-либо редактировать
							if(!isset($_SESSION['user']))
							{
									echo ' <input type="hidden" name="id" value="'.$row['id'].'">';
									echo '<div class="col-md-3"> <input type="text" name="username" value="'.$row['name'].'" disabled> </div>';
									echo '<div class="col-md-3"> <input type="text" name="email" value="'.$row['email'].'" disabled> </div>';
									echo '<div class="col-md-3"> <input type="text" name="task" value="'.$row['task'].'" disabled> </div>';
										#Проверка если установлена галочка, то выводим чекбокс с галочкой
											if ($row['status'] == 'Aaa')
											{
												echo '<div class="col-md-2"> <input type="checkbox" disabled checked> </div>';
											}
											else
											{
												echo '<div class="col-md-2"> <input type="checkbox" disabled> </div>';
											}
										#Проверка если в записи вводились изменения, то добавляем сообщение, что данная запись редактировалась админом
											if ($row['red'] == 'yes')
											{
												echo '<div class="col-md-1"> <i> <span class="red_admin_text"> ред. админ </span> </i> </div>';
											}
											else echo'<div class="col-md-1">  </div>';
							}
							else
							{
								#Если пользователь установлен, то разрешаем ему вносить изменения и добавляем кнопку внесения изменений
								echo '<div class="col-md-12">';
								echo '<form method="post" name="form_todolist_task" class="form_todolist_task">';
										echo ' <input type="hidden" name="id" value="'.$row['id'].'">';
										echo ' <div class="form-row">';
										echo ' <div class="col-md-3"> <input type="text" name="red_username" value="'.$row['name'].'" disabled> </div> ';
										echo ' <div class="col-md-3"> <input type="text" name="red_email" value="'.$row['email'].'" disabled> </div>';
										echo ' <div class="col-md-3"> <input type="text" name="red_task" value="'.$row['task'].'"> </div>';
										$checked = '';
										if ($row['status'] == 'Aaa')
										{
										  $checked = ' checked';
										}
										echo ' <div class="col-md-1"> <input type="checkbox" name="red_check"'.$checked.'> </div>';
										echo ' <div class="col-md-1 "><input type="submit" name="sbm_id" value="Сохранить"> </div>';
										if ($row['red'] == 'yes')
										{
											echo '<div class="col-md-1"> <i> <span class="red_admin_text"> ред. админ </span> </i> </div>';
										}
										else
										{
											echo'<div class="col-md-1">  </div>';
										}
										echo '</div>';
								echo '</form>';
								echo '</div>';
							}
							echo '<br>';
				  	}
					?>
				</div>

			<!-- Вывод пагинации -->
			<?php
						echo '<div class = "row justify-content-center text-center">';
						echo $pagination;
						echo '</div>';
					 ?>
	<footer>
	</footer>
</div>

</body>
</html>
