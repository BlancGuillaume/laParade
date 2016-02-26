
jQuery(function($){
                     
  // lors du clic sur le lien connexion
  $('a.poplight').on('click', function() {
    var popID = $(this).data('rel'); // on récupère la div d'id popup1
    var popWidth = $(this).data('width');// on récupère la taille de la div d'id popup1

    // faire apparaitre la pop-up
    $('#' + popID).fadeIn().css({ 'width': popWidth}).prepend();
    
    // pour centrer pop-up
    var popMargTop = ($('#' + popID).height() + 80) / 2;
    var popMargLeft = ($('#' + popID).width() + 80) / 2;
    $('#' + popID).css({ 
      'margin-top' : -popMargTop,
      'margin-left' : -popMargLeft
    });
    
    //Apparition du fond
    $('body').append('<div id="fade"></div>');
    $('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
    
    return false;
  });
  
  
  // pour fermer pop-up : cliquer sur body
  $('body').on('click', '#fade', function() { 
    $('#fade , .popup_block').fadeOut(function() {
      $('#fade').remove();  
  });
    
    return false;
  });

  
});


function afficherImages()
{
  // on récupère l'ensemble des photos de la galerie dans $photos
  var photos = document.getElementById('ensemblePhotos') ;
  
  // on récupère tous les liens contenus dans ensemblePhotos dans $liens
  var liens = photos.getElementsByTagName('a') ;
  
  // on récupère la photo à afficher
  var photo = document.getElementById('photoAAfficher') ;
  
  var numPhoto=0;
  
  var next = document.getElementById('nextButton');
  var prev = document.getElementById('prevButton');

  // pour la supression 
  var photoASupprimer = document.getElementById('nomImageASupprimer');



  for (var i = 0 ; i < liens.length ; i++) {

    // quand on appuie sur le bouton suivant
    next.onclick = function() {
      if (numPhoto == (liens.length - 1)) {
        photo.src = liens[0].href;
        numPhoto = 0;
        document.getElementById("nomImageASupprimer").value=photo.src;
        //photoASupprimer.value = photo.alt;
      }
      else {
        photo.src = liens[numPhoto+1].href;
        numPhoto++;
        document.getElementById("nomImageASupprimer").value=photo.src;
        //photoASupprimer.value = photo.alt;
      }
      //window.location.reload();
    };

    // quand on appuie sur le bouton precedent
    prev.onclick = function() {
      if (numPhoto == 0) {
        photo.src = liens[(liens.length - 1)].href;
        numPhoto = (liens.length - 1);
        document.getElementById("nomImageASupprimer").value=photo.src;
        //photoASupprimer.value = photo.alt;
      }
      else {
        photo.src = liens[numPhoto-1].href; 
        numPhoto--;
        document.getElementById("nomImageASupprimer").value=photo.src;
        //photoASupprimer.value = photo.alt;

      }
      //window.location.reload();
    };
  } 
}

window.onload = afficherImages;