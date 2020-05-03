<?php
require "vendor/autoload.php";
require "konfig.php";
$connectionParams = getkonfig();

$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams);

if (!$conn) {
    die("Error");
}
$queryBuilder = $conn->createQueryBuilder();
if (!$queryBuilder) {
    die('Ungültige Abfrage: ' . mysqli_error());
}


$memes = $queryBuilder
    ->select('TextUP', 'TextDOWN', 'Name', 'Pfad')
    ->from('meme')
    //->join('memebenutzer', 'memebenutzer', 'ON', 'FK_UserID = memebenutzer.UserID')
    ->innerJoin('meme', 'memebenutzer', 'mb', 'FK_UserID = mb.PK_UserID')
    ->innerJoin('meme', 'picture', 'pc', 'FK_PictureID = pc.PK_PictureID')
    ->execute()
    ->fetchAll();

// Initializing the View: rendering in Fluid takes place through a View instance
// which contains a RenderingContext that in turn contains things like definitions
// of template paths, instances of variable containers and similar.
$view = new \TYPO3Fluid\Fluid\View\TemplateView();

// TemplatePaths object: a subclass can be used if custom resolving is wanted.
$paths = $view->getTemplatePaths();

// Assigning the template path and filename to be rendered. Doing this overrides
// resolving normally done by the TemplatePaths and directly renders this file.
$paths->setTemplatePathAndFilename(__DIR__ . '/Template/Startseite.html');

$view->assignMultiple(
    array(
        "memes" => $memes
    )
);

// Rendering the View: plain old rendering of single file, no bells and whistles.
$output = $view->render();

echo $output;

/*
foreach ($memes as $meme){
$textup = $meme['TextUP'];
$textdown = $meme['TextDOWN'];
$name = $meme['Name'];
$pfad = $meme['Pfad'];
echo <<<END
<div>
<h2>$textup</h2>
<h2>$textdown</h2>
<img src = "images/$pfad">
<br>
<p>$name</p>
<br>
</div>
END;
}
*/

