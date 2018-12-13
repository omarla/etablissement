</tbody>
</table>
<form action="index.php?module=administration&type=utilisateur&action=ajouter_personnel" method="post">
  <fieldset class="container-fluid mx-0 row justify-content-center  mb-1">

    <legend class="col-auto px-0" align="center">Ajouter un personnel</legend>

    <div class=" container-fluid row justify-content-center mx-0 px-0 mb-2">
      <div class="form-inline container-fluid px-0">

        <div class="form-group col-md-4 col-6">
          <label for="pseudo" class="sr-only">Pseudo</label>
          <input type="text" class="form-control"  id="pseudo" name="pseudo" placeholder="Pseudo utilisateur"
            required />
        </div>

        <div class="form-check col-md-6 col-6 justify-content-center">
          <input class="form-check-input" type="checkbox" name="estEnseignant" id="estEnseignant" />
          <label class="form-check-label" for="estEnseignant">
            Enseignant
          </label>
        </div>

        <div class="col-md-2 col-12 row justify-content-md-end justify-content-center mt-2 mt-md-0">
          <button class="btn btn-outline-success" type="submit">Ajouter</button>
        </div>

      </div>
    </div>
  </fieldset>

</form>