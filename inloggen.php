<!doctype html>
<?php
include_once ('app/templates/header.php');
?>

<?php
// Als je al ingelogd bent, ga naar index

if(isset($_SESSION['username'])) {
  header('Location: index');
}
 ?>

<div class="container">
  <div class="categorie-titel m50">
    <i class="fas fa-user"></i> Inloggen
  </div>
  <div class="content">

    <?php
// If isset $_POST['submit'] dus als er op submit word gedrukt
    if(isset($_POST['submit'])) {
      // escape string en html entities tegen injectie.
      $username = mysqli_real_escape_string($dbc, htmlentities($_POST['username']));
      $password = mysqli_real_escape_string($dbc, htmlentities($_POST['password']));
      // Pak input van password en hash deze sha512
      $hashed = hash('sha512', $password);

      $query = "SELECT * FROM users WHERE username='$username' AND password='$hashed'";
      $result = mysqli_query($dbc, $query) or die('Siltech -> Login query mislukt.');
      if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {

        $username = $row['username'];
        $avatar = $row['avatar'];
        $rank = $row['rank'];

        // Vul sessie variablen

        $_SESSION['username'] = $username;
        $_SESSION['avatar'] = $avatar;
        $_SESSION['rank'] = $rank;

        header('Location: index');


      }} else {
        header('Location: inloggen?fout');
        }


    }


     ?>

     <?php
     // Als ?fout word meegegeven laat foutmelding zien
     if(isset($_GET['fout'])) {
       echo '<div class="foutmelding"><i class="fas fa-exclamation-triangle"></i> Ongeldige gebruikersnaam en of wachtwoord.</div>';
     }
      ?>

    <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">

      <label for="username">Gebruikersnaam</label>
      <input name="username" id="username" type="text" placeholder="Gebruikersnaam" required/>

      <label for="password">Wachtwoord</label>
      <input name="password" id="password" type="password" placeholder="Wachtwoord" required/>

      <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div><br />

      <input name="submit" type="submit" value="Inloggen" />

    </form>
  </div>
</div>
<?php
include_once ('app/templates/footer.php');
?>
