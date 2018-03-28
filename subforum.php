<?php
include_once ('app/templates/header.php');

if(empty($_SESSION['username'])) {
  header('Location: '.$base_url.'inloggen');
}
?>

<div class="container">
  <div class="categorie">
    <div class="categorie-titel">
      <i class="far fa-comments"></i> <?php echo $titel; ?>

      <?php


          $url=explode("/", "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
          $link = end($url);

          $query = "SELECT id FROM subforums WHERE link = '$link'";
          $query_result = mysqli_query($dbc, $query) or die('Siltech -> Kan subforums breadcrumb niet ophalen.');
          while($row = mysqli_fetch_assoc($query_result)) {
            $subforum_id = $row['id'];
          }

      $min_rank = "SELECT min_rank FROM subforums WHERE id = '$subforum_id'";
      $min_rank_result = mysqli_query($dbc, $min_rank) or die('Siltech -> Kan subforums > min_rank niet ophalen.');
      while($data = mysqli_fetch_assoc($min_rank_result)){
        $sub_min_rank = $data['min_rank'];
        if(empty($rank)) {
          $rank = "1";
        }
      }


      if($sub_min_rank < $rank) {
        echo '<a class="maak-topic" href="#"><i class="far fa-plus-square"></i> Nieuw topic maken</a>';
      }

      elseif($sub_min_rank == $rank) {
        echo '<a class="maak-topic" href="#"><i class="far fa-plus-square"></i> Nieuw topic maken</a>';
      }

       else {
        echo '';
      }
       ?>

    </div>


    <!-- sticky topics -->

    <?php


    $topics_ophalen = "SELECT * FROM topics WHERE belangrijk = '1' AND subforum_id = '$subforum_id' ORDER BY datum DESC";
    $topics_result = mysqli_query($dbc, $topics_ophalen) or die('Siltech -> Kan topics niet ophalen in subforum.');
    if($topics_result->num_rows > 0) {
    while($row = mysqli_fetch_assoc($topics_result)) {

      $id = $row['id'];
      $sub_id = $row['subforum_id'];
      $titel2 = $row['titel'];
      $gebruiker = $row['gebruiker'];
      $datum = $row['datum'];
      $likes = $row['likes'];
      $gesloten = $row['gesloten'];

      $gebruiker_kleur = "SELECT rank FROM users WHERE username = '$username'";
      $result_kleur = mysqli_query($dbc, $gebruiker_kleur) or die('Siltech -> Kon rank niet ophalen.');
      while($row = mysqli_fetch_assoc($result_kleur)) {
        $rank = $row['rank'];

        $kleurcode = "SELECT * FROM ranks WHERE id = '$rank'";
        $kleurcode_result = mysqli_query($dbc, $kleurcode) or die('Siltech -> Kon kleurcode niet ophalen.');

        while($row = mysqli_fetch_assoc($kleurcode_result)) {
          $kleurcode_gebruiker = $row['kleurcode'];



     ?>

     <div class="subforum-item">

       <div class="subforum-icoon">

         <?php
// Check of topic gesloten is zet slotje erbij of niet
         if($gesloten == 0) {
           echo '<i class="fas fa-sticky-note"></i>';
         } elseif($gesloten == 1) {
           echo '
           <i class="fas fa-sticky-note"></i>
           <i class="fas gesloten fa-lock"></i>
           ';
         }

          ?>
       </div>

       <a href="#">
       <div class="subforum-info">
         <div class="subforum-titel">
           <span class="belangrijk-topic"><i class="fas fa-thumbtack"></i> Vastgemaakt</span>

            <?php
            $truncated = (strlen($titel2) > 30) ? substr($titel2, 0, 30) . '...' : $titel2;
            echo $truncated;

             ?>
         </div>

         <div class="subforum-centering">
           <div class="subforum-beschrijving">

            Geplaatst door <a href="#" style="color: <?php echo $kleurcode_gebruiker; ?>"><?php  echo $gebruiker; ?></a>
            op

            <?php
            $tijd = date('d-m-Y H:i', strtotime($datum));
            $geplaatst_oud = explode(" ", $tijd);
            $geplaatst_nieuw = $geplaatst_oud[0] . " om <i class='far fa-clock'></i> " . $geplaatst_oud[1];

            echo $geplaatst_nieuw;


             ?>
           </div>
         </div>

       </div>
       <div class="subforum-extra-info">

       </div>
       </a>
     </div>

   <?php } } } } ?>

    <!-- einde sticky -->

    <?php


    $topics_ophalen = "SELECT * FROM topics WHERE subforum_id = '$subforum_id' AND belangrijk = '0' ORDER BY datum DESC";
    $topics_result = mysqli_query($dbc, $topics_ophalen) or die('Siltech -> Kan topics niet ophalen in subforum.');
    if($topics_result->num_rows > 0) {
    while($row = mysqli_fetch_assoc($topics_result)) {

      $id = $row['id'];
      $sub_id = $row['subforum_id'];
      $titel2 = $row['titel'];
      $gebruiker = $row['gebruiker'];
      $datum = $row['datum'];
      $likes = $row['likes'];
      $gesloten = $row['gesloten'];

      $gebruiker_kleur = "SELECT rank FROM users WHERE username = '$username'";
      $result_kleur = mysqli_query($dbc, $gebruiker_kleur) or die('Siltech -> Kon rank niet ophalen.');
      while($row = mysqli_fetch_assoc($result_kleur)) {
        $rank = $row['rank'];

        $kleurcode = "SELECT * FROM ranks WHERE id = '$rank'";
        $kleurcode_result = mysqli_query($dbc, $kleurcode) or die('Siltech -> Kon kleurcode niet ophalen.');

        while($row = mysqli_fetch_assoc($kleurcode_result)) {
          $kleurcode_gebruiker = $row['kleurcode'];



     ?>

     <div class="subforum-item">
       <div class="subforum-icoon">
         <?php

         if($gesloten == 0) {
           echo '<i class="fas fa-comment"></i>';
         } elseif($gesloten == 1) {
           echo '
           <i class="fas fa-comment"></i>
           <i class="fas gesloten fa-lock"></i>
           ';
         }

          ?>
       </div>

       <a href="#">
       <div class="subforum-info">
         <?php
         $truncated = (strlen($titel) > 30) ? substr($titel2, 0, 30) . '...' : $titel2;

          ?>
         <div class="subforum-titel"><?php echo $truncated; ?></div>

         <div class="subforum-centering">
           <div class="subforum-beschrijving">

            Geplaatst door <a href="#" style="color: <?php echo $kleurcode_gebruiker; ?>"><?php  echo $gebruiker; ?></a>
            op

            <?php
            $tijd = date('d-m-Y H:i', strtotime($datum));
            $geplaatst_oud = explode(" ", $tijd);
            $geplaatst_nieuw = $geplaatst_oud[0] . " om <i class='far fa-clock'></i> " . $geplaatst_oud[1];

            echo $geplaatst_nieuw;


             ?>
           </div>
         </div>

       </div>
       <div class="subforum-extra-info">

       </div>
       </a>
     </div>

   <?php } } }
 } else {
   echo '
   <div style="text-align: center; line-height: 100px;" class="subforum-item">
   <strong>'. $titel .'</strong> bevat nog <strong>geen</strong> regulier(e) topic(s). Ben jij de eerste?
   </div>
   ';
 } ?>






  </div>
</div>


<?php
include_once ('app/templates/footer.php');
 ?>
