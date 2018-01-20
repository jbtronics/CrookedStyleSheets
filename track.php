<?php
session_start();

$action = $_REQUEST['action'];

if(!empty($_REQUEST['orientation']))
    $_SESSION['orientation'] = $_REQUEST['orientation'];

if(!empty($_REQUEST['width']))
    $_SESSION['width'] = $_REQUEST['width'];

if(!empty($_REQUEST['height']))
    $_SESSION['height'] = $_REQUEST['height'];

if(!empty($_REQUEST['duration']))
    $_SESSION['duration'] = $_REQUEST['duration'];

switch($action)
{
    case "screen_start":
        $_SESSION["started"] = date(DATE_RFC822);
        $_SESSION["device"] = "Screen";
    break;
    case "link1_clicked":
        $_SESSION["link1_clicked"] = date(DATE_RFC822);
        break;
    case "link2_clicked":
        $_SESSION["link2_clicked"] = date(DATE_RFC822);
        break;
    case "link3_clicked":
        $_SESSION["link3_clicked"] = date(DATE_RFC822);
        break;
    case "s1_hovered":
        $_SESSION["s1_hovered"] = date(DATE_RFC822);
        break;
    case "s2_hovered":
        $_SESSION["s2_hovered"] = date(DATE_RFC822);
        break;
    case "s3_hovered":
        $_SESSION["s3_hovered"] = date(DATE_RFC822);
        break;
    case "s4_hovered":
        $_SESSION["s4_hovered"] = date(DATE_RFC822);
        break;
    case "browser_chrome":
        $_SESSION["browser_chrome"] = true;
        break;
    case "browser_firefox":
        $_SESSION["browser_firefox"] = true;
        break;
    case "browser_edge":
        $_SESSION["browser_edge"] = true;
        break;
    case "font1":
        $_SESSION["font1"] = false;
        break;
    case "text_input":
        $_SESSION["text_input"] = date(DATE_RFC822);
        break;
    case "checkbox":
        $_SESSION["checkbox"] = date(DATE_RFC822);
        break;
    case "reset":
        session_unset();
        print("Results were cleared!");
        break;
}