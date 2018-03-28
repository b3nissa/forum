<?php
// Sessie eindigen en naar index redirecten
session_start();
session_unset();
session_destroy();
header('Location: index');

 ?>
