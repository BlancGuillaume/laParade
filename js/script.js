function displayPics()
{
  var photos = document.getElementById('galerie_mini') ;
  // On récupère l'élément ayant pour id galerie_mini
  var liens = photos.getElementsByTagName('a') ;
  // On récupère dans une variable tous les liens contenu dans galerie_mini
  var big_photo = document.getElementById('big_pict') ;
  // Ici c'est l'élément ayant pour id big_pict qui est récupéré, c'est notre photo en taille normale

  var titre_photo = document.getElementById('photo').getElementsByTagName('dt')[0] ;
  // Et enfin le titre de la photo de taille normale
  
  var posPhoto=0;
  
  var next = document.getElementById('nextButton');
  var prev = document.getElementById('prevButton');

  // Une boucle parcourant l'ensemble des liens contenu dans galerie_mini
  for (var i = 0 ; i < liens.length ; i++) {
    // Au clique sur le bouton next
    next.onclick = function() {
      big_photo.src = liens[posPhoto+1].href; // On change l'attribut src de l'image en le remplaçant par la valeur du lien
      big_photo.alt = liens[posPhoto+1].title; // On change son titre
      titre_photo.firstChild.nodeValue = liens[posPhoto+1].title; // On change le texte de titre de la photo
    posPhoto++;
      };
    // Au clique sur le bouton previous 
    prev.onclick = function() {
      big_photo.src = liens[posPhoto-1].href; // On change l'attribut src de l'image en le remplaçant par la valeur du lien
      big_photo.alt = liens[posPhoto-1].title; // On change son titre
      titre_photo.firstChild.nodeValue = liens[posPhoto-1].title; // On change le texte de titre de la photo
    posPhoto--;
      };
    // Au clique sur les liens des vignettes
    liens[i].onclick = function() {
      big_photo.src = this.href; // On change l'attribut src de l'image en le remplaçant par la valeur du lien
      big_photo.alt = this.title; // On change son titre
      titre_photo.firstChild.nodeValue = this.title; // On change le texte de titre de la photo
    posPhoto=this.id;
    return false; // Et pour finir on inhibe l'action réelle du lien
      };
  } 
}

// Il ne reste plus qu'à appeler notre fonction au chargement de la page
window.onload = displayPics;