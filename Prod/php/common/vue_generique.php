<?php

    require_once "php/verify.php";

    class VueGenerique
    {
        public function __construct()
        {
        }

        public function toListItems($items, $key, $class = '', $empty_message = '')
        {
            $html = '';

            if (is_array($items) && count($items) > 0) {
                foreach ($items as $item) {
                    $html .= '<li class="'.$class.'">'.$item[$key].'</li>';
                }
            } else {
                $html = '<li class="text-secondary text-center '.$class.'">'.$empty_message.'</li>';
            }

            return $html;
        }

        public function showCond($cond, $additionalClass = '')
        {
            if ($cond) {
                return "<i class=' text-center fas fa-check ${additionalClass}'></i>";
            } else {
                return "<i class='far fa-times-circle ${additionalClass}'></i>";
            }
        }

        public function afficherListeDroits($droits, $value = '')
        {
            echo '<select id="droits" value="'.$value.'" name="droits" class="form-control" required>';

            foreach ($droits as $droit) {
                echo "<option value='${droit}'>${droit}</option>";
            }

            echo '</select>';
        }

        public function transformerEnTableauSuppression($tableau, $cles, $cle_suppression, $debut_lien_suppression, $condition_suppression = null)
        {
            $html = "";

            foreach ($tableau as $ligne) {
                $html .= "<tr>";
                
                foreach ($cles as $cle) {
                    if(is_bool($ligne[$cle])){
                        $html .= "<td>" . $this->showCond($ligne[$cle]) . "</td>";
                    }
                    else if ($ligne[$cle] !== null) {
                        $html .= "<td>${ligne[$cle]}</td>";
                    } else {
                        $html .= "<td>-</td>";
                    }
                }

                if (!$condition_suppression || $condition_suppression($ligne)) {
                    $html .= "<td><a href='${debut_lien_suppression}${ligne[$cle_suppression]}'>
                                <button class='btn btn-sm btn-outline-danger px-2 py-0'>Supprimer</button>
                            </a></td>";
                } else {
                    $html .= "<td>
                                <button disabled class='btn btn-sm btn-outline-danger px-2 py-0'>Supprimer</button>
                              </td>";
                }

                $html .= "</tr>";
            }

            return $html;
        }


        public function afficherTableauSuppression($tableau, $cles, $cle_suppression, $debut_lien_suppression, $enTete = null, $condition_suppression = null, $classe_enTete = 'thead-dark')
        {
            if ($enTete == null) {
                $enTete = $cles;
            }

            $headerHTML = "<tr>";
            
            foreach ($enTete as $cleEntete) {
                $headerHTML .= "<th scope='col'>${cleEntete}</th>";
            }
            $headerHTML .= "<th scope='col'>supprimer</th>";

            $headerHTML .= '</tr>';


            $htmlBody = $this->transformerEnTableauSuppression($tableau, $cles, $cle_suppression, $debut_lien_suppression, $condition_suppression);

            echo '
            <div class="table-responsive small-table">
                <table class="data-table  text-center table table-striped table-hover table-bordered">
                    <thead class="'.$classe_enTete.'">'.$headerHTML.'</thead>
                    <tbody>'.$htmlBody.'</tbody>
                </table>
            </div>';
        }


        /*

        Cette fonction permet d'afficher un tableau,

        @param $data : Un tableau des objets à afficher dans le tableau
        @param $keys : Les clés des éléments qui seront afficher dans le tableau
        @param link_first_part: Le début du lien qui sera associé au clique sur la ligne du tableau
        @param link_key : La clé utlisée pour indiquée quelle partie du tableau 'Data' est utilisé dans le lien
        @param header : La liste des noms de colonnes
        @param header_class : La classe qui sera appliqué à l'entête

        */


        public function afficherTableau($data, $keys, $link_first_part = '', $link_key = null, $header = null, $header_class = 'thead-dark')
        {
            if ($header == null) {
                $header = $keys;
            }

            $headerHTML = "<tr>";
            
            foreach ($header as $headerData) {
                $headerHTML .= "<th scope='col'>${headerData}</th>";
            }

            $headerHTML .= '</tr>';


            $htmlBody = "";


            foreach ($data as $row) {
                if ($link_key != null) {
                    $htmlBody .= "<tr onclick=\"document.location = '${link_first_part}${row[$link_key]}'\">";
                } else {
                    $htmlBody .= "<tr>";
                }
                
                foreach ($keys as $key) {
                    if(is_bool($row[$key])){
                        $html .= "<td>" . $this->showCond($row[$key]) . "</td>";
                    }
                    else if ($row[$key] !== null) {
                        $htmlBody .= "<td>${row[$key]}</td>";
                    } else {
                        $htmlBody .= "<td>-</td>";
                    }
                }

                $htmlBody .= "</tr>";
            }

            echo '
            <div class="table-responsive small-table">
                <table class="data-table  text-center table table-striped table-hover table-bordered">
                    <thead class="'.$header_class.'">'.$headerHTML.'</thead>
                    <tbody>'.$htmlBody.'</tbody>
                </table>
            </div>';
        }
    }
