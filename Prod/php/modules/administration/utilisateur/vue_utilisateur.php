<?php
    require_once "php/verify.php";
    
    class VueUtilisateur
    {
        public function __construct()
        {
        }


        private function afficherListeDroits($droits, $value = '')
        {
            echo '<select id="droits" value="'.$value.'" name="droits" class="form-control" required>';
            $first = false;
            foreach ($droits as $droit) {
                echo "<option value='${droit}'>${droit}</option>";
            }

            echo '</select>';
        }



        /****************************************************************************************************/
        /*******************************************UTILISATEURS*********************************************/
        /****************************************************************************************************/



        public function afficherInsertionUtilisateurs($liste_droits)
        {
            require_once __DIR__ . "/html/utilisateur/ajouter_utilisateur_1.php";

            $this->afficherListeDroits($liste_droits);

            require_once __DIR__ . "/html/utilisateur/ajouter_utilisateur_2.php";
        }


        public function afficherListeUtilisateurs($liste_utilisateurs)
        {
            require_once __DIR__ . "/html/utilisateur/afficher_utilisateurs_1.php";
            
            if (count($liste_utilisateurs) == 0) {
                echo "<tr><td colspan=6 class='text-center text-secondary'> Aucun utilisateur n'a été trouvé </td></tr>";
            }

            foreach ($liste_utilisateurs as $utilisateur) {
                echo "            
                    
                        <tr onclick=\"document.location = 'index.php?module=administration&action=modification&type=utilisateur&id=${utilisateur['id']}'\">
                            <td class='text-primary'>${utilisateur['id']}</td>
                            <td>${utilisateur['nom']}</td>
                            <td>${utilisateur['prenom']}</td>
                            <td>${utilisateur['tel']}</td>
                            <td>${utilisateur['mail']}</td>
                            <td>${utilisateur['date_naissance']}</td>
                        </tr>
                        
                    ";
            }

            require_once __DIR__ . "/html/utilisateur/afficher_utilisateurs_2.php";
        }


        public function afficherUtilisateur($utilisateur, $liste_droits)
        {
            if ($utilisateur) {
                echo "
                <h2
                class='text-center text-dark underline mb-4 pt-2 '
                style='text-decoration:underline'
              >
                Profil de ${utilisateur['pseudo_utilisateur']}
              </h2>
              
              <form class='pb-2' method='post' action='index.php?module=administration&type=utilisateur&action=modification_utilisateur&id=${utilisateur['id_utilisateur']}'>
                <div class='form-row'>
                  <div class='form-group col-md-4'>
                    <label for='nom'>Nom</label>
                    <input
                      type='text'
                      class='form-control'
                      id='nom'
                      name='nom'
                      placeholder='Toto'
                      value='${utilisateur['nom_utilisateur']}'
                      required
                    />
                  </div>
                  <div class='form-group col-md-4'>
                    <label for='prenom'>Prenom</label>
                    <input
                      type='text'
                      class='form-control'
                      id='prenom'
                      name='prenom'
                      placeholder='Titi'
                      value='${utilisateur['prenom_utilisateur']}'
                      required
                    />
                  </div>
                  <div class='form-group col-md-4 '>
                    <label for='date_naissance'>Date de naissance</label>
                    <input
                      type='date'
                      class='form-control'
                      id='date_naissance'
                      name='date_naissance'
                      placeholder='31/01/2018'
                      value='${utilisateur['date_naissance_utilisateur']}'
                      required
                    />
                  </div>
                </div>
              
                <div class='form-row'>
                  <div class='form-group col-md-6'>
                    <label for='email'>Email</label>
                    <input
                      type='email'
                      class='form-control'
                      id='email'
                      name='email'
                      placeholder='email@domain.com'
                      value='${utilisateur['mail_utilisateur']}'
                      required
                    />
                  </div>
                  <div class='form-group col-md-6'>
                    <label for='mot_de_passe'>Mot de Passe</label>
                    <input
                      type='password'
                      class='form-control'
                      id='mot_de_passe'
                      name='mot_de_passe'
                      placeholder='*********'
                    />
                  </div>
                </div>
              
                <div class='form-row'>
                  <div class='form-group col-md-4'>
                    <label for='civilite'>civilite</label>
                    <select 
                        id='civilite' 
                        name='est_homme' 
                        class='form-control' 
                        value='value='${utilisateur['est_homme']}'
                        required>
                      <option value='1'>Monsieur</option>
                      <option value='0'>Madame</option>
                    </select>
                  </div>
                  <div class='form-group col-md-8'>
                    <label for='addresse'>Address</label>
                    <input
                      type='text'
                      class='form-control'
                      id='addresse'
                      name='addresse'
                      value='${utilisateur['adresse_utilisateur']}'
                      placeholder='120 Rue de la nouvelle France'
                      required
                    />
                  </div>
                </div>
              
                <div class='form-row'>
                  <div class='form-group col-md-4'>
                    <label for='ville'>Ville</label>
                    <input 
                        type='text' 
                        list='villes' 
                        class='form-control' 
                        id='ville' 
                        value='${utilisateur['nom_ville']}'
                    />
                  </div>
                  <div class='form-group col-md-4'>
                    <label for='code_postal'>Code postal</label>
                    <input
                      type='text'
                      list='codes_postal'
                      class='form-control'
                      id='code_postal'
                      name='code_postal'
                      value='${utilisateur['code_postal_ville']}'
                      required
                    />
                  </div>
                  <div class='form-group col-md-4'>
                    <label for='pays_naissance' >Pays naissance</label>
                    <input  id='pays_naissance' 
                            list='pays' type='text'
                            name='pays_naissance'
                            class='form-control' 
                            value='${utilisateur['nom_pays']}'
                            required
                    >
                  </div>
                </div>
              
                <div class='form-row'>
                  <div class='form-group col-md-4'>
                    <label for='tel'>Numéro de telephone</label>
                    <input
                      type='tel'
                      maxlength='10'
                      class='form-control'
                      id='tel'
                      name='tel'
                      placeholder='0610203040'
                      value='${utilisateur['tel_utilisateur']}'
                      required
                    />
                  </div>
                  <div class='form-group col-md-4'>
                    <label for='filliere_bac'>Fillière bac</label>
                    <select 
                        id='filliere_bac' 
                        name='filliere_bac' 
                        value='${utilisateur['id_filliere_bac']}'
                        class='form-control'
                        required 
                        >
                    </select>
                  </div>
              
                  <div class='form-group col-md-4'>
                    <label for='droits'>Droits</label>
                ";
                $this->afficherListeDroits($liste_droits, '');

                require_once __DIR__ . "/html/utilisateur/afficher_utilisateur_end.php";
                ;
            }
        }



        /****************************************************************************************************/
        /*******************************************PERSONNELS*********************************************/
        /****************************************************************************************************/
   
   
        public function afficherListePersonnels($liste_personnels)
        {
            require_once __DIR__ . "/html/personnel/afficher_liste_personnel_1.php";
  
            if (count($liste_personnels) == 0) {
                echo "<tr><td colspan=6 class='text-center text-secondary'> Aucun personnel n'a été trouvé </td></tr>";
            }

            foreach ($liste_personnels as $personnel) {
                echo "            
                        <tr onclick=\"document.location = 'index.php?module=administration&action=afficher_modification_personnel&type=utilisateur&id=${personnel['id']}'\">
                            <td class='align-middle text-center text-primary'>${personnel['id']}</td>
                            <td class='align-middle text-center'>${personnel['nom']}</td>
                            <td class='align-middle text-center'>${personnel['prenom']}</td>
                      ";
                
                if ($personnel['num_enseignant']) {
                    echo "<td class='text-success text-center align-middle '><i class=' text-center fas fa-check'></i></td>";
                } else {
                    echo "<td class='text-danger text-center align-middle'><i class='far fa-times-circle'></i></td>";
                }

                echo "<td class='align-middle text-center'>${personnel['heures_travail']}</td></tr>";
            }

            require_once __DIR__ . "/html/personnel/afficher_liste_personnel_2.php";
        }
    }
