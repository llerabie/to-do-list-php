<?php

class Utils {


	public function drawPager($totalItems, $perPage) {

		$pages = ceil($totalItems / $perPage);

		if(!isset($_GET['page']) || intval($_GET['page']) == 0) {
			$page = 1;
		} else if (intval($_GET['page']) > $totalItems) {
			$page = $pages;
		} else {
			$page = intval($_GET['page']);
		}


				$pager =  "<nav aria-label='Page navigation'>";
        $pager .= "<ul class='pagination'>";
        $pager .= "<li><a href='/index?page=1' aria-label='Previous'><span aria-hidden='true'>«</span> Начало</a></li>";
        for($i=2; $i<=$pages-1; $i++) {
            $pager .= "<li><a href='/index?page=". $i."'>" . $i ."</a></li>";
        }
        $pager .= "<li><a href='/index?page=". $pages ."' aria-label='Next'>Конец <span aria-hidden='true'>»</span></a></li>";
        $pager .= "</ul>";
				$pager .= "</nav>";


        return $pager;

	}


}
