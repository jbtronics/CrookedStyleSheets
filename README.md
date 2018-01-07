# Crooked Style Sheeding

Proof of Concept for Website tracking, only using CSS and no Javascript.

## What can we do with this method?
We can gather some basic information about the user, like the screen resolution and which browser (or engine) is used.
Further we can detect if a user opens a link or hovers with the mouse over an element. This can be used to track which (external) links a user visits and using the hover method, it should be even possible to track, how the user moved its mouse (using an invisible table of fields in the page background). However using my method, its only possible to track, when a user visits a link the first time or hovers about a field the first time. Maybe it's possible to modify the method, so it is possible to track every click.

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

Browser detection is based on @supports Media-Query, and we check for some browser specific CSS property like -webkit-appearance.

For font detection, a new font family is defined. Then a text is tried to style with the font that should be checked if it exists. When the browser does not find the font on the user's system, then the defined font is used as a fallback. When this happens, the browser tries to load the font and calls the tracking script on the server.
