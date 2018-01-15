# Crooked Style Sheeding

Proof of Concept for Website tracking, only using CSS and no Javascript.

## What can we do with this method?
We can gather some basic information about the user, like the screen resolution (when browser is maximized) and which browser (or engine) is used.
Further we can detect if a user opens a link or hovers with the mouse over an element. This can be used to track which (external) links a user visits and using the hover method, it should be even possible to track, how the user moved its mouse (using an invisible table of fields in the page background). However using my method, its only possible to track, when a user visits a link several times or hovers about a field several times. Maybe it's possible to modify the method, so it is possible to track every click.

Furthermore it is possible to detect, if a user has installed a specific font. Based on this information it should be possible to detect, which OS a users uses (because different OS ships different fonts, e.g. "Calibri" on Windows).

## How does it work?
In CSS you can add a image from an external resource using the url("foo.bar"); property. Interesting is, that this resource is only loaded, when it is needed (for example when a link is clicked).

So we can create a selector in CSS, that calls a particular URL, when the user clicks a link:

```CSS
#link2:active::after {
    content: url("track.php?action=link2_clicked");
}
```

On the server side, a PHP script, save the timestamp, when the URL is called.

Browser detection is based on @supports Media-Query, and we check for some browser specific CSS property like -webkit-appearance:

```CSS
@supports (-webkit-appearance:none) {
    #chrome_detect::after {
        content: url("track.php?action=browser_chrome");
    }
}
```

For font detection, a new font family is defined. Then a text is tried to style with the font that should be checked if it exists. When the browser does not find the font on the user's system, then the defined font is used as a fallback. When this happens, the browser tries to load the font and calls the tracking script on the server.

```CSS
/** Font detection **/
@font-face {
    font-family: Font1;
    src: url("track.php?action=font1");
}

#font_detection1 {
    font-family: Calibri, Font1;
}
```

## Demo
[Here](http://crookedss.bplaced.net/) you can find a demo of the files in this Repo. The index.html is the file that is being tracked using this method, visit the results.php for the results of the tracking. 

If nothing or a PHP warning appears after a Property, this means that the value of this property is false, or that the user has not visited the page or link yet (Yeah its a bit dirty, but you can see the principle of the method...). 
Also resolution detection works not so well yet, because I have only detection for the mostly used screen widths. Further it is a bit tricky to detect the real screen height of the user, because CSS uses the height of the browser window and stuff than the Windows' task bar makes the browser area smaller than the monitor.
