<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../../../common/vue_generique.php";

    class VueSemestre extends VueGenerique
    {
        public function __construct()
        {
        }

        public function afficher_semestres($liste_semestres)
        {
            echo '<h2 class="text-center text-dark underline mb-4 pt-2 underline">
                     Gestion des semestres
                </h2>';
            
            $this->afficherTableau(
                $liste_semestres,
                array('ref_semestre', 'nom_semestre', 'points_ets_semestre', 'nombre_reussite', 'nombre_echoue'),
                'index.php?module=administration&type=semestre&action=modifier_semestre&id=',
                'ref_semestre',
                array('reference', 'nom', 'points ets', 'nombre réussite', 'nombre échecs')
            );

            require_once __DIR__ . "/html/ajouter_utilisateur.html";
        }

        public function afficher_semestre($semestre, $annee_semestre, $etudiants_semestre, $annee_courante)
        {
            echo '<fieldset class="px-3"><legend align="center" class="col-auto px-0">Etudiants du semestre</legend>';
            
            $this->afficherTableauSuppression(
                $etudiants_semestre,
                array('annee', 'num_etudiant', 'nom_utilisateur', 'prenom_utilisateur', 'moyenne'),
                'num_etudiant',
                '',
                array('annee', 'numéro', 'nom', 'prenom', 'moyenne'),
                function ($etudiant_semestre) {
                    return $etudiant_semestre != null && $etudiant_semestre['annee'] == $annee_courante;
                }
            );

            echo '</fieldset>';
        }
    }
