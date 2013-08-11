<?php
// bootstrap_markdown 20130811 (C) Mark Constable (AGPL-3.0)
// A simple script to render Markdown files within a Bootstrap3 contianer.

$page = isset($_GET['q']) ? htmlspecialchars(trim($_GET['q'], '/')) : '';

require 'lib/php/Markdown.php';
use \Michelf\Markdown;

if ($page) {
    $html = Markdown::defaultTransform(file_get_contents('lib/md/' . $page . '.md'));
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
    <meta name="description" content="">
    <meta name="author" content="">
    <title>alsa.opensrc.org</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://gist.github.com/andyferra/2554919/raw/2e66cabdafe1c9a7f354aa2ebf5bc38265e638e5/github.css" rel="stylesheet">
    <style>
body { padding-top: 60px; overflow-y: scroll; }
.jumbotron { margin-top: 20px; }
    </style>
  </head>
  <body>
    <div class="navbar navbar-fixed-top navbar-inverse">
      <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">alsa.opensrc.org</a>
        <div class="nav-collapse collapse">
          <ul class="nav navbar-nav"><?= $menu ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="container"><?= $html ?>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js"></script>
  </body>
</html>
