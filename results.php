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
        <ul>
            <li>Last visited: <?php print $_SESSION["started"]?></li>
            <li>Device Type: <?php print $_SESSION["device"]?></li>
            <li>Link1 (google.de) clicked: <?php print $_SESSION["link1_clicked"] ?></li>
            <li>Link2 (foo.bar) clicked: <?php print $_SESSION["link2_clicked"]?></li>
            <li>Link3 (github.com) clicked: <?php print $_SESSION["link3_clicked"]?></li>
            <li>Orientation: <?php print $_SESSION['orientation']?></li>
            <li>Resolution: <?php print $_SESSION['width']?>x<?php print $_SESSION['height']?> </li>
        </ul>
    </div>

  </body>
</html>