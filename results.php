<?php
session_start();

/* Just to prevent the PHP output, we 
   give every variable a default value. 
*/
$started = "false";
$device = "unknown";
$link1_clicked = "false";
$link2_clicked = "false";
$link3_clicked = "false";
$s1_hovered = "false";
$s2_hovered = "false";
$s3_hovered = "false";
$s4_hovered = "false";
$duration = 0;
$text_input = "false";
$checkbox = "false";
$browser_chrome = "false";
$browser_firefox = "false";
$browser_edge = "false";
$orientation = "unknown";
$width = "unknown";
$height = "unknown";

if( isset($_SESSION["started"]) ){

    $started = $_SESSION["started"];
}

if( isset($_SESSION["device"]) ){

    $device = $_SESSION["device"];
}

if( isset($_SESSION["link1_clicked"]) ){

    $link1_clicked = $_SESSION["link1_clicked"];
}

if( isset($_SESSION["link2_clicked"]) ){

    $link2_clicked = $_SESSION["link2_clicked"];
}

if( isset($_SESSION["link3_clicked"]) ){

    $link3_clicked = $_SESSION["link3_clicked"];
}

if( isset($_SESSION["s1_hovered"]) ){

    $s1_hovered = $_SESSION["s1_hovered"];
}

if( isset($_SESSION["s2_hovered"]) ){

    $s2_hovered = $_SESSION["s2_hovered"];
}

if( isset($_SESSION["s3_hovered"]) ){

    $s3_hovered = $_SESSION["s3_hovered"];
}

if( isset($_SESSION["s4_hovered"]) ){

    $s4_hovered = $_SESSION["s4_hovered"];
}

if( isset($_SESSION["duration"]) ){

    $duration = $_SESSION["duration"];
}

if( isset($_SESSION["text_input"]) ){

    $text_input = $_SESSION["text_input"];
}

if( isset($_SESSION["checkbox"]) ){

    $checkbox = $_SESSION["checkbox"];
}

if( isset($_SESSION["browser_chrome"]) ){

    $browser_chrome = $_SESSION["browser_chrome"];
}

if( isset($_SESSION["browser_firefox"]) ){

    $browser_firefox = $_SESSION["browser_firefox"];
}

if( isset($_SESSION["browser_edge"]) ){

    $browser_edge = $_SESSION["browser_edge"];
}


if( isset($_SESSION["orientation"]) ){

    $orientation = $_SESSION["orientation"];
}

if( isset($_SESSION["width"]) ){

    $width = $_SESSION["width"];
}

if( isset($_SESSION["height"]) ){

    $height = $_SESSION["height"];
}

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
            <li>Last visited: <b><?php print $started;?></b></li>
            <li>Device Type: <b><?php print $device;?></b></li>
            <li>Link1 (google.de) clicked: <b><?php print $link1_clicked;?></b></li>
            <li>Link2 (foo.bar) clicked: <b><?php print $link2_clicked;?></b></li>
            <li>Link3 (github.com) clicked: <b><?php print $link3_clicked;?></b></li>
            <li></li>
            <li>Field 1 hovered: <b><?php print $s1_hovered;?></b></li>
            <li>Field 2 hovered: <b><?php print $s2_hovered;?></b></li>
            <li>Field 3 hovered: <b><?php print $s3_hovered;?>
                        
                                </b></li>
            <li>Field 4 hovered: <b><?php print $s4_hovered;?></b></li>
            <li></li>
            <li>Duration field was hovered for at least <b> <?php print $duration / 10?></b> seconds  (raw value: <?php $duration?>) [approx. 1s resolution]
            <li></li>
            <li>"test" was typed into input box: <b><?php print $text_input?></b></li>
            <li>Checkbox was checked: <b><?php print $checkbox?></b></li>
            <li></li>
            <li>Calibri font existing: <b><?php isset($_SESSION["font1"]) ? print $_SESSION["font1"] : print true?></b></li>
            <li></li>
            <li>Browser Chrome: <b><?php print $browser_chrome?></b></li>
            <li>Browser Firefox: <b><?php print $browser_firefox?></b></li>
            <li>Browser Edge: <b><?php print $browser_edge?></b></li>
            <li>Orientation: <b><?php print $orientation?></b></li>
            <li>Resolution: <b><?php print $width?> x <?php print $height?></b> (only often used widths are supported, your screen resolution is greater than or equal to shown resolution.)</li>
        </ul>
    </div>

  </body>
</html>