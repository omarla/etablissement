<?php
    require_once "php/verify.php";
    require_once "php/common/vue_generique.php";

    class VueGroupe extends VueGenerique
    {
        public function __construct()
        {
        }

        public function afficherListeGroupe($liste_groupe, $liste_droits)
        {
            require_once __DIR__ . "/html/liste_groupes_1.html";
            
            foreach ($liste_groupe as $groupe) {
                echo "<tr>";
                echo "<td>${groupe['id_groupe']}</td>";
                echo "<td>${groupe['nom_groupe']}</td>";
                echo "<td>${groupe['nom_droits']}</td>";
                echo "<td>${groupe['nombre_utilisateurs']}</td>";
                echo "<td>${groupe['nombre_sous_groupes']}</td>";
                echo "</tr>";
            }


            echo '
                        <tbody>
                    </tbody>
                </table>
            </div>
            
            <form class="row justify-content-center container-fluid" method="post" action="index.php?module=administration&type=groupe&action=ajouter_groupe">
                <div class="row container-fluid  justify-content-around">
                    <div class="form-group col-md-5">
                        <label for="nom_groupe">Nom de groupe</label>
                        <input type="text" class="form-control" id="nom_groupe" name="nom_groupe" placeholder="nom_groupe">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="droits">Droits de groupe</label>
            ';
            
            $this->afficherListeDroits($liste_droits);
            
            echo '
                    </div>
                </div>
      
                <button class="btn btn-outline-success" type="submit">Ajouter</button>
            </form>
            ';
        }


        public function afficherDetailsGroupe($groupe, $liste_utilisateurs, $sous_groupes)
        {
            foreach ($liste_utilisateurs as &$utilisateur) {
                if (is_numeric($utilisateur['id_enseignant'])) {
                    $utilisateur['niveau'] = 'Enseignant';
                } elseif (is_numeric($utilisateur['id_personnel'])) {
                    $utilisateur['niveau'] = 'Personnel';
                } elseif (is_numeric($utilisateur['num_etudiant'])) {
                    $utilisateur['niveau'] = 'Etudiant';
                } else {
                    $utilisateur['niveau'] = '';
                }
            }

            $tab_utilisateurs = $this->transformerEnTableauSuppression(
                $liste_utilisateurs,
                array('pseudo_utilisateur', 'niveau'),
                'id_utilisateur',
                'index.php?module=administration&type=groupe&action=retirer_utilisateur&id_groupe='.$groupe['id_groupe'].'&id_utilisateur='
            );

            $tab_groupes = $this->transformerEnTableauSuppression(
                $sous_groupes,
                array('nom_groupe', 'nombre_utilisateurs'),
                'id_groupe',
                'index.php?module=administration&type=groupe&action=retirer_groupe&id_groupe='.$groupe['id_groupe'].'&sous_groupe='
            );

            echo '
        <h2 class="text-center text-dark underline mb-4 pt-2 underline">
            Groupe '.$groupe['nom_groupe'].'
        </h2>
        
        <fieldset>
            <legend align="center" class="col-auto px-0">Utilisateurs</legend>
            <div class="table-responsive px-3">
                <table id="data-table" class="small-table text-center table table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Pseudo</th>
                            <th scope="col">Status</th>
                            <th scope="col">Retirer</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$tab_utilisateurs.'
                    </tbody>
                </table>
        
                <form class="form-inline">
                    <div class="container-fluid row justify-content-around">
                        <div class="container col-md-9 row justify-content-around">
                            <label class="col-md-4 pb-2">Pseudo</label>
                            <input type="text" class="form-control col-md-6" />
                        </div>
                        <button type="submit" class="btn btn-success mb-2">Ajouter</button>
                    </div>
                </form>
        
            </div>
        </fieldset>
        
        
        
        <fieldset class="mt-4">
            <legend align="center" class="col-auto px-0">Sous groupes</legend>
            <div class="table-responsive px-3">
                <table class="small-table  text-center table table-striped table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Sous_groupe</th>
                            <th scope="col">Nombre_utilisateurs</th>
                            <th scope="col">Retirer</th>
                        </tr>
                    </thead>
                    <tbody>
                        '.$tab_groupes.'
                    </tbody>
                </table>
        
                <form class="form-inline">
                    <div class="container-fluid row justify-content-around">
                        <div class="container col-md-9 row justify-content-around">
                            <label class="col-md-4 pb-2">Sous groupe</label>
                            <input type="text" class="form-control col-md-6" />
                        </div>
                        <button type="submit" class="btn btn-success mb-2">Ajouter</button>
                    </div>
                </form>
        
            </div>
        </fieldset>';
        }
    }
