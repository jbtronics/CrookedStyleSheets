<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">

</head>
  <body>
    <div class="container">
        <h1>Results</h1>
        <b>When the value is empty or PHP notices appears, it means that the value is false or the webpage hasn't been visited yet.</b>
        <ul>
            <li>Last visited: <b><?php print $_SESSION["started"]?></b></li>
            <li>Device Type: <b><?php print $_SESSION["device"]?></b></li>
            <li>Link1 (google.de) clicked: <b><?php print $_SESSION["link1_clicked"] ?></b></li>
            <li>Link2 (foo.bar) clicked: <b><?php print $_SESSION["link2_clicked"]?></b></li>
            <li>Link3 (github.com) clicked: <b><?php print $_SESSION["link3_clicked"]?></b></li>
            <li></li>
            <li>Field 1 hovered: <b><?php print $_SESSION["s1_hovered"]?></b></li>
            <li>Field 2 hovered: <b><?php print $_SESSION["s2_hovered"]?></b></li>
            <li>Field 3 hovered: <b><?php print $_SESSION["s3_hovered"]?></b></li>
            <li>Field 4 hovered: <b><?php print $_SESSION["s4_hovered"]?></b></li>
            <li></li>
            <li>Duration field was hovered for at least <b> <?php print $_SESSION["duration"] / 10?></b> seconds  (raw value: <?php print $_SESSION["duration"]?>) [approx. 1s resolution]
            <li></li>
            <li>"test" was typed into input box: <b><?php print $_SESSION["text_input"]?></b></li>
            <li>Checkbox was checked: <b><?php print $_SESSION["checkbox"]?></b></li>
            <li></li>
            <li>Calibri font existing: <b><?php isset($_SESSION["font1"]) ? print $_SESSION["font1"] : print true?></b></li>
            <li></li>
            <li>Browser Chrome: <b><?php print $_SESSION['browser_chrome']?></b></li>
            <li>Browser Firefox: <b><?php print $_SESSION['browser_firefox']?></b></li>
            <li>Browser Edge: <b><?php print $_SESSION['browser_edge']?></b></li>
            <li>Orientation: <b><?php print $_SESSION['orientation']?></b></li>
            <li>Resolution: <b><?php print $_SESSION['width']?>x<?php print $_SESSION['height']?></b> (only often used widths are supported, your screen resolution is greater than or equal to shown resolution.)</li>
        </ul>
    </div>

  </body>
</html>