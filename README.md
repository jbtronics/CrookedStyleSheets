**[Here](http://crookedss.bplaced.net/) you can find a demo of the code in this repository.**

**中文翻译: [README.cn.md](./docs/README.zh.md)**

# Crooked Style Sheets

Proof of concept for website tracking/analytics using only CSS and without JavaScript.

## What we can do with this method

We can gather some basic information about the user, like the screen resolution (when the browser is maximized) and which browser (or engine) is used.

Further, we can detect if a user clicks a link or hovers with the mouse over an element. This can be used to track which (external) links a user visits using the hover method. It should even be possible to track how the user moved their mouse (using an invisible table of fields in the page background). However, using my method it's only possible to track when a user visits a link or hovers over a field for the first time. Maybe it's possible to modify the method so that it is possible to track every click.

Furthermore, it is possible to detect if a user has installed a specific font. Based on this information, it should be possible to detect the user's OS, because different operating systems ship different fonts, such as "Calibri" on Windows.

## How it works

### General idea

In CSS you can add an image from an external resource using the `url("foo.bar");` property. Interestingly, this resource is only loaded when it's needed (for example, when a link is clicked).

So, we can create a selector in CSS that calls a particular URL when the user clicks a link:

```css
#link2:active::after {
    content: url("track.php?action=link2_clicked");
}
```

On the server side a PHP script saves the timestamp when the URL is called.

### Browser detection

Browser detection is based on `@supports Media-Query`, and we check for some browser specific CSS property like `-webkit-appearance`:

```css
@supports (-webkit-appearance:none) and (not (-ms-ime-align:auto)){
    #chrome_detect::after {
        content: url("track.php?action=browser_chrome");
    }
}
```

### Font detection

For font detection a new font family is defined. Then, a text is tried to style with the font that should be checked if it exists. When the browser does not find the font on the user's system, the defined font is used as a fallback. When this happens, the browser tries to load the font and calls the tracking script on the server.

```css
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

For hover duration method (based on an idea by [jeyroik](https://github.com/jeyroik)), we define new animation keyframes that will request a URL every time a new keyframe is requested:

```css
@keyframes pulsate {
    0% {background-image: url("track.php?duration=00")}
    20% {background-image: url("track.php?duration=20")}
    40% {background-image: url("track.php?duration=40")}
    60% {background-image: url("track.php?duration=60")}
    80% {background-image: url("track.php?duration=80")}
    100% {background-image: url("track.php?duration=100")}
}
```

Then, we define that the keyframes should be used as animation for the `div`. There can we choose the duration of the animation, which is the maximum time we can measure:

```css
#duration:hover::after {
    -moz-animation: pulsate 5s infinite;
    -webkit-animation: pulsate 5s infinite;
    /*animation: pulsate 5s infinite;*/
    animation-name: pulsate;
    animation-duration: 10s;
    content: url("track.php?duration=-1");
}
```

The resolution of the duration measurement can be increased, by inserting more steps into the keyframes set.

### Input detection

To detect if a user checks a checkbox we use the `:selected` Selector provided by CSS:

```css
#checkbox:checked {
    content: url("track.php?action=checkbox");
}
```

For detection of the string "test" we combine the HTML `pattern` attribute, which can be used to build some basic input validation. In combination with the `:valid` selector, the browser will request our tracking site when the regex pattern is matched by the input:

```html
<input type="text" id="text_input" pattern="^test$" required>
```

```css
#text_input:valid {
    background: green;
    background-image: url("track.php?action=text_input");
}
```

## Demo

[Here](http://crookedss.bplaced.net/) you can find a demo of the files in this repository. The `index.html` is the file that is being tracked using this method. Visit the `results.php` for the results of the tracking.

If nothing or a PHP warning appears after a property, it means that the value of this property is false, or that the user has not visited the page or link yet (yeah, it's a bit dirty, but you can see the principle of the method).

Also, resolution detection doesn't work so well yet, because I only have detection for the most used screen widths. Further, it is a bit tricky to detect the real screen height of the user, because CSS uses the height of the browser window and stuff like the system panel/task bar makes the browser area smaller than the monitor.

## What you can do to prevent tracking with this method

The only way that is known to me currently, is to disable CSS for a web page completely (you can do this with a plugin like [uMatrix](https://github.com/gorhill/uMatrix)). The problem is that almost every modern web page looks very ugly without CSS and is sometimes even unusable. So, disabling CSS is not a real option, except when you are very worried about your privacy (for example, when you are using the Tor browser, you should maybe disable CSS).

A better solution would be if browsers didn't load the external content (referenced in CSS) when it´s needed, but when the site is loaded. Then it would be impossible to detect individual actions. This modification to content loading could be implemented by the browsers itself, or maybe by a plugin (similar to [NoScript](https://noscript.net/) or uMatrix)

The problem is that this solution might have an impact on performance, because the browser has to load a lot of content on initial site loading (and the browser might not use the content at all).
