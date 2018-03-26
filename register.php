<?php
include_once ('app/templates/header.php');
?>

<?php



if(isset($_POST['submit']) && !empty($_POST['g-recaptcha-response'])) {

  $username = mysqli_real_escape_string($dbc, htmlentities($_POST['username']));
  $email = mysqli_real_escape_string($dbc, htmlentities($_POST['email']));
  $password = mysqli_real_escape_string($dbc, htmlentities($_POST['password']));
  $password_rp = mysqli_real_escape_string($dbc, htmlentities($_POST['password_rp']));
  $hashed = hash('sha512', $password_rp);
  $ip = $_SERVER['REMOTE_ADDR'];

  $check_naam = "SELECT * FROM users WHERE username = '$username'";
  $result_naam = mysqli_query($dbc, $check_naam) or die('Siltech -> Username check mislukt.');
  if(mysqli_num_rows($result_naam) > 0) {
    echo "<script>alert('Helaas, deze gebruikersnaam bestaat al.')</script>";
  } elseif($password !== $password_rp) {
    echo "<script>alert('De wachtwoorden komen niet overeen, probeer het nogmaals.')</script>";
  } else {
    $registreren = "INSERT INTO users(id, username, email, password, register_ip, last_ip, avatar) VALUES(0, '$username', '$email', '$hashed', '$ip', '$ip', 'default_avatar.gif')";
    $result_registreren = mysqli_query($dbc, $registreren) or die('Siltech -> Kon gebruiker niet registreren.');

    header('Location: inloggen');
  }

} elseif(isset($_POST['submit']) && empty($_POST['g-recaptcha-response'])) {
  echo "<script>alert('reCAPTCHA is verplicht!')</script>";
}



?>

<div class="container">
  <div class="categorie-titel m50">
    <i class="fas fa-user-plus"></i> Maak een account
  </div>
  <div class="content">

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="username">Gebruikersnaam</label>
      <input maxlength="20" id="username" name="username" type="text" placeholder="Gebruikersnaam.." required/>

      <label for="email">E-mail adres</label>
      <input id="email" name="email" type="email" placeholder="E-mail adres.."  required/>

      <label for="password">Wachtwoord</label>
      <input id="password" name="password" type="password" placeholder="Wachtwoord.." required/>

      <label for="password_rp">Wachtwoord herhalen</label>
      <input id="password_rp" name="password_rp" type="password" placeholder="Wachtwoord herhalen.."  required/>

      <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div><br />

      <input name="submit" type="submit" value="Registreren" />
    </form>
  </div>
</div>

<?php
include_once ('app/templates/footer.php');
