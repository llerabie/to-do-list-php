<?php

class View {
	
	public function render($tpl, $pageData, $data, $pagination, $msg) {
		include ROOT_DIR. $tpl;
	}
}
