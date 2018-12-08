$(document)
    .on("keyup", "#groupe_fils", function (event) {
        let start = $(this).val();

        console.log(start);
        $.ajax({
            url: "php/api/index.php",
            async: true,
            method: "GET",
            data: {
                type: "groupe",
                action: "sous_groupes",
                id: new URL(document.location.href).searchParams.get('id'),
                start: start
            },
            success: function (data) {
                setDataListItems($("#groupes_fils"), data, "id_groupe", "nom_groupe");
            },
            error: console.error
        });
    });

$(document)
    .on("keyup", "#pseudo_utilisateur", function (event) {
        let start = $(this).val();

        console.log(start);
        $.ajax({
            url: "php/api/index.php",
            async: true,
            method: "GET",
            data: {
                type: "groupe",
                action: "utilisateurs",
                id: new URL(document.location.href).searchParams.get('id'),
                start: start
            },
            success: function (data) {
                setDataListItems($("#pseudos_utilisateurs"), data, "pseudo_utilisateur", "id_utilisateur");
            },
            error: console.error
        });
    });