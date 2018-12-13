<?php
    class Date
    {
        public function __constructor()
        {
        }


        public static function getMonth()
        {
            return date('n');
        }

        public static function getYear()
        {
            return date('Y');
        }

        public static function getPeriodeCourante()
        {
            $date_debut = "";
            $date_fin = "";
            
            $mois = self::getMonth();
            $annee = self::getYear();

            if($mois >= 9){
                $date_debut = $annee . "-09-01";
                $date_fin   = ($annee + 1) ."-02-01";
            }else if($mois >= 2 ){
                $date_debut = $annee ."-02-01" ;
                $date_fin   = $annee. "-07-01" ;
            }

            return array("debut"=>$date_debut, "fin"=>$date_fin);
        }
    }
