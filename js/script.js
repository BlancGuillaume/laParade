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