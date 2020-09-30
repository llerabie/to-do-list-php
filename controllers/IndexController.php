<?php

class IndexController extends Controller {

	private $pageTpl = '/views/main.tpl.php';
	private $tasksPerPage = 3;

	public function __construct() {
		$this->model = new IndexModel();
		$this->view = new View();
		$this->utils = new Utils();
	}


	public function index() {

		$this->pageData['title'] = "To do List";
		$allTasks = count($this->model->get_data_count());
		$totalPages = ceil($allTasks / $this->tasksPerPage);
		$data = $this->makeTaskPager($allTasks, $totalPages);
		$pagination = $this->utils->drawPager($allTasks, $this->tasksPerPage);
		$msg ='';

		#Вставка новых задач в таблицу
		if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['task'])){
			$data_in[0] = $this->check_input_data($_POST['username']);
			$data_in[1] = $this->check_input_data($_POST['email']);
			$data_in[2] = $this->check_input_data($_POST['task']);
			$msg = $this->model->insert_task($data_in);
			if ($msg)
			{
				setcookie("InsertMes", "yes");
			}
			header('Location: /');
		}

		#Обновление задач в таблице
		if (isset($_POST['red_task']) || isset($_POST['red_check'])){
			if (isset($_SESSION["user"]))
			{
				$data_red[0] = $this->check_input_data($_POST['red_task']);
				$data_red[1] = $_POST['id'];
				$data_red[2] = "no";
				if(isset($_POST['red_check']) == true)
				{
					$data_red[2] = "Aaa";
				}
				$this->model->update_task($data_red);
				header('Location: /');
			}
			else{
				header('Location: /login');
			}
		}

		$this->view->render($this->pageTpl, $this->pageData, $data, $pagination, $msg);



	}


#функция проверки входных данных на символы
public function check_input_data($data) {
			  $data = trim($data);
			  $data = stripslashes($data);
			  $data = htmlspecialchars($data);
			  return $data;
	}
#функция, перенабравляющая пользователя на страницу авторизации
	public function login() {
				$this->pageData['title'] = "Authorization";
				$this->pageTpl = '/views/login.tpl.php';
				$msg = "";
				#Авторизация админа
				if (isset($_POST['login']) && isset ($_POST['password'])){
					if(!$this->model->checkUser()) {
							$msg = "Вы ввели некорректный логин/пароль. Пожалуйста, попробуйте ещё раз";
						}
					else {
						$_SESSION["user"] = $_POST['login'];
						$_SESSION["password"] = $_POST['password'];
						header("Location: /");
					}
				}
				$this->view->render($this->pageTpl, $this->pageData, NULL, NULL, $msg);
	}

#Функция выхода из учетной записи
	public function logout() {
		session_unset();
		session_destroy();
		header("Location: /");
	}
#Функция удаления куки с информацией о сортировке
	public function unset_cookie() {

		unset($_COOKIE["TestCookie"]);
		setcookie("TestCookie", null, -1, '/');
		header("Location: /");

	}

#Функция, создающая страницы с пагинацией
	public function makeTaskPager($allTasks, $totalPages) {

         if(!isset($_GET['page']) || intval($_GET['page']) == 0 || intval($_GET['page']) == 1 || intval($_GET['page']) < 0) {
             $pageNumber = 1;
             $leftLimit = 0;
             $rightLimit = $this->tasksPerPage;
         } elseif (intval($_GET['page']) > $totalPages || intval($_GET['page']) == $totalPages) {
             $pageNumber = $totalPages;
             $leftLimit = $this->tasksPerPage * ($pageNumber - 1);
             $rightLimit = $allTasks;
         } else {
             $pageNumber = intval($_GET['page']);
             $leftLimit = $this->tasksPerPage * ($pageNumber-1);
             $rightLimit = $this->tasksPerPage;
         }
				 if (isset($_POST['sort'])){
					 		$data = $this->model->get_data_limit($leftLimit, $rightLimit, $_POST['sort']);
							setcookie("TestCookie", $_POST['sort']);
							header("Location: /");
				 }
				 else if (!isset($_COOKIE["TestCookie"]) || $_COOKIE["TestCookie"] == NULL)
				   $data = $this->model->get_data_limit($leftLimit, $rightLimit, NULL);
				 else
				   $data = $this->model->get_data_limit($leftLimit, $rightLimit, $_COOKIE["TestCookie"]);

				 return $data;

     }

}
