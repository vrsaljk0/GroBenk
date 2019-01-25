<?php
require_once "dbconnect.php";
session_start();
$idbolnica = $_SESSION['id'];
$naziv_bolnice =  $_SESSION['naziv_bolnice'];


echo '
<nav class="navbar navbar-expand-md navbar-light bg-white ">
<div class="container-fluid">
  <a class="navbar-brand" href="index.php"><img src="img/logo3_.png">&nbsp BloodBank GroBenk</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarResponsive">
    <ul class="navbar-nav ml-auto">
      <li>
        <div class="dropdown_donor">
          <h3>'.$naziv_bolnice.'</h3>
        </div>
        <div class="dropdown_donor">
          <button class="dropbtn_donor"><i class="fas fa-hospital"></i></button>
          <div class="dropdown-content_donor">
            <a href="bolnicke_postavke.php"><i class="fas fa-cogs"></i>&nbspPostavke</a> 
            <a href="odjava.php"><i class="fas fa-sign-out-alt"></i>&nbspOdjavi se</a>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>
</nav>';

?>

