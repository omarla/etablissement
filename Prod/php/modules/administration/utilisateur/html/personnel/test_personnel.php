<h2 class="text-center text-dark underline mb-4 pt-2 " style="text-decoration:underline">
    Modifier Admin
</h2>


<form class="pb-2" method="post" action="index.php?module=administration&type=utilisateur&action=inscription_utilisateur">

    <div class="justify-content-center row container-fluid">
        <table class="table table-striped text-center table-hover table-bordered col-md-6 col-lg-5">
            <thead class="thead-dark ">
                <tr>
                    <th>Année</th>
                    <th>Heures travaillée</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>2018</td>
                    <td>
                        <input type="number" min="0" value="40" class="form-control table-input" name="heures_travail" />
                    </td>
                </tr>
                <tr>
                    <td>2016</td>
                    <td>360 h</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="container-fluid row justify-content-center">
        <div class="pt-2 col-auto">
            <input type="checkbox" name="estEnseignant" id="estEnseignant" />
            <label for="estEnseignant">Est Enseignant</label>
        </div>
    </div>


    <div class="container-fluid row justify-content-sm-center justify-content-around">
        <button class="btn btn-outline-success mr-sm-5">Valider</button>
        <button class="btn btn-outline-danger ml-sm-5 ">Supprimer</button>
    </div>



</form>