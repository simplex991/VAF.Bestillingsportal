<?php header('Content-Type: text/html; charset=utf-8');
include('source/php/config.php'); ?>

<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VAF IT-Bestilling</title>

<!-- Linker inn stilformatering av portalen -->
<link href="source/sorttransparent.css" rel="stylesheet" type="text/css" />

<!-- Linker inn JQUERY for bruk på denne portalen -->
<script type="text/javascript" src="source/js/jquery-3.0.0.js"></script>

<!-- Setter VAF icon på nettlesers venstre kant. HTML5 måten -->
<link rel="icon" href="/favikon.ico">
</head>

<body>

<div class="container">
  <div class="header"><img src="source/image/logo-vaf2.png"/> <!-- end .header -->
      <strong>Bestillingsportal for VAF-ansatte</strong>
  <div style="clear: left;"></div>
  </div>
  <div class="sidebar1">
    <ul class="nav">
     <?php  include('source/php/meny/kat.php'); ?>
    </ul>
    
    <div class="spacer">
    <h2>Handlevogn</h2>
    <p>
       
	  <?php
      
	  include('source/php/handlevogn/inc_handevogn.php');
	  
	  ?>
    </p><br/> <br/> <br/>
	<p>Ved bestilling:</p>
	<p>1. Velg kategori</p>
	<p>2. Finn ønsket produkt og trykk på "Legg til i handlevogn"</p>
	<p>3. Trykk på bestill under handlevognen</p>
	<p>4. Skriv inn ressursnummer og trykk på last ned knappen</p>
	<p>5. Kontroller at du har fått opp det du har bestillt og send PDF inn til brukerstøtte</p>
  <!-- end .sidebar1 --></div></div>
  <div class="content">
  <div class="spacer">
   <?php

	include('source/php/inc.php');
	
	?>
   
   <!-- end .content --></div></div>
  <div class="sidebar2">
   <div class="spacer"> <h3>Brukerstøtte</h3>
    <p>Sjekk status på dine saker her:
     <a href="http://supportpoint/SelfService/Request/New" target="_blank"><br/>Status på bestillingen</a href></p>
    <p>Finn mail addressen til din brukerstøtte her:
     <a href="http://supportpoint/SelfService/Home/Contact" target="_blank">Kontakt oss </a><!-- end .sidebar2 --></p>
</div></div>
  
  <div class="footer">
  <div style="clear: both;"></div>
    <p align="center"></p>
    <p align="center"><a href="?side=admin"><font color="#C9C9C9">Administrasjon</font></a></p>
    
<table>
  <tbody>
    <tr>
      <td><font color="white">Webdev:</font></td>
      <td><font color="#C9C9C9">Fredrik Wehus</font></td>
    </tr>
    <tr>
      <td><font color="white">E-post:</font></td>
      <td><font color="#C9C9C9"><a href="mailto:adsl@vaf.no?Subject=Webside" target="_top">frwe1@vaf.no</a></font></td>
    </tr>
    <tr>
      <td><font color="white">Last updated:</font></td>
      <td><font color="#C9C9C9">8 February 2018 </font></td>
    </tr>
  </tbody>
</table>

    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
</html>