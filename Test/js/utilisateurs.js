const MAX_OPTIONS = 5;

//Récupérer la liste des villes correspondantes à la recherche
$(document)
  .on("keyup", "#ville", function(event) {
    let start = $(this).val();

    $.ajax({
      url: "../../Prod/php/api/places.php",
      async: true,
      method: "GET",
      data: {
        type: "ville",
        start: start
      },
      success: function(data) {
        setDataListItems($("#villes"), data, "nom_ville", "code_postal_ville");
      },
      error: console.error
    });
  }) //Action a éxécuter en cas du choix d'une ville
  .on("focusout", "#ville", function(event) {
    let options = document.getElementById("villes").options;
    if (options.length > 0 && options[0].value === $(this).val())
      $("#code_postal").val(options[0].innerHTML);
  });

//Récupérer la liste des codes_postal correspondantes à la recherche
$(document)
  .on("keyup", "#code_postal", function(event) {
    let start = $(this).val();

    $.ajax({
      url: "../../Prod/php/api/places.php",
      async: true,
      method: "GET",
      data: {
        type: "code_postal",
        start: start
      },
      success: function(data) {
        setDataListItems(
          $("#codes_postal"),
          data,
          "code_postal_ville",
          "nom_ville"
        );
      },
      error: console.error
    });
  })
  .on("focusout", "#code_postal", function(event) {
    let options = document.getElementById("codes_postal").options;
    if (options.length > 0 && options[0].value === $(this).val())
      $("#ville").val(options[0].innerHTML);
  });

$(document).on("keyup", "#pays_naissance", function(event) {
  let start = $(this).val();

  $.ajax({
    url: "../../Prod/php/api/places.php",
    async: true,
    method: "GET",
    data: {
      type: "pays",
      start: start
    },
    success: function(data) {
      setDataListItems($("#pays"), data, "nom_pays", "code_pays");
    },
    error: console.error
  });
});

$.ajax({
  url: "../../Prod/php/api/fillieres_bac.php",
  async: true,
  method: "GET",
  success: function(data) {
    setDataListItems(
      $("#filliere_bac"),
      data,
      "id_filliere_bac",
      "id_filliere_bac"
    );
  }
});

function setDataListItems(datalist, data, valueName, htmlTextName) {
  data = JSON.parse(data);

  let i = 0;

  datalist.empty();

  while (i < MAX_OPTIONS && i < data.length) {
    datalist.append(
      `<option value='${data[i][valueName]}'>${data[i][htmlTextName]}</option>`
    );
    i++;
  }
}
