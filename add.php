<?php
require "vendor/autoload.php";


$view = new \TYPO3Fluid\Fluid\View\TemplateView();

$paths = $view->getTemplatePaths();

$paths->setTemplatePathAndFilename(__DIR__ . '/Template/add.html');

$view->assignMultiple(
    array(

    )
);


$output = $view->render();

echo $output;
