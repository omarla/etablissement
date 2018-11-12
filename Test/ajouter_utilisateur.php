<h2 class="text-center text-dark underline mb-4 pt-2 " style="text-decoration:underline">Ajouter un utilisateur</h2>


<form class="pb-2  ">
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="nom">Nom</label>
      <input type="text" class="form-control" id="nom" name="nom" placeholder="Toto">
    </div>
    <div class="form-group col-md-4">
      <label for="prenom">Prenom</label>
      <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Titi">
    </div>
    <div class="form-group col-md-4 ">
      <label for="date_naissance">Date de naissance</label>
      <input type="date" class="form-control" id="date_naissance" name="date_naissance" placeholder="31/01/2018">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="email@domain.com">
    </div>
    <div class="form-group col-md-6">
      <label for="mot_de_passe">Mot de Passe</label>
      <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" placeholder="*********">
    </div>
  </div>

  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="civilite">civilite</label>
      <select id="civilite" name="est_homme" class="form-control">
        <option value="1" selected>Monsieur</option>
        <option value="0" >Madame</option>
      </select>
    </div>
    <div class="form-group col-md-8">
      <label for="addresse">Address</label>
      <input type="text" class="form-control" id="addresse" name="addresse" placeholder="120 Rue de la nouvelle France">
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="ville">Ville</label>
      <input type="text" class="form-control" id="ville">
    </div>
    <div class="form-group col-md-4">
      <label for="inputZip">Code postal</label>
      <input type="text" class="form-control" id="inputZip">
    </div>
    <div class="form-group col-md-4">
      <label for="pays_naissance">Pays naissance</label>
      <select id="pays_naissance" name="pays_naissance" class="form-control">
        <option value="fr" >France</option>
        <option value="ma" >Maroc</option>
        <option value="us" >Etats unis</option>
      </select>
    </div>

  </div>

  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="tel">Numéro de telephone</label>
      <input type="tel" maxlength="10" class="form-control" id="tel" name="tel" placeholder="0610203040">
    </div>
    <div class="form-group col-md-4">
      <label for="filliere_bac">Fillière bac</label>
      <select id="civilite" name="est_homme" class="form-control">
        <option value="" selected>Aucune</option>
        <option value="S" >Scientifique</option>
        <option value="L" >Littéraire</option>
        <option value="ES" >économique et social</option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="droits">Droits</label>
      <select id="droits" name="droits" class="form-control">
        <option value="" selected>Administrateur</option>
        <option value="S" >Etudiant</option>
        <option value="L" >Enseignant</option>
        <option value="ES" >Autres</option>
      </select>
    </div>

  </div>
  <div class="container-fluid row justify-content-center">
    <button type="submit" class="btn btn-outline-success ">Créer</button>
  </div>
</form>