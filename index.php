<?php
// index.php 20130811 - 20171031
// Copyright (C) 1995-2017 Mark Constable <markc@renta.net> (AGPL-3.0)
// A simple script to render Markdown files within a single page.

define('DESC', 'Independent ALSA and linux audio support site');
define('TITLE', 'Alsa Opensrc Org');
define('FOOTER', 'Copyright &copy; 2013-2018 OpenSrc Team (AGPL-3.0)');
define('BLOB', 'https://github.com/opensrc/alsa/blob/master/');
define('EDIT', 'https://github.com/opensrc/alsa/edit/master/');

require 'lib/php/Markdown.php';
use \Michelf\Markdown;

//error_log(var_export($_SERVER, true));
//$page = isset($_GET['q']) ? htmlspecialchars(trim($_GET['q'], '/')) : '';
$page = isset($_SERVER['REQUEST_URI']) ? htmlspecialchars(trim($_SERVER['REQUEST_URI'], '/')) : '';
error_log("page = $page");

if ($page) {
    if (file_exists('lib/md/' . $page . '.md')) {
        $html = Markdown::defaultTransform(file_get_contents('lib/md/' . $page . '.md')).'
<div class="right">
<small>
<a href="'.BLOB.'lib/md/'.$page.'.md">GITHUB</a> |
<a href="'.EDIT.'lib/md/'.$page.'.md">EDIT</a>
</small>
</div>';
    } else {
        header('HTTP/1.0 404 Not Found');
        $html = '<h1 class="text-center">404 Page Not Found</h1>';
    }
    $class = '';
} else {
    $html = include 'lib/php/navigation.php';
    $class = ' intro';
}

$menu = '';
$menu_ary = [
    ['README', '<span class=icon-newspaper-o></span>'],
    ['Github', '<span class=icon-globe></span>'],
    ['User:Markc', '<span class=icon-user></span>'],
];

foreach($menu_ary as $m) {
    $c = $m[0] == $page ? ' active' : '';
    $menu .= '
<a class="link'.$c.'" href="/'.$m[0].'">'.$m[1].' <b>'.$m[0].'</b></a>';
}

?>
<!doctype html>
<html lang=en>
<head>
<meta charset=UTF-8>
<meta name=viewport content="width=device-width, initial-scale=1">
<meta name=description content="<?=TITLE?> - <?=DESC?>">
<title><?=TITLE?> - <?=DESC?></title>
<link rel="shortcut icon" href="/lib/img/favicon.ico" type="image/x-icon">
<link href="/lib/css/style.css" rel=stylesheet>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-60445335-5"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','UA-60445335-5');</script>
</head>
<body>
<header class=navbar>
<input type=checkbox id=menu-toggle>
<label for=menu-toggle class=label-toggle></label>
<nav id=topnav class=container>
<a class=logo href="/"><?=TITLE?></a><?=$menu?>
</nav>
</header>
<div class=center><i><?=DESC?></i></div>
<main>
<div class="container<?=$class?>"><?=$html?>
</div>
</main>
<footer>
<p class=center>
<?=FOOTER?><br>
Hosting provided by
<a href="https://renta.net" title="RentaNet - Domain, Mail and Web Hosting with extra Storage and Support options"><b>RentaNet</b></a><br>
</p>
</footer>
</body>
</html>
