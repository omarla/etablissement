-----------------------------------
-- Table `2875442_projet`.`filliere_bac`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`filliere_bac` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`filliere_bac` (
  `id_filliere_bac` VARCHAR(20) NOT NULL,
  `nom_filliere_bac` VARCHAR(90) NULL,
  PRIMARY KEY (`id_filliere_bac`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`pays`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`pays` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`pays` (
  `code_pays` VARCHAR(5) NOT NULL,
  `nom_pays` VARCHAR(45) NULL,
  `nationalite` VARCHAR(45) NULL,
  PRIMARY KEY (`code_pays`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`Ville`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`Ville` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`Ville` (
  `code_postal_ville` VARCHAR(8) NOT NULL,
  `nom_ville` VARCHAR(65) NULL,
  PRIMARY KEY (`code_postal_ville`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`utilisateur`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`utilisateur` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`utilisateur` (
  `id_utilisateur` INT NOT NULL AUTO_INCREMENT,
  `pseudo_utilisateur` VARCHAR(45) NULL,
  `mail_utilisateur` VARCHAR(200) NULL,
  `nom_utilisateur` VARCHAR(45) NULL,
  `prenom_utilisateur` VARCHAR(45) NULL,
  `tel_utilisateur` VARCHAR(10) NULL,
  `adresse_utilisateur` VARCHAR(150) NULL,
  `est_homme` TINYINT NULL,
  `date_naissance_utilisateur` DATE NULL,
  `mot_de_passe_utilisateur` VARCHAR(60) NULL,
  `cle_recuperation_mdp` VARCHAR(80) ,
  `date_creation_compte` DATE ,
  `id_filliere_bac` VARCHAR(20) NULL,
  `code_pays` VARCHAR(5) NULL,
  `code_postal_ville` VARCHAR(8) NULL,
  PRIMARY KEY (`id_utilisateur`),
  CONSTRAINT `fk_utilisateur_filliere_bac1`
    FOREIGN KEY (`id_filliere_bac`)
    REFERENCES `2875442_projet`.`filliere_bac` (`id_filliere_bac`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_utilisateur_pays1`
    FOREIGN KEY (`code_pays`)
    REFERENCES `2875442_projet`.`pays` (`code_pays`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_utilisateur_Ville1`
    FOREIGN KEY (`code_postal_ville`)
    REFERENCES `2875442_projet`.`Ville` (`code_postal_ville`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `pseudo_utilisateur_UNIQUE` ON `2875442_projet`.`utilisateur` (`pseudo_utilisateur` ASC);

CREATE UNIQUE INDEX `mail_utilisateur_UNIQUE` ON `2875442_projet`.`utilisateur` (`mail_utilisateur` ASC);


-- -----------------------------------------------------
-- Table `2875442_projet`.`droits`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`droits` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`droits` (
  `nom_droits` VARCHAR(60) NOT NULL,
  `droit_creation_groupes` TINYINT NULL,
  `droit_creation_modules` TINYINT NULL,
  `droit_creation_lecons` TINYINT NULL,
  `droit_creation_utilisateurs` TINYINT NULL,
  `droit_modification_absences` TINYINT NULL,
  `droit_modification_droits` TINYINT NULL,
  `droit_modification_edt` TINYINT NULL,
  `droit_modification_donnees_utilisateur` TINYINT NULL,
  `droit_modification_heures_travail` TINYINT NULL,
  `droit_visualisation_stats` TINYINT NULL,
  `droit_visualisation_heures_travail` TINYINT NULL,
  PRIMARY KEY (`nom_droits`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`a_droits_de`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`a_droits_de` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`a_droits_de` (
  `nom_droits` VARCHAR(60) NOT NULL,
  `id_utilisateur` INT NOT NULL,
  PRIMARY KEY (`nom_droits`, `id_utilisateur`),
  CONSTRAINT `fk_table2_has_table1_table2`
    FOREIGN KEY (`nom_droits`)
    REFERENCES `2875442_projet`.`droits` (`nom_droits`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_table2_has_table1_table11`
    FOREIGN KEY (`id_utilisateur`)
    REFERENCES `2875442_projet`.`utilisateur` (`id_utilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`groupe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`groupe` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`groupe` (
  `id_groupe` INT NOT NULL AUTO_INCREMENT,
  `nom_groupe` VARCHAR(45) NULL,
  PRIMARY KEY (`id_groupe`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `nom_groupe_UNIQUE` ON `2875442_projet`.`groupe` (`nom_groupe` ASC);


-- -----------------------------------------------------
-- Table `2875442_projet`.`ont_droits_de`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`ont_droits_de` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`ont_droits_de` (
  `nom_droits` VARCHAR(60) NOT NULL,
  `id_groupe` INT NOT NULL,
  PRIMARY KEY (`nom_droits`, `id_groupe`),
  CONSTRAINT `fk_droits_has_groupe_droits1`
    FOREIGN KEY (`nom_droits`)
    REFERENCES `2875442_projet`.`droits` (`nom_droits`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_droits_has_groupe_groupe1`
    FOREIGN KEY (`id_groupe`)
    REFERENCES `2875442_projet`.`groupe` (`id_groupe`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`utilisateur_appartient_a_groupe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`utilisateur_appartient_a_groupe` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`utilisateur_appartient_a_groupe` (
  `id_groupe` INT NOT NULL,
  `id_utilisateur` INT NOT NULL,
  `utilisateur_appartient_a_groupecol` VARCHAR(45) NULL,
  PRIMARY KEY (`id_groupe`, `id_utilisateur`),
  CONSTRAINT `fk_groupe_has_utilisateur_groupe1`
    FOREIGN KEY (`id_groupe`)
    REFERENCES `2875442_projet`.`groupe` (`id_groupe`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_groupe_has_utilisateur_utilisateur1`
    FOREIGN KEY (`id_utilisateur`)
    REFERENCES `2875442_projet`.`utilisateur` (`id_utilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`etudiant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`etudiant` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`etudiant` (
  `numero_etudiant` VARCHAR(15) NOT NULL,
  `points_ets_etudiant` INT NULL,
  `id_utilisateur` INT NULL,
  PRIMARY KEY (`numero_etudiant`),
  CONSTRAINT `fk_etudiant_utilisateur1`
    FOREIGN KEY (`id_utilisateur`)
    REFERENCES `2875442_projet`.`utilisateur` (`id_utilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_utilisateur_UNIQUE` ON `2875442_projet`.`etudiant` (`id_utilisateur` ASC);


-- -----------------------------------------------------
-- Table `2875442_projet`.`est_un_sous_groupe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`est_un_sous_groupe` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`est_un_sous_groupe` (
  `id_groupe_parent` INT NOT NULL,
  `id_groupe_fils` INT NOT NULL,
  PRIMARY KEY (`id_groupe_parent`, `id_groupe_fils`),
  CONSTRAINT `fk_groupe_has_groupe_groupe1`
    FOREIGN KEY (`id_groupe_parent`)
    REFERENCES `2875442_projet`.`groupe` (`id_groupe`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_groupe_has_groupe_groupe2`
    FOREIGN KEY (`id_groupe_fils`)
    REFERENCES `2875442_projet`.`groupe` (`id_groupe`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`personnel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`personnel` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`personnel` (
  `id_personnel` INT NOT NULL,
  `id_utilisateur` INT NOT NULL,
  `formation_personnel` MEDIUMTEXT NULL,
  PRIMARY KEY (`id_personnel`, `id_utilisateur`),
  CONSTRAINT `fk_personnel_utilisateur1`
    FOREIGN KEY (`id_utilisateur`)
    REFERENCES `2875442_projet`.`utilisateur` (`id_utilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`mission_personnel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`mission_personnel` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`mission_personnel` (
  `id_mission` VARCHAR(30) NOT NULL,
  `nom_misssion` VARCHAR(45) NULL,
  PRIMARY KEY (`id_mission`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`personnel_a_pour_misssion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`personnel_a_pour_misssion` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`personnel_a_pour_misssion` (
  `personnel_id_personnel` INT NOT NULL,
  `mission_personnel_id_mission` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`personnel_id_personnel`, `mission_personnel_id_mission`),
  CONSTRAINT `fk_personnel_has_mission_personnel_personnel1`
    FOREIGN KEY (`personnel_id_personnel`)
    REFERENCES `2875442_projet`.`personnel` (`id_personnel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_personnel_has_mission_personnel_mission_personnel1`
    FOREIGN KEY (`mission_personnel_id_mission`)
    REFERENCES `2875442_projet`.`mission_personnel` (`id_mission`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`departement`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`departement` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`departement` (
  `id_departement` INT NOT NULL,
  `nom_departement` VARCHAR(45) NULL,
  `id_personnel_responsable` INT NOT NULL,
  PRIMARY KEY (`id_departement`),
  CONSTRAINT `fk_departement_personnel1`
    FOREIGN KEY (`id_personnel_responsable`)
    REFERENCES `2875442_projet`.`personnel` (`id_personnel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`formation_proposes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`formation_proposes` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`formation_proposes` (
  `id_formation` INT NOT NULL,
  `nom_formation` VARCHAR(80) NULL,
  `id_departement_concerne` INT NOT NULL,
  PRIMARY KEY (`id_formation`),
  CONSTRAINT `fk_formation_proposes_departement1`
    FOREIGN KEY (`id_departement_concerne`)
    REFERENCES `2875442_projet`.`departement` (`id_departement`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`type_semestre`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`type_semestre` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`type_semestre` (
  `id_type_semestre` INT NOT NULL,
  `nom_type_semestre` VARCHAR(200) NULL,
  `points_ets_semestre` MEDIUMINT(9) NULL,
  `id_formation` INT NOT NULL,
  PRIMARY KEY (`id_type_semestre`),
  CONSTRAINT `fk_type_semestre_formation_proposes1`
    FOREIGN KEY (`id_formation`)
    REFERENCES `2875442_projet`.`formation_proposes` (`id_formation`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`module`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`module` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`module` (
  `id_module` INT NOT NULL AUTO_INCREMENT,
  `reference_module` VARCHAR(8) NULL,
  `nom_module` VARCHAR(45) NULL,
  `coefficient_module` FLOAT NULL,
  `heures_cm_module` FLOAT NULL,
  `heures_td_module` FLOAT NULL,
  `heures_tp_module` FLOAT NULL,
  `type_semestre` INT NOT NULL,
  PRIMARY KEY (`id_module`),
  CONSTRAINT `fk_module_type_semestre1`
    FOREIGN KEY (`type_semestre`)
    REFERENCES `2875442_projet`.`type_semestre` (`id_type_semestre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`enseignant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`enseignant` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`enseignant` (
  `num_enseignant` INT NOT NULL AUTO_INCREMENT,
  `id_personnel` INT NOT NULL,
  PRIMARY KEY (`num_enseignant`),
  CONSTRAINT `fk_enseignant_personnel2`
    FOREIGN KEY (`id_personnel`)
    REFERENCES `2875442_projet`.`personnel` (`id_personnel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_personnel_UNIQUE` ON `2875442_projet`.`enseignant` (`id_personnel` ASC);


-- -----------------------------------------------------
-- Table `2875442_projet`.`annee`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`annee` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`annee` (
  `annee` INT NOT NULL,
  PRIMARY KEY (`annee`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`heures_travail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`heures_travail` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`heures_travail` (
  `id_heures_travail` INT NOT NULL,
  `heures_travail` INT(11) NULL,
  `annee` INT NOT NULL,
  `num_enseignant` INT NOT NULL,
  PRIMARY KEY (`id_heures_travail`),
  CONSTRAINT `fk_heures_travail_annee1`
    FOREIGN KEY (`annee`)
    REFERENCES `2875442_projet`.`annee` (`annee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_heures_travail_enseignant1`
    FOREIGN KEY (`num_enseignant`)
    REFERENCES `2875442_projet`.`enseignant` (`num_enseignant`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`module_enseigner_par`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`module_enseigner_par` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`module_enseigner_par` (
  `enseignant_num_enseignant` INT NOT NULL,
  `module_id_module` INT NOT NULL,
  PRIMARY KEY (`enseignant_num_enseignant`, `module_id_module`),
  CONSTRAINT `fk_enseignant_has_module_enseignant1`
    FOREIGN KEY (`enseignant_num_enseignant`)
    REFERENCES `2875442_projet`.`enseignant` (`num_enseignant`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_enseignant_has_module_module1`
    FOREIGN KEY (`module_id_module`)
    REFERENCES `2875442_projet`.`module` (`id_module`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`semestre`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`semestre` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`semestre` (
  `id_semestre` INT NOT NULL,
  `nom_semestre` VARCHAR(90) NULL,
  `annee_semestre` INT NOT NULL,
  `id_groupe_semestre` INT NOT NULL,
  `points_semestre` VARCHAR(45) NULL,
  `type_semestre_id_type_semestre` INT NOT NULL,
  PRIMARY KEY (`id_semestre`),
  CONSTRAINT `fk_semstres_annee1`
    FOREIGN KEY (`annee_semestre`)
    REFERENCES `2875442_projet`.`annee` (`annee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_semstre_groupe1`
    FOREIGN KEY (`id_groupe_semestre`)
    REFERENCES `2875442_projet`.`groupe` (`id_groupe`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_semstre_type_semestre1`
    FOREIGN KEY (`type_semestre_id_type_semestre`)
    REFERENCES `2875442_projet`.`type_semestre` (`id_type_semestre`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`batiment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`batiment` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`batiment` (
  `id_batiment` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`id_batiment`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`type_salle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`type_salle` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`type_salle` (
  `type_salle` INT NOT NULL,
  PRIMARY KEY (`type_salle`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`salle`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`salle` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`salle` (
  `id_salle` INT NOT NULL,
  `nom_salle` VARCHAR(45) NULL,
  `type_salle` INT NOT NULL,
  `id_batiment` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`id_salle`),
  CONSTRAINT `fk_salle_type_salle1`
    FOREIGN KEY (`type_salle`)
    REFERENCES `2875442_projet`.`type_salle` (`type_salle`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_salle_batiment1`
    FOREIGN KEY (`id_batiment`)
    REFERENCES `2875442_projet`.`batiment` (`id_batiment`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`batiments_de_departement`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`batiments_de_departement` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`batiments_de_departement` (
  `departement_id_departement` INT NOT NULL,
  `batiment_id_batiment` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`departement_id_departement`, `batiment_id_batiment`),
  CONSTRAINT `fk_departement_has_batiment_departement1`
    FOREIGN KEY (`departement_id_departement`)
    REFERENCES `2875442_projet`.`departement` (`id_departement`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_departement_has_batiment_batiment1`
    FOREIGN KEY (`batiment_id_batiment`)
    REFERENCES `2875442_projet`.`batiment` (`id_batiment`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`jour_travail`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`jour_travail` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`jour_travail` (
  `id_jour_travail` INT NOT NULL,
  `jour_travail` DATE NULL,
  `id_departement` INT NOT NULL,
  `annee` INT NOT NULL,
  PRIMARY KEY (`id_jour_travail`),
  CONSTRAINT `fk_jour_travail_departement1`
    FOREIGN KEY (`id_departement`)
    REFERENCES `2875442_projet`.`departement` (`id_departement`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_jour_travail_annee1`
    FOREIGN KEY (`annee`)
    REFERENCES `2875442_projet`.`annee` (`annee`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`type_seance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`type_seance` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`type_seance` (
  `id_type_seance` VARCHAR(10) NOT NULL,
  `nom_complet_type_seance` VARCHAR(45) NOT NULL,
  `couleur_seance` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`id_type_seance`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `2875442_projet`.`seance`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `2875442_projet`.`seance` ;

CREATE TABLE IF NOT EXISTS `2875442_projet`.`seance` (
  `id_seance` INT NOT NULL,
  `heure_depart` TIME NULL,
  `duree_seance` FLOAT NULL,
  `jour_travail` INT NOT NULL,
  `id_groupe` INT NOT NULL,
  `id_type_seance` VARCHAR(10) NOT NULL,
  `id_module` INT NOT NULL,
  PRIMARY KEY (`id_seance`),
  CONSTRAINT `fk_seance_jour_travail1`
    FOREIGN KEY (`jour_travail`)
    REFERENCES `2875442_projet`.`jour_travail` (`id_jour_travail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_seance_groupe1`
    FOREIGN KEY (`id_groupe`)
    REFERENCES `2875442_projet`.`groupe` (`id_groupe`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_seance_type_seance1`
    FOREIGN KEY (`id_type_seance`)
    REFERENCES `2875442_projet`.`type_seance` (`id_type_seance`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_seance_module1`
    FOREIGN KEY (`id_module`)
    REFERENCES `2875442_projet`.`module` (`id_module`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

