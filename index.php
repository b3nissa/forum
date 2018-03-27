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
  	setInterval (loadLog, 2500);	//Reload file every 2.5 seconds

  	//If user wants to end session

  });
  </script>


  <?php
  }
  ?>

<div class="container">

  <?php

  $query = "SELECT * from categorieen";
  $result = mysqli_query($dbc, $query) or die ('Siltech -> Kon subforums niet ophalen.');
  while($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $naam = $row['naam'];
    $cat_id = $row['cat_id'];

    echo '
    <div class="categorie">

      <div class="categorie-titel">
        <i class="far fa-comments"></i> '. $naam .'
      </div>


    ';

   ?>

   <?php

   $query2 = "SELECT * FROM subforums WHERE cat_id = '$cat_id'";
   $result2 = mysqli_query($dbc, $query2) or die ('Siltech -> Kon subforums niet ophalen.');
   while($row = mysqli_fetch_assoc($result2)) {
     $sub_id = $row['id'];
     $sub_icoon = $row['icoon'];
     $sub_naam = $row['naam'];
     $sub_beschrijving = $row['beschrijving'];
     $sub_cat_id = $row['cat_id'];
     $sub_link = $row['link'];

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
       </a>

       <div class="subforum-extra-info">
       Topic & Reactie aantal
       </div>
     </div>
     ';

   }

   echo "</div>";
  }
    ?>



  </div>


<?php
include_once ('app/templates/footer.php');
?>
