**点击 [这里](http://crookedss.bplaced.net/) 可以查看该仓库的一个 demo**

# Crooked Style Sheets

证明仅用 CSS，是的，只用 CSS，不用 JavaScript 实现网页追踪 / 分析

## 我们可以用它来做什么

我们可以收集关于用户的一些基本信息，例如屏幕分辨率（当浏览器最大化时）以及用户使用的什么浏览器（引擎）

此外，我们可以监测用户是否点击某个链接或鼠标悬停在某个元素上，用来追踪用户悬停的链接，甚至可以追踪用户如何移动鼠标 （在页面使用不可见的字段），然而，使用目前我的方法只能追踪用户的第一次点击或悬停，我相信，修改我的方法最终可以实现追踪用户的每次点击

最后，我们还可以监测用户是否安装了某个特殊的字体，基于这个信息，我们可以追踪用户使用的操作系统，因为不同操作系统使用的字体也稍有不同，例如 Windows 的 Calibri

## 这又是如何实现的

### 普通的做法

用 CSS 你可以使用 `url("foo.bar")` 属性引用外部资源添加图像，有趣的是，这个资源只在需要的时候被加载（例如，当链接被点击时）

所以，我们可以用 CSS 创建一个选择器，当用户点击某个链接时调用某个特定的 UPL

```css
#link2:active::after {
  content: url('track.php?action=link2_clicked');
}
```

服务端，php 脚本会在调用 URL 时保存时间戳

### 浏览器监测

浏览器监测是基于 `@supports Media-Query` 的，我们可以监测浏览器的一些特殊的属性
，例如 `-webkit-appearance`

```css
@supports (-webkit-appearance: none) {
  #chrome_detect::after {
    content: url('track.php?action=browser_chrome');
  }
}
```

### 字体监测

对于字体监测，需要定义一个新的字体，如果一个字体存在，文本会尝试使用该字体进行样式设置，然而，当用户在系统上找不到该字体时，定义的字体会作为备用，在这种情况下，浏览器会尝试去加载定义的字体并在服务器上调用追踪脚本

```css
/** Font detection **/
@font-face {
  font-family: Font1;
  src: url('track.php?action=font1');
}

#font_detection1 {
  font-family: Calibri, Font1;
}
```

### 悬停监测

对于悬停监测（基于 [jeyroik](https://github.com/jeyroik) 的想法），我们需定义一个关键帧，每次使用这个关键帧都要去请求一个 URL

```css
@keyframes pulsate {
  0% {
    background-image: url('track.php?duration=00');
  }
  20% {
    background-image: url('track.php?duration=20');
  }
  40% {
    background-image: url('track.php?duration=40');
  }
  60% {
    background-image: url('track.php?duration=60');
  }
  80% {
    background-image: url('track.php?duration=80');
  }
  100% {
    background-image: url('track.php?duration=100');
  }
}
```

然后，我们使用定义的关键帧创建动画，我们可以定义动画持续的时间，这也是我们测量的最大时间

```css
#duration:hover::after {
  -moz-animation: pulsate 5s infinite;
  -webkit-animation: pulsate 5s infinite;
  /*animation: pulsate 5s infinite;*/
  animation-name: pulsate;
  animation-duration: 10s;
  content: url('track.php?duration=-1');
}
```

我们可以通过补充关键帧的设置，来优化分辨率的监测

### 输入监测

监测用户选中了某个复选框，我们可以使用 CSS 提供的 `:selected` 选择器

```css
#checkbox:checked {
  content: url('track.php?action=checkbox');
}
```

为了监测字符串，我们结合了 HTML `pattern` 属性，它可以帮助我们解决一些基本的输入验证，再结合 `:valid` 选择器，浏览器当输入匹配成功时会去请求我们的追踪站点

```html
<input type="text" id="text_input" pattern="^test$" required>
```

```css
#text_input:valid {
  background: green;
  background-image: url('track.php?action=text_input');
}
```

## Demo

点击 [这里](http://crookedss.bplaced.net/) 你可以查看该仓库的一个 demo。`index.html` 实践了的上述的方法，访问 `results.php` 可以查看结果

如果属性后面没有任何 `content` 或有 php 警告出现，这就意味着这个属性的值为 false 或用户还没访问页面或链接（这个，确实很烦，但你可以知道这些方法的原理）

此外，分辨率监测还不是特别的准确，因为目前只能监测最常用的屏幕宽度。最后还想说的是，监测用户实际屏幕的宽度并没有想象中的那么简单，因为 CSS 监测的高度为浏览器窗口的高度，而通常由于系统面板 / 任务栏的原因，使得浏览器窗口要小于显示器

## 有什么办法可以防止使用上面的方法进行追踪

目前我知道的唯一办法就是完全禁用 CSS（你可以使用像
[uMatrix](https://github.com/gorhill/uMatrix) 的插件来实现），但它的代价也是十分巨大的，没有 CSS，网页就没有之前那么赏心悦目了，甚至导致无法正常使用，所以，禁用 CSS 算不上一个真正的选择，除非，你实在担心你的隐私（例如，当你在使用 Tor 浏览器，也许你应该禁用 CSS）

一个更好的解决方案是，在网页加载时，浏览器不会去加载需要的外部资源，这样，就不可能监测到用户的个人行为，这种对内容加载的修改可以通过浏览器来实现，也可以通过插件来实现（类似 [NoScript](https://noscript.net/) 或 uMatrix）

上述方法也存在一个明显的问题，那就是对性能会造成一定的一定的影响，因为浏览器会在初始化页面时加载大量的内容（有些内容是页面根本不需要的）
