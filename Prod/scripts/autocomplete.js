if (
  initVars.url.module === "administration" &&
  initVars.url.type === "utilisateur" &&
  (initVars.url.action === "modification" ||
    initVars.url.action === "afficherCreationUtilisateur")
) {
  var villes = [];

  $("input#ville")
    .flexdatalist({
      selectionRequired: true,
      minLength: 0,
      visibleProperties: ["nom_ville", "code_postal_ville"],
      searchIn: ["nom_ville", "code_postal_ville"],
      valueProperty: "nom_ville",
      data: "php/api/index.php?type=utilisateur&action=ville"
    })
    .on("select:flexdatalist", function(instance, value, options) {
      $("input#code_postal").flexdatalist("value", value.code_postal_ville);
    });

  $("input#code_postal")
    .flexdatalist({
      selectionRequired: true,
      minLength: 0,
      visibleProperties: ["code_postal_ville", "nom_ville"],
      searchIn: ["code_postal_ville", "nom_ville"],
      valueProperty: "code_postal_ville",
      data: "php/api/index.php?type=utilisateur&action=ville"
    })
    .on("select:flexdatalist", function(instance, value, options) {
      $("input#ville").flexdatalist("value", value.nom_ville);
    });

  $("input#pays_naissance").flexdatalist({
    selectionRequired: true,
    minLength: 0,
    visibleProperties: ["nom_pays", "code_pays"],
    searchIn: ["nom_pays", "code_pays"],
    valueProperty: "nom_pays",
    data: "php/api/index.php?type=utilisateur&action=pays"
  });
}

if (
  initVars.url.module === "administration" &&
  initVars.url.type === "personnel" &&
  initVars.url.action === "liste_personnels"
) {
  $("input#pseudo").flexdatalist({
    selectionRequired: true,
    minLength: 0,
    visibleProperties: "pseudo",
    searchIn: "pseudo",
    valueProperty: "pseudo",
    cache: false,
    data: "php/api/index.php?type=utilisateur&action=pseudo_personnel"
  });
}

if (
  initVars.url.module === "administration" &&
  initVars.url.type === "groupe" &&
  initVars.url.action === "afficher_modification"
) {
  var id_groupe = new URL(window.location.href).searchParams.get("id");

  $("input#pseudo_utilisateur").flexdatalist({
    selectionRequired: true,
    minLength: 0,
    visibleProperties: "pseudo_utilisateur",
    searchIn: "pseudo_utilisateur",
    valueProperty: "id_utilisateur",
    cache: false,
    data: "php/api/index.php?type=groupe&action=utilisateurs&id=" + id_groupe
  });

  $("input#groupe_fils").flexdatalist({
    selectionRequired: true,
    minLength: 0,
    visibleProperties: "nom_groupe",
    searchIn: "nom_groupe",
    valueProperty: "id_groupe",
    cache: false,
    data: "php/api/index.php?type=groupe&action=sous_groupes&id=" + id_groupe
  });
}
