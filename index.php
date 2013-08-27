<?php
// bootstrap_markdown 20130811 (C) Mark Constable (AGPL-3.0)
// A simple script to render Markdown files within a Bootstrap3 contianer.

define('TITLE', 'alsa.opensrc.org');
define('FOOTER', '&copy; 2013 OpenSrc Team (AGPL-3.0)');

require 'lib/php/Markdown.php';
use \Michelf\Markdown;

$page = isset($_GET['q']) ? htmlspecialchars(trim($_GET['q'], '/')) : '';

if ($page) {
    if (file_exists('lib/md/' . $page . '.md')) {
        $html = Markdown::defaultTransform(file_get_contents('lib/md/' . $page . '.md'));
    } else {
        header('HTTP/1.0 404 Not Found');
        $html = '<h1 class="text-center">404 Page Not Found</h1>';
    }
} else {
    $html = include 'lib/php/navigation.php';
}

$menu = '';
$menu_ary = array('Readme', 'Github');

foreach($menu_ary as $m) {
    $c = $m == $page ? ' class="active"' : '';
    $menu .= '
            <li'.$c.'><a href="/'.$m.'">'.$m.'</a></li>';
}

$menu .= "\n";
$html .= "\n";

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?></title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
body { padding-top: 50px; overflow-y: scroll; }
h1, h2 { border-bottom: 1px solid #eee; padding-bottom: 2px; }
footer { text-align: center; color: #7F7F7F; font-style: italic; font-family: serif; }
@media (min-width: 768px) {
  .container {
    max-width: 730px;
  }
}
    </style>
  </head>
  <body>
    <div class="navbar navbar-fixed-top navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><?= TITLE ?></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav"><?= $menu ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="container"><?= $html ?>
    </div>
    <footer><?= FOOTER ?></footer>
<!-- let's comment these out until actually needed
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
-->
  </body>
</html>
