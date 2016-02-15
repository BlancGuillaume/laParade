<?php 
$req = "SELECT * FROM NEWS ORDER BY idNews DESC"; 
$news = $bd->get_requete($req); ?>

<?php if (!empty($news)): ?>
   <aside class="container-cards"> <!-- ajout d'une nouvelle news -> dans cette div -->   
   <?php for ($i = 0; $i < 5 && !empty($news[$i]); $i++) : ?>
         <div class="col s3 m3">
            <?php if ($i == 0 || $i == 3): ?>
               <div class="card orangefonce">
                  <div class="card-content white-text">
            <?php elseif($i == 1 || $i == 4): ?>
               <div class="card orange">
                  <div class="card-content white-text">
            <?php else: ?>
               <div class="card vert">
                  <div class="card-content white-text">
            <?php endif; ?>
                  <span><?php echo $news[$i]['nomNews'];?></span>
                  <p><?php echo $news[$i]['contenuNews']; ?></p>
                  <?php if ($news[$i]['lienNews'] != NULL): ?>
                     <a href=<?php echo "\"" . $news[$i]['lienNews'] . "\""; ?>>LIEN</a>
                  <?php endif ?>
                  <?php if ($news[$i]['imageNews'] != NULL): ?>
                     <img src=<?php echo "\"" . $news[$i]['imageNews'] . "\""; ?>></img>
                  <?php endif ?>
               </div>
            </div>
         </div>
   <?php endfor; ?>
   </aside>
<?php endif; ?>