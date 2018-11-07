<!DOCTYPE html>
<html>
<head>
	
	<title></title>
	<meta charset="utf-8">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<link href="css/page-externe.css" rel="stylesheet" type="text/css"> 
	<link rel="stylesheet" href="css/menu-externe.css" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">


</head>
<body>

	<?php 
		define("CONST_INCLUDE",true);

		include_once "php/composants/menu_externe/cont_menu_externe.php" ;

		$cont = new ContMenuExterne();

		$cont->afficherMenu("Formation");
	?>


	<main>
		<div class="row container-fluid justify-content-around formations">
			<div class="col-md-3 ">
				<h2 class="nom-annee text-center">
					<span class="numero-annee">1<span class="terminaison-numero-annee"><span class="lettre-haut">er</span></span>
					</span> 
					<span class="annee-text">année</span>
				</h2>
					
					<h3 class="text-center semestre">Semestre 1</h3>
						<h4 class="UE-title">UE11</h4>
						<ul>
							<li>Système</li>
							<li>Algorithmique et programmation</li>
							<li>Bases de donées</li>
							<li>Conception de documents et d'interfaces numériques </li>
							<li>Projet tutoré</li> 
						</ul>
						<h4 class="UE-title">UE12</h4>
						<ul>
							<li>Mathématiques discrètes</li>
							<li>Algèbre linéraire</li>
							<li>Environnement économique</li>
							<li>Fonctionnement des organisations</li>
							<li>Communication</li>
							<li>Anglais</li>
							<li>PPP</li>
						</ul>
					<h3 class="text-center semestre">Semestre 2</h3>
						<h4 class="UE-title">UE21</h4>
						<ul>
							<li>Système</li>
							<li>Réseaux</li>
							<li>Programmation orientée objet</li>
							<li>Interfaces homme-machine</li>
							<li>Bases de données</li>
							<li>Projet tutoré</li>
						</ul>
						<h4 class="UE-title">UE22</h4>
						<ul>
							<li>Graphes</li>
							<li>Analyse</li>
							<li>Gestion de projet</li>
							<li>Communication</li>
							<li>Anglais</li>
							<li>PPP</li>
						</ul>
			</div>

			<div class="col-md-3 ">
				<h2 class="nom-annee text-center">
					<span class="numero-annee">2<span class="terminaison-numero-annee"><span class="lettre-haut">ème</span></span>
					</span> 
					<span class="annee-text">année</span>
				</h2>
					<h3 class="text-center semestre">Semestre 3</h3>
						<h4 class="UE-title">UE31</h4>
						<ul>
							<li>Principes des systèmes d'exploitation</li>
							<li>Services réseaux</li>
							<li>Algorithmique avancée</li>
							<li>Programmation web</li>
							<li>Conception et programmation objet avancées</li>
						</ul>
						<h4 class="UE-title">UE32</h4>
						<ul>
							<li>Probabilités et statistiques</li>
							<li>Modélisations mathématiques</li>
							<li>Droit</li>
							<li>Gestion des sytèmes d'information</li>
							<li>Communication</li>
							<li>Anglais</li>
						</ul>
						<h4 class="UE-title">UE33</h4>
						<ul>
							<li>Methodologie</li>
							<li>Projet tutoré</li>
							<li>PPP</li>
						</ul>
					<h3 class="text-center semestre">Semestre 4</h2>
						<h4 class="UE-title">UE41</h3>
						<ul>
							<li>Administration système et réseau</li>
							<li>Programmation répartie</li>
							<li>Programmation web</li>
							<li>Conception et développement d'applications mobiles</li>
							<li>Compléments d'informatique en vue d'une insertion immédiate</li>
							<li>Projet tutoré</li>
						</ul>
						<h4 class="UE-title">UE42</h4>
						<ul>
							<li>Ateliers de création d'entreprise</li>
							<li>Recherche opérationnelle et aide à la décision</li>
							<li>Communication</li>
							<li>Anglais</li>
						</ul>
						<h4 class="UE-title">UE43</h4>
						<ul>
							<li>Stage professionnel</li>
						</ul>
			</div>


			<div class="col-md-5">
				<h2 class="nom-annee text-center">
					<span class="numero-annee">3<span class="terminaison-numero-annee"><span class="lettre-haut">ème</span></span>
					</span> 
					<span class="annee-text">année(licence professionnelle)</span>
				</h2>

						<h3 class="text-center semestre">Bases de l'informatique et des systèmes d'information</h3>
						<ul>
							<li>Architecture logicielle</li>
							<li>Programmation Java</li>
							<li>Introduction aux systèmes d'information</li>
						</ul>	
						<h3 class="text-center semestre">Culture de l'entreprise</h3>
						<ul>
							<li>Approche fonctionnelle des SI</li>
							<li>Ingénierie de la qualité et du contrat de service</li>
							<li>Droit, économie, communication, anglais</li>
						</ul>
						<h3 class="text-center semestre">Méthodes et systèmes informatiques avancés</h3>
						<ul>
							<li>Méthodes d’analyse et de conception</li>
							<li>Bases de données avancées</li>
							<li>Ingénierie des systèmes décisionnels</li>
							<li>Interfaces homme-machine</li>
							<li>Bases de données</li>
							<li>Architecture logicielles Programmation Java</li>
						</ul>
			</div>
		</div>
	</main>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>