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

        public function transformerEnTableauSuppression($tableau, $cles, $cle_suppression, $debut_lien_suppression, $message_introuvable = "Aucun élément n'a été trouvé")
        {
            $html = "";

            if (count($tableau) == 0) {
                $html .= '<tr ><td colspan='.(count($cles) + 1) .' class="text-secondary text-center">'. $message_introuvable.'</td></tr>';
            }

            foreach ($tableau as $ligne) {
                $html .= "<tr>";
                foreach ($cles as $cle) {
                    $html .= "<td>${ligne[$cle]}</td>";
                }


                $html .= "<td><a href='${debut_lien_suppression}${ligne[$cle_suppression]}'>
                            <button class='btn btn-sm btn-outline-danger px-2 py-0'>Supprimer</button>
                         </a></td>";

                $html .= "</tr>";
            }

            return $html;
        }
    }
