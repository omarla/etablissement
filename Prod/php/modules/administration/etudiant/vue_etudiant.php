<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../../../common/vue_generique.php";

    class VueEtudiant extends VueGenerique
    {
        public function __construct()
        {
        }

        public function afficher_etudiants($liste_etudiants)
        {
            echo '<h2 class="text-center text-dark underline mb-4 pt-2 underline">
                     Gestion des étudiants
                </h2>';
            
            $this->afficherTableau(
                $liste_etudiants,
                array('num_etudiant', 'nom_utilisateur', 'prenom_utilisateur', 'points_ets'),
                'index.php?module=administration&type=etudiant&action=modifier_etudiant&id=',
                'num_etudiant',
                array('No étudiant', 'Nom', 'Prénom', 'Points ets')
            );

        }

        public function afficher_etudiant($etudiant, $annee_semestre, $etudiants_semestre, $annee_courante)
        {
            echo '<fieldset class="px-3"><legend align="center" class="col-auto px-0">Détails de l étudiant</legend>';
            
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
