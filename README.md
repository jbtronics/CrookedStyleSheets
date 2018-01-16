**[Here](http://crookedss.bplaced.net/) you can find a demo of the code in this repo.**

# Crooked Style Sheets

Proof of concept for website tracking/analytics using only CSS and without Javascript.

## What can we do with this method?
We can gather some basic information about the user, like the screen resolution (when the browser is maximized) and which browser (or engine) is used.
Further we can detect if a user opens a link or hovers with the mouse over an element. This can be used to track which (external) links a user visits and using the hover method. It should be even possible to track how the user moved their mouse (using an invisible table of fields in the page background). However, using my method it's only possible to track when a user visits a link the first time or hovers over a field the first time. Maybe it's possible to modify the method so that it is possible to track every click.

Furthermore it is possible to detect if a user has installed a specific font. Based on this information it should be possible to detect, which OS a users uses (because different operating systems ship different fonts, e.g. "Calibri" on Windows).

## How does it work?

### General idea

In CSS you can add a image from an external resource using the url("foo.bar"); property. Interesting is, that this resource is only loaded when it is needed (for example when a link is clicked).

So we can create a selector in CSS that calls a particular URL when the user clicks a link:

```CSS
#link2:active::after {
    content: url("track.php?action=link2_clicked");
}
```

On the server side a PHP script saves the timestamp when the URL is called.

### Browser detection

Browser detection is based on `@supports Media-Query`, and we check for some browser specific CSS property like `-webkit-appearance`:

```CSS
@supports (-webkit-appearance:none) {
    #chrome_detect::after {
        content: url("track.php?action=browser_chrome");
    }
}
```

### Font detection

For font detection a new font family is defined. Then a text is tried to style with the font that should be checked if it exists. When the browser does not find the font on the user's system the defined font is used as a fallback. When this happens the browser tries to load the font and calls the tracking script on the server.

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

### Measurement of hover duration

For hover duration method (based on an idea by jeyroik), we define new animation keyframes, that will request a url, every time a new keyframe is requested:

```CSS
@keyframes pulsate {
    0% {background-image: url("track.php?duration=00")}
    20% {background-image: url("track.php?duration=20")}
    40% {background-image: url("track.php?duration=40")}
    60% {background-image: url("track.php?duration=60")}
    80% {background-image: url("track.php?duration=80")}
    100% {background-image: url("track.php?duration=100")}
}
```
Then we define that the keyframes should be used as animation for the div. There can we choose the duration of the animation, which is the maximum time we can measure:
```CSS
#duration:hover::after {
    -moz-animation: pulsate 5s infinite;
    -webkit-animation: pulsate 5s infinite;
    /*animation: pulsate 5s infinite;*/
    animation-name: pulsate;
    animation-duration: 10s;
    content: url("track.php?duration=-1");
}
```

The resoultion of the duration measurement can be increased, by insert more steps into the keyframes set.

### Input detection
To detect if a user checks a checkbox we use the :selected Selector provided by CSS:
```CSS
#checkbox:checked {
    content: url("track.php?action=checkbox");
} 
```

For detection of the string "test" we combine the HTML pattern attribute, that can be used to build some basic input validation. In combination with the :valid selector, the browser will request our tracking site, when the pattern regex is matched by input:

```HTML
<input type="text" id="text_input" pattern="^test$" required>
```

``` CSS
#text_input:valid {
    background: green;
    background-image: url("track.php?action=text_input");
}
``` 


## Demo
[Here](http://crookedss.bplaced.net/) you can find a demo of the files in this repository. The `index.html` is the file that is being tracked using this method. Visit the `results.php` for the results of the tracking. 

If nothing, or a PHP warning appears after a property, means that the value of this property is false, or that the user has not visited the page or link yet (Yeah, it's a bit dirty, but you can see the principle of the method). 

Also, resolution detection doesn't work so well yet, because I only have detection for the most used screen widths. Further, it is a bit tricky to detect the real screen height of the user, because CSS uses the height of the browser window and stuff than the Windows' task bar makes the browser area smaller than the monitor.

## What can you do to prevent tracking via this method?
The only way that is known to me currently is, to disable CSS for a webpage completly (you can do this with a plugin like uMatrix). The problem that almost every modern webpage looks very ugly without CSS and is sometimes even unusable completly. So disable CSS is not a real option, except when you are very worried about your privacy (for example, when you are using Tor browser, you should maybe disable CSS).

A better solution would be, that browsers does not load the external content (referenced in CSS), when it is needed, but when the site is loaded. Then it would be impossible to detect single actions. This modification to content loading could be implemented by the browsers itself, or maybe by a plugin (similar to NoScript or uMatrix)

The problem is that this solution maybe have a performance impact, because the browser has to load much content on inital site loading (and maybe the browser will not use the content at all).

