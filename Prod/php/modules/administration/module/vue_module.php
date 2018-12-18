<?php
    require_once __DIR__ . "/../../../verify.php";
    require_once __DIR__ . "/../../../common/vue_generique.php";

    class VueModule extends VueGenerique
    {
        public function __construct()
        {
        }

        public function afficher_modules($modules){
            echo '<h2 class="text-center text-dark underline mb-4 pt-2 underline">
                     Gestion des modules
                </h2>';
            
            $this->afficherTableau(
                $modules,
                array('ref_module',  'nom_module', 'ref_semestre','coefficient_module', 'heures_cm_module', 'heures_tp_module', 'heures_td_module'),
                'index.php?module=administration&type=module&action=afficher_module&id=',
                'ref_module',
                array('réf', 'nom', 'semestre', 'coefficient', 'CM', 'TD', 'TP')
            );

            require_once __DIR__ . "/html/ajouter_module.html";

        }


        public function afficher_module($module, $liste_enseignant){
            //On ajoute L'icone de vrai si un enseignant est_responsable
            echo '<h2 class="text-center text-dark underline mb-4 pt-2 underline">
                Modification du module '.$module['ref_module'].'
             </h2>';

            echo '
            <form
            autocomplete="off"
            method="post"
            action="index.php?module=administration&type=module&action=modifier_module&ref_module='.$module['ref_module'].'"
            >
          
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="nom_module">Nom</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nom_module"
                        name="nom_module"
                        placeholder="Base de données"
                        value='.$module["nom_module"].'
                        required
                    />
                </div>

                <div class="form-group col-md-4 ">
                    <label for="coefficient_module" class="col-md-8">Coefficient</label>
                    <input
                        type="number"
                        class="form-control"
                        min="0"
                        step="0.1"
                        id="coefficient_module"
                        name="coefficient_module"
                        placeholder="1.5"
                        value='.$module["coefficient_module"].'
                        required
                    />
                </div>

                <div class="form-group col-md-3 ">
                    <label for="couleur" class="col-md-8">Couleur</label>
                    <input
                    type="color"
                    class="form-control"
                    min="0"
                    id="couleur"
                    name="couleur"
                    placeholder="Couleur en edt"
                    value='.$module["couleur_module"].'
                    required
                    />
                </div>

            </div>
          
          
            <div class="form-row">
                <div class="form-group col-md-4 ">
                    <label for="heures_cm">Heures CM</label>
                    <input
                        type="number"
                        class="form-control"
                        min="0"
                        id="heures_cm"
                        name="heures_cm"
                        placeholder="10"
                        value='.$module["heures_cm_module"].'
                        required
                    />
                </div>
            
                <div class="form-group col-md-4 ">
                    <label for="heures_td">Heures TD</label>
                    <input
                        type="number"
                        class="form-control"
                        min="0"
                        id="heures_td"
                        name="heures_td"
                        placeholder="15"
                        value='.$module["heures_td_module"].'
                        required
                    />
                </div>

                <div class="form-group col-md-4 ">
                    <label for="heures_tp">Heures TP</label>
                    <input
                        type="number"
                        class="form-control"
                        min="0"
                        id="heures_tp"
                        name="heures_tp"
                        placeholder="20"
                        value='.$module["heures_tp_module"].'
                        required
                    />
                </div>

            </div>
                
            <div class="container-fluid row justify-content-center">
              <button type="submit" class="btn btn-success mb-2">Modifier</button>
            </div>
          </form>
          ';


          echo '<h3 class="text-center text-dark  mb-4 pt-2 underline">
                    Liste des enseignants
                </h3>';
          
          $this->afficherTableauSuppression(
              $liste_enseignant, 
              array('id_enseignant', 'nom_utilisateur', 'prenom_utilisateur', 'est_responsable'),
              'id_enseignant',
              "index.php?module=administration&type=module&action=retirer_enseignant&ref_module=${module['ref_module']}&id_enseignant=",
              array('Id', 'Nom', 'Prénom', 'Est responsable ?')
          );

          echo '
          <form action="index.php?module=administration&type=module&action=ajouter_enseignant&ref_module='.$module['ref_module'].'" method="post" class="mt-2">
        
            <div class=" container-fluid row justify-content-center mx-0 px-0 mb-2">
              <div class="form-inline container-fluid px-0">
        
                <div class="form-group col-md-4 offset-md-1 col-6">
                  <label for="pseudo_enseignant" class="sr-only">Pseudo</label>
                  <input type="text" class="form-control" id="pseudo_enseignant" name="id_enseignant" placeholder="Pseudo enseignant"
                    required />
                </div>
        
                <div class="form-check col-md-4 col-6 justify-content-center">
                  <input class="form-check-input" type="checkbox" name="estResponsable" id="estResponsable" />
                  <label class="form-check-label" for="estResponsable">
                    Responsable
                  </label>
                </div>
        
                <div class="col-md-2 col-12 row justify-content-md-end justify-content-center mt-2 mt-md-0">
                  <button class="btn btn-outline-success" type="submit">Ajouter</button>
                </div>
        
              </div>
            </div>
        
        </form>';


        echo '
        <div class="container-fluid row justify-content-center mt-4">
          <a href="index.php?module=administration&type=module&action=supprimer_module&id='.$module['ref_module'].'">
            <button class="btn btn-outline-danger" >Supprimer</button>
          </a>
        </div>
        ';
            

        }
    }
