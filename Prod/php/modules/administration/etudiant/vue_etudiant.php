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
                'index.php?module=administration&type=etudiant&action=afficher_etudiant&num=',
                'num_etudiant',
                array('No étudiant', 'Nom', 'Prénom', 'Points ets')
            );

            require_once __DIR__ . "/html/ajouter_etudiant.html";
        }

        public function afficher_etudiant($detailsEtudiant)
        {
            $num = htmlspecialchars($_GET['num']);
            echo "<h2 class='text-center underline'> Détails de l'étudiant $num</h2>";

            $this->afficherTableau(
                $detailsEtudiant,
                array('moyenne', 'ref_semestre', 'date_debut', 'date_fin')
            );

            echo "<h2 class='text-center underline'> Modification du semestre </h2>";

            echo '
            <form autocomplete="off" method="post" action="index.php?module=administration&type=etudiant&action=modifier_etudiant&id='.$num.'">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nom_semestre">Nom</label>
                        <input type="text" class="form-control" id="nom_semestre" name="nom_semestre" placeholder="Semestre 1"
                            required value = "'.$detailsEtudiant['ref_semestre'].'"/>
                    </div>
                </div>
                
                <div class="container-fluid row justify-content-center">
                    <button type="submit" class="btn btn-outline-primary mb-2">Modifier</button>
                </div>
            </form>';
        }
    }
