<?php

	if(!defined('CONST_INCLUDE')){
		die("Accès interdit");
	}

	class VueMenuExterne{

		public function afficherMenu($liste, $active) {
			include_once __DIR__ . "/html/menu_externe_part1.html";

			foreach($liste as $item){
				echo "<li class='nav-item ";
				
				if(strcasecmp($item, $active) == 0){echo " active";}

				echo "'><a class='nav-link' href='${item}.php'>${item}</a></li>";
			}

			include_once __DIR__ . "/html/menu_externe_part2.html";
		}
	}
?>
