<?php 

require_once('vendor/autoload.php');

$loader = new \Twig\Loader\FilesystemLoader('./view/templates');
$twig = new \Twig\Environment($loader);

$title = '[GGO] P5-Blog-PHP';
$content = $twig->render('welcome.twig', []);

echo $twig->render('base.twig',
[
    'title' => $title,
    'content' => $content
]);