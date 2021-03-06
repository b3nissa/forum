<!doctype html>
<html lang="nl">
<head>
<?php

// Sessie start
session_start();

include_once ('config.php');


// $_SERVER['PHP_SELF'] = huidige url
// basename stript voor de / dus index.php blijft over
  $pagina = basename($_SERVER['PHP_SELF']);

// PHP Switch van $pagina vul website titel in
  switch ($pagina) {
    case 'index.php':
      $titel = 'Forumoverzicht';
      break;

    case 'register.php':
      $titel = 'Een account aanmaken';
      break;

    case 'inloggen.php':
      $titel = 'Inloggen';
      break;


    case 'subforum.php':

      // HTTP_HOST website host, URI na de slash
      // explode (string uit elkaar halen bij elke "/" en er een arrray van aanmaken)
      // Array vullen met woorden, in dit geval end (laatste item in array pakken dus link ophalen)

      $url=explode("/", "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
      $link = end($url);


      // Ophalen ervan
      $query = "SELECT cat_id, naam, link FROM subforums WHERE link = '$link'";
      $query_result = mysqli_query($dbc, $query) or die('Siltech -> Kan subforums breadcrumb niet ophalen.');
      while($row = mysqli_fetch_assoc($query_result)) {
        $naam = $row['naam'];
        $cat_id = $row['cat_id'];

        $titel = $naam;
        break;
      }

      // Als $titel niet gevuld is (pagina bestaat dus niet redirect naar index)
      if(empty($titel)) {
        header('Location: '. $base_url .'/index');
      }

    }

?>

    <title><?php echo $forum_naam; ?> - <?php echo $titel; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo $base_url; ?>">
    <link href="./styles/css/main.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" integrity="sha384-3AB7yXWz4OeoZcPbieVW64vVXEwADiYyAEhwilzWsLw+9FgqpyjjStpPnpBO8o8S" crossorigin="anonymous">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="apple-touch-icon" sizes="180x180" href="./media/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./media/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./media/images/favicon/favicon-16x16.png">

    <link rel="manifest" href="./media/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="./media/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
<!-- header -->

<div class="top-balk">
  <div class="container">

    <a class="links" href="index"><i class="fas fa-home"></i> Home</a>
    <a class="links" href="#"><i class="fas fa-heart"></i> Doneren</a>

    <?php
    if(empty($_SESSION['username'])) {
      echo '
      <a href="register"><i class="fas fa-user-plus"></i> Registreren</a>
      <a href="inloggen"><i class="fas fa-user"></i> Inloggen</a>
      ';
    }
   ?>
  </div>
</div>

<div class="header">
  <div class="container">
    <a href="index"><div class="logo"></div></a>

    <div class="menu">
      <a href="index"><div class="menu-item home"></div></a>

      <a href="team"><div class="menu-item team"></div></a>

      <a href="zoeken"><div class="menu-item zoeken"></div></a>

      <a href="doneren"><div class="menu-item doneren"></div></a>

    </div>
  </div>
</div>

<?php
/* Check of sessie gestart is: na registratie, na inloggen */
 ?>

<div class="menu-bar">
  <div class="container">
    <i class="fas fa-home"></i> / <?php echo $titel; ?>

    <?php

    // if(als) SESSIE_username NIET leeg is !empty (not empty = gevuld)

    if(!empty($_SESSION['username'])) {

      $username = $_SESSION['username'];

      $query = "SELECT * FROM users WHERE username='$username'";
      $result = mysqli_query($dbc, $query) or die('Siltech -> Kon avatar niet ophalen.');
      while($row = mysqli_fetch_assoc($result)) {
        $avatar = $row['avatar'];
        $rank = $row['rank'];
      }

      echo '
      <div class="gebruikers-paneel">
      <img class="avatar" src="./media/images/avatars/'. $avatar .'" />
      Welkom, '. $username .' <i class="fas fa-angle-down"></i>

      <div class="dropdown-menu">
        <div class="item"><a href=""><i class="fas fa-spin fa-cog"></i> Gebruikerspaneel</a></div>
        <div class="item"><a href=""><i class="fas fa-users"></i> Mijn vrienden</a></div>
        <div class="item"><a href=""><i class="fas fa-camera"></i> Wijzig avatar</a></div>
        <div class="item"><a href=""><i class="fas fa-image"></i> Wijzig handtekening</a></div>
        <div class="item"><a href=""><i class="fas fa-envelope"></i> Priveberichten</a></div>
        <div class="item"><a id="uitloggen" href="uitloggen"><i class="fas fa-power-off"></i> Uitloggen</a></div>

      </div>

      </div>
      ';


    } else {
      echo "";
    }

     ?>

  </div>
</div>


<?php

// Check of de gebruiker verbannen is

$verbannen_query = "SELECT verbannen FROM users WHERE username = '$username'";
$verbannen_result = mysqli_query($dbc, $verbannen_query) or die('Siltech -> Kan ban status niet controleren.');
while($data = mysqli_fetch_assoc($verbannen_result)) {
  $verbannen = $data['verbannen'];

  if($verbannen == 1) {
    die('
    <div class="container">
      <div class="categorie">
        <div class="categorie-titel">
        <i class="fas fa-gavel"></i> Je bent verbannen!
        </div>
        <div style="text-align: center; line-height: 100px" class="subforum-item">
        Je bent <strong>permanent</strong> verbannen van dit forum. Vragen? Stuur een e-mail naar <i class="far fa-envelope"></i> <strong><a href="mailto:unban@siltech.nl">unban@siltech.nl</a></strong>
        </div>
      </div>
    </div>
    ');
  }
}


?>


<!-- einde header -->
</body>
</html>
