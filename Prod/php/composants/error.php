<?php

    class ErrorPanel
    {
        public static function showError($title, $body)
        {
            $old_page = "index.php";

            if (isset($_SESSION['historique'])) {
                array_shift($_SESSION['historique']);
                $old_page = $_SESSION['historique'][0];
            }
            
            
            echo '<div class="container-fluid mt-3">
					<div class="card container col-md-6 px-0">
						<div class="card-header bg-danger">
						   <h4 class="text-left text-white font-weight-bold">'.$title.'</h4>
						</div>
						<div class="card-body bg-white">
						   <p class="card-text">'.$body.'</p>
						    <a href="'.$old_page.'" class="float-right btn btn-outline-warning">Réessayer</a>
						</div>
					</div>
				</div>';
        }
    }
