<?php

include_once ('app/templates/header.php');

if(isset($_SESSION['username'])){


	}

// Pak post[text] en haal slashes en vreemde tekens weg (beveiliging)
// Vervang tekst met emojis
// str_replace string replace $emojicode lijst met $emojis en stop die in $text
	// Input emojis vervangen
	$text = stripslashes(htmlentities($_POST['text']));
	$emojicode = [":)", ":D", ":(", "xD"];
	$emojis   = ["🙂", "😀", "🙁", "🤣"];
	$emojis = str_replace($emojicode, $emojis, $text);



		// Shoutbox legen functie
		$gebruiker_kleur = "SELECT rank FROM users WHERE username = '$username'";
		$result_kleur = mysqli_query($dbc, $gebruiker_kleur) or die('Siltech -> Kon rank niet ophalen.');
		while($row = mysqli_fetch_assoc($result_kleur)) {
		  $rank = $row['rank'];

			if($rank > 2 && $text == "/legen") {
				$fp = fopen("log.html", 'a');
				file_put_contents("log.html","");
				fclose($fp);
				exit;
			}


	// Gebruikersgroep selecteren & juiste kleur toepassen
	$gebruiker_kleur = "SELECT rank FROM users WHERE username = '$username'";
	$result_kleur = mysqli_query($dbc, $gebruiker_kleur) or die('Siltech -> Kon rank niet ophalen.');
	while($row = mysqli_fetch_assoc($result_kleur)) {
	  $rank = $row['rank'];

	  $kleurcode = "SELECT * FROM ranks WHERE id = '$rank'";
	  $kleurcode_result = mysqli_query($dbc, $kleurcode) or die('Siltech -> Kon kleurcode niet ophalen.');

	  while($row = mysqli_fetch_assoc($kleurcode_result)) {
	    $kleurcode_gebruiker = $row['kleurcode'];


			// Schrijven in log.html
				$fp = fopen("log.html", 'a');
				fwrite($fp, "<div class='chatbox-bericht'> <img class='chatbox-avatar' src='./media/images/avatars/". $avatar ."' /><b><span style='color:". $kleurcode_gebruiker ."'>". $username ."</span></b>: ".stripslashes(htmlspecialchars($emojis))."<span class='datum'><i class='far fa-clock'></i> ".date("H:i")."</span><br></div>");
				fclose($fp);

	}
}
}
?>
