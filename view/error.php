<?php 

require_once('vendor/autoload.php');

$loader = new \Twig\Loader\FilesystemLoader('./view/templates');
$twig = new \Twig\Environment($loader);

$title = 'Erreur !';
$content = $twig->render('error.twig', [
    'error_str' => $error_str
]);

echo $twig->render('base.twig', [
    'title' => $title,
    'content' => $content
]);