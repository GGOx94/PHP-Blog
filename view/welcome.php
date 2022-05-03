<?php 

require_once('vendor/autoload.php');

$loader = new \Twig\Loader\FilesystemLoader('./view/templates');
$twig = new \Twig\Environment($loader);

$title = 'Amazing blog';
$content = $twig->render('welcome.twig', [
    'title' => $title
]);

echo $twig->render('base.twig', [
    'title' => $title,
    'content' => $content
]);