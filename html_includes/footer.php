<footer>
  <?php if (isset($_SESSION['login'])) : ?>
     <a id="lienEspaceUtilisateur" href="deconnexion.php">Deconnexion</a>
  <?php else : ?>
     <a id="lienEspaceUtilisateur" href="#" data-width="500" data-rel="popup1" class="poplight">Connexion</a>
  <?php endif; ?>
</footer>
<div id="popup1" class="popup_block">
  <form action="connexion.php" method="post">
     <h5>Connexion</h5>
     <div class="row">   
        <div class="col s12">
           <div class="input-field col s12">
              <i class="material-icons prefix">mail</i>
              <input id="mailUtilisateur" name="mailUtilisateur" type="text" class="validate">
              <label for="mailUtilisateur">Mail</label>
           </div>
           <div class="input-field col s12">
              <i class="material-icons prefix">vpn_key</i>
              <input id="mdpUtilisateur" name="mdpUtilisateur" type="password" class="validate">
              <label for="mdpUtilisateur">Mot de passe</label>
           </div>
        </div>
     </div>
     <div id="conteneurBouton">
        <button id="boutonConnexion" class="btn waves-effect waves-light" type="submit"  name="action">Connexion
           <i class="material-icons right">send</i>
        </button>
     </div>
  </form>
</div>