<!doctype html>

<?php
include_once ('app/templates/header.php');
?>

<?php
  if(!isset($_SESSION['username'])) {
  	echo "";
  }

  else {
  ?>

  <div class="container">
    <div class="categorie">

    <div class="categorie-titel">
      <i class="far fa-comments"></i> Chatbox
    </div>
  	<div id="chatbox">

    <?php

    // if(als) log.html bestaat(file_exists) en de filesize van log.html is groter dan 0 bytes.
    // open log.html met permissie r (read  /lees)
    // Haal chats op (open en read de inhoud en plaats het hier)

  	if(file_exists("log.html") && filesize("log.html") > 0){
  		$handle = fopen("log.html", "r");
  		$contents = fread($handle, filesize("log.html"));
  		fclose($handle);

  		echo $contents;
  	}
  	?></div>

  	<form name="message" action="">
  		<input name="usermsg" placeholder="Voer een bericht in.." type="text" autocomplete="off" autofocus id="usermsg" size="63" />
  		<input style="display: none;" name="submitmsg" type="submit"  id="submitmsg" value="Verzenden" />
  	</form>
  </div>
    </div>




  <script type="text/javascript">
  // jQuery Document
  $(document).ready(function(){

$(function () {
  var wtf = $('#chatbox');
  var height = wtf[0].scrollHeight;
  wtf.scrollTop(height);
});

  	//If user submits the form
  	$("#submitmsg").click(function(){
  		var clientmsg = $("#usermsg").val();
  		$.post("post.php", {text: clientmsg});
  		$("#usermsg").attr("value", "");
      $("#usermsg").val('');
  		return false;
  	});

  	//Load the file containing the chat log
  	function loadLog(){
  		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
  		$.ajax({
  			url: "log.html",
  			cache: false,
  			success: function(html){
  				$("#chatbox").html(html); //Insert chat log into the #chatbox div
  				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
            var wtf = $('#chatbox');
            var height = wtf[0].scrollHeight;
            wtf.scrollTop(height);

  		  	},
  		});
  	}
  	setInterval (loadLog, 500);	//Reload file every 2.5 seconds

  	//If user wants to end session

  });
  </script>


  <?php
  }
  ?>

<div class="container">

  <?php


  $query = "SELECT * from categorieen ORDER BY id ASC";
  $result = mysqli_query($dbc, $query) or die ('Siltech -> Kon subforums niet ophalen.');
  while($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $naam = $row['naam'];
    $cat_id = $row['cat_id'];
    $min_rank = $row['min_rank'];

    if($rank >= $min_rank) {

    echo '
    <div class="categorie">

      <div class="categorie-titel">
        <i class="far fa-comments"></i> '. $naam .'
      </div>


    ';

   ?>

   <?php
// Subforums ophalen in db
   $query2 = "SELECT * FROM subforums WHERE cat_id = '$cat_id'";
   $result2 = mysqli_query($dbc, $query2) or die ('Siltech -> Kon subforums niet ophalen.');
   while($row = mysqli_fetch_assoc($result2)) {


     $sub_id = $row['id'];
     $sub_icoon = $row['icoon'];
     $sub_naam = $row['naam'];
     $sub_beschrijving = $row['beschrijving'];
     $sub_cat_id = $row['cat_id'];
     $sub_link = $row['link'];

     $laatste_topic_sub = "SELECT titel, gebruiker, datum FROM topics WHERE subforum_id = '$sub_id' ORDER BY datum DESC LIMIT 1";
     $laatste_topic_result = mysqli_query($dbc, $laatste_topic_sub) or die('Siltech -> Kan laatste topic niet ophalen.');

     $laatste_topic = mysqli_fetch_assoc($laatste_topic_result);
     $laatste_username = $laatste_topic['gebruiker'];




     echo '
     <div class="subforum-item">

       <div class="subforum-icoon">
         <i class="fas '. $sub_icoon .'"></i>
       </div>

       <a href="topics/'. $sub_link .'">
       <div class="subforum-info">
         <div class="subforum-titel">'. $sub_naam .'</div>

         <div class="subforum-centering">
           <div class="subforum-beschrijving">'. $sub_beschrijving .'</div>
         </div>

       </div>
       </a>';

       ?>

       <?php

                    // Geef username bijbehorende kleur

                     $gebruiker_kleur = "SELECT rank FROM users WHERE username = '$laatste_username'";
                     $result_kleur = mysqli_query($dbc, $gebruiker_kleur) or die('Siltech -> Kon rank niet ophalen.');
                     while($row = mysqli_fetch_assoc($result_kleur)) {
                       $rank = $row['rank'];

                       $kleurcode = "SELECT * FROM ranks WHERE id = '$rank'";
                       $kleurcode_result = mysqli_query($dbc, $kleurcode) or die('Siltech -> Kon kleurcode niet ophalen.');

                       $kleurcode_gebruiker = mysqli_fetch_assoc($kleurcode_result);

        ?>




       <?php
       // Als topic titel te lang is, kort hem af na 30 karakters en zet "..." neer
       $truncated = (strlen($laatste_topic['titel']) > 30) ? substr($laatste_topic['titel'], 0, 30) . '...' : $laatste_topic['titel'];


echo '
       <div class="subforum-extra-info">
      <div class="laatste-topic">
      <span style="color: #007FB1;">'. $truncated .'</span><br />
      Geplaatst door <span style="color: '. $kleurcode_gebruiker['kleurcode'] .'">'. $laatste_topic['gebruiker'] .'</span>
      </div>
       </div>
     ';

}


echo "</div>";
 }


 echo "</div>";

}


}
    ?>



  </div>

<?php
include_once ('app/templates/footer.php');
?>
