<?php

	class WarningPanel{

		public static function showError($title, $body){
			echo '<div class="container-fluid">
					<div class="card container col-md-6 px-0">
						<div class="card-header bg-danger">
						   <h3 class="text-left text-white font-weight-bold">'.$title.'</h3>
						</div>
						<div class="card-body bg-white">
						   <p class="card-text">'.$body.'</p>
						    <a href="#" class="float-right btn btn-outline-warning">Réessayer</a>
						</div>
					</div>
				</div>';
		}

	}

?>