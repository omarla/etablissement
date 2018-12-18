<?php
    require_once __DIR__ . "/../../verify.php";
    require_once __DIR__ . "/../../common/vue_generique.php";

    class VueAdministration extends VueGenerique
    {
        public function __construct($type)
        {
            $utilisateur_actif = $type === 'utilisateur' ? 'active' : '';
            $personnel_actif = $type === 'personnel' ? 'active' : '';
            $etudiants_actif = $type === 'etudiant' ? 'active' : '';
            $groupes_actif = $type === 'groupe' ? 'active' : '';
            $droits_actif = $type === 'droits' ? 'active' : '';
            $semestres_actif = $type === 'semestre' ? 'active' : '';
            $modules_actif = $type === 'module' ? 'active' : '';

            $utilisateur_selected = $type === 'utilisateur' ? 'selected' : '';
            $personnel_selected = $type === 'personnel' ? 'selected' : '';
            $etudiants_selected = $type === 'etudiant' ? 'selected' : '';
            $groupes_selected = $type === 'groupe' ? 'selected' : '';
            $droits_selected = $type === 'droits' ? 'selected' : '';
            $semestres_selected = $type === 'semestre' ? 'selected' : '';
            $modules_selected = $type === 'module' ? 'selected' : '';

            echo '            
            <div class="container-fluid row justify-content-around mt-3 mt-md-0 administration mx-auto ">
                <div class="col-lg-3 px-md-0 mb-4 container d-none d-lg-block">
            
                    <div class="list-group">
                        <a href="index.php?module=administration&type=utilisateur&action=liste_utilisateurs">
                            <button type="button" class="list-group-item list-group-item-action '. $utilisateur_actif .'">
                                Utilisateurs
                            </button>
                        </a>
                        <a href="index.php?module=administration&type=personnel&action=liste_personnels ">
                            <button type="button" class=" list-group-item list-group-item-action '. $personnel_actif .'">
                                Personnel
                            </button>
                        </a>
            
                        <a href="index.php?module=administration&type=etudiant&action=liste_etudiants ">
                            <button type="button" class=" list-group-item list-group-item-action '. $etudiants_actif .'">
                                Etudiants
                            </button>
                        </a>
            
                        <a href="index.php?module=administration&type=groupe&action=liste_groupes">
                            <button type="button" class=" list-group-item list-group-item-action '. $groupes_actif .'">
                                Groupes
                            </button>
                        </a>
            
            
                        <a href="index.php?module=administration&type=droits&action=liste_droits">
                            <button type="button" class=" list-group-item list-group-item-action '. $droits_actif .'">
                                Droits
                            </button>
                        </a>

                        <a href="index.php?module=administration&type=module&action=liste_modules">
                            <button type="button" class=" list-group-item list-group-item-action  '.$modules_actif.'">
                                Modules
                            </button>
                        </a>

                        <a href="index.php?module=administration&type=semestre&action=liste_semestre">
                            <button type="button" class=" list-group-item list-group-item-action '. $semestres_actif .'">
                                Semestres
                            </button>
                        </a>

            
                        <button type="button" class="list-group-item list-group-item-action">
                            Absences
                        </button>
            
                    </div>
                </div>

            <div class="mb-4 row justify-content-center container d-lg-none ">
                <select class="form-control col-8 col-md-6" id="administration-choice">
                    <option value="index.php?module=administration&type=utilisateur&action=liste_utilisateurs" '. $utilisateur_selected .'>Utilisateurs</option>
                    <option value="index.php?module=administration&type=personnel&action=liste_personnels" '. $personnel_selected .'>Personnel</option>
                    <option value="index.php?module=administration&type=etudiant&action=liste_etudiants" '. $etudiants_selected .'>Etudiants</option>
                    <option value="index.php?module=administration&type=groupe&action=liste_groupes" '. $groupes_selected .'>Groupes</option>
                    <option value="index.php?module=administration&type=droits&action=liste_droits" '. $droits_selected .'>Droits</option>
                    <option value="index.php?module=administration&type=module&action=liste_modules" '. $modules_selected .'>Modules</option>
                    <option value="index.php?module=administration&type=semestre&action=liste_semestre" '. $semestres_selected .'>Semestres</option>
                    <option value="" >Absences</option>
                </select>
        
            </div>

            
            <div class="col-lg-8 container content mt-2 mb-3 mt-md-0">
        ';
        }

    }
