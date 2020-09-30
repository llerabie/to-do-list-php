<?php

class Controller {

	public $model;
	public $view;
	protected $pageData = array();
	public $data = array();
	protected $pagination = array();
	protected $msg = "";

	public function __construct() {
		$this->view = new View();
		$this->model = new Model();
	}

}
