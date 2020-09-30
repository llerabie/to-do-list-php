<?php

class IndexModel extends Model {

#Функция получения кол-ва записей из БД
public function get_data_count(){

        $stmt = $this->db->query("SELECT `id` FROM `todolist`");
          $data = array();
          while ($row = $stmt->fetch())
          {
            $data[] = $row;
          }
          return $data;
}
#Функция получения записей из БД с лимитом
public function get_data_limit($leftLimit, $rightLimit, $sort) {
       if(isset($sort)){
        if ($sort == "name_asc") {$sql = "SELECT `id`, `name`, `email`, `task`, `status`, `red` FROM `todolist` ORDER BY `name` LIMIT :leftLimit, :rightLimit";}
        if ($sort == "name_desc")  {$sql = "SELECT `id`, `name`, `email`, `task`, `status`, `red` FROM `todolist` ORDER BY `name` DESC LIMIT :leftLimit, :rightLimit";}
        if ($sort == "email_asc") { $sql = "SELECT `id`, `name`, `email`, `task`, `status`, `red` FROM `todolist` ORDER BY `email` LIMIT :leftLimit, :rightLimit";}
        if ($sort == "email_desc")  {$sql = "SELECT `id`, `name`, `email`, `task`, `status`, `red` FROM `todolist` ORDER BY `email` DESC LIMIT :leftLimit, :rightLimit";}
        if ($sort == "task_asc")  {$sql = "SELECT `id`, `name`, `email`, `task`, `status`, `red` FROM `todolist` ORDER BY `task` LIMIT :leftLimit, :rightLimit";}
        if ($sort == "task_desc") { $sql = "SELECT `id`, `name`, `email`, `task`, `status`, `red` FROM `todolist` ORDER BY `task` DESC LIMIT :leftLimit, :rightLimit";}
        if ($sort == "status_asc")  {$sql = "SELECT `id`, `name`, `email`, `task`, `status`, `red` FROM `todolist` ORDER BY `status` LIMIT :leftLimit, :rightLimit";}
        if ($sort == "status_desc") { $sql = "SELECT `id`, `name`, `email`, `task`, `status`, `red` FROM `todolist` ORDER BY `status` DESC LIMIT :leftLimit, :rightLimit";}
      }
      else
      {
        $sql = "SELECT `id`, `name`, `email`, `task`, `status`, `red` FROM `todolist` ORDER BY `id` DESC LIMIT :leftLimit, :rightLimit";
      }
       $result = array();
       $stmt = $this->db->prepare($sql);
       $stmt->bindValue(":leftLimit", $leftLimit, PDO::PARAM_INT);
       $stmt->bindValue(":rightLimit", $rightLimit, PDO::PARAM_INT);
       $stmt->execute();
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
       {
         $result[] = $row;
       }
       return $result;

}

#Функция вставки записи в БД
  public function insert_task($data){

    $sql = "INSERT INTO todolist(name, email, task, status, red) VALUES(:name, :email, :task, :status, :red)";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":name", $data[0], PDO::PARAM_STR);
    $stmt->bindValue(":email", $data[1], PDO::PARAM_STR);
    $stmt->bindValue(":task", $data[2], PDO::PARAM_STR);
    $stmt->bindValue(":status", "no", PDO::PARAM_STR);
    $stmt->bindValue(":red", NULL, PDO::PARAM_STR);
    $stmt->execute();
    return ($stmt->rowCount() == 1);
}

#Функция обновления записи в БД
public function update_task($data_red){

    $sql = "UPDATE todolist SET task=:task, status=:status, red=:red WHERE id=:id";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(":task", $data_red[0], PDO::PARAM_STR);
    $stmt->bindValue(":id", $data_red[1], PDO::PARAM_INT);
    $stmt->bindValue(":status", $data_red[2], PDO::PARAM_STR);
    $stmt->bindValue(":red", "yes", PDO::PARAM_STR);
    $stmt->execute();
}

#Функция проверки пользователя на логин/пароль
public function checkUser() {

		$login = $_POST['login'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM users WHERE login = :login AND password = :password";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(":login", $login, PDO::PARAM_STR);
		$stmt->bindValue(":password", $password, PDO::PARAM_STR);
		$stmt->execute();


		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($res)) {
     return true;
		} else {
			return false;
		}

	}

}
