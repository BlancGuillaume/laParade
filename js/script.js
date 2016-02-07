
jQuery(function($){
                     
  //Lorsque vous cliquez sur un lien de la classe poplight
  $('a.poplight').on('click', function() {
    var popID = $(this).data('rel'); //Trouver la pop-up correspondante
    var popWidth = $(this).data('width'); //Trouver la largeur

    //Faire apparaitre la pop-up et ajouter le bouton de fermeture
    $('#' + popID).fadeIn().css({ 'width': popWidth}).prepend();
    
    //Récupération du margin, qui permettra de centrer la fenêtre - on ajuste de 80px en conformité avec le CSS
    var popMargTop = ($('#' + popID).height() + 80) / 2;
    var popMargLeft = ($('#' + popID).width() + 80) / 2;
    
    //Apply Margin to Popup
    $('#' + popID).css({ 
      'margin-top' : -popMargTop,
      'margin-left' : -popMargLeft
    });
    
    //Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues d'anciennes versions de IE
    $('body').append('<div id="fade"></div>');
    $('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();
    
    return false;
  });
  
  
  //Close Popups and Fade Layer
  $('body').on('click', 'a.close, #fade', function() { //Au clic sur le body...
    $('#fade , .popup_block').fadeOut(function() {
      $('#fade, a.close').remove();  
  }); //...ils disparaissent ensemble
    
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


  for (var i = 0 ; i < liens.length ; i++) {

    // quand on appuie sur le bouton suivant
    next.onclick = function() {
      if (numPhoto == (liens.length - 1)) {
        photo.src = liens[0].href;
        numPhoto = 0;
      }
      else {
        photo.src = liens[numPhoto+1].href;
        numPhoto++;
      }
    };

    // quand on appuie sur le bouton precedent
    prev.onclick = function() {
      if (numPhoto == 0) {
        photo.src = liens[(liens.length - 1)].href;
        numPhoto = (liens.length - 1);
      }
      else {
        photo.src = liens[numPhoto-1].href; 
        numPhoto--;
      }
    };
  } 
}

window.onload = afficherImages;