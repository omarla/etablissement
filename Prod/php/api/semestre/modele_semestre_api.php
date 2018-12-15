<?php
    require_once __DIR__ . "/../verify.php";
    require_once __DIR__ . "./../../common/classes/semestre.php";

    class ModeleSemestreAPI extends Database
    {
        public function getListeSemestre(){
            try{
                $result = Semestre::liste_semestres();
                Response::sendHttpBodyAndExit(array_map(function($el){
                    return array(
                        "nom"=>$el['nom_semestre'],
                        "ref"=>$el['ref_semestre']
                    );
                },$result));
            }catch(PDOException $e){
                Response::send_error(HTTP_BAD_REQUEST, 'Erreur lors de la récupération des semestres');
            }
        }
    }
