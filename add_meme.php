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

$textUP = $_GET["TextUP"];
$textDOWN = $_GET["TextDOWN"];
$name = $_GET["Name"];
$bild = $_GET["Bild"];


$pk_name = getNameID($queryBuilder, $name);
$pk_picture = getPictureID($queryBuilder, $bild);
if(!$pk_name){
    insertUser($queryBuilder, $name);
    $pk_name = getNameID($queryBuilder, $name);
}
insertMeme($queryBuilder, $textUP, $textDOWN, $pk_name["PK_UserID"], $pk_picture["PK_PictureID"]);




function getNameID($queryBuilder, $name){
    return $queryBuilder
        ->select('PK_UserID')
        ->from('memebenutzer')
        ->where("Name = :Name")
        ->setParameter("Name",  $name)
        ->execute()
        ->fetch();
}

function getPictureID($queryBuilder, $bild){
    return $queryBuilder
        ->select('PK_PictureID')
        ->from('Picture')
        ->where("Pfad = :Pfad")
        ->setParameter("Pfad",  $bild)
        ->execute()
        ->fetch();
}

function insertUser($queryBuilder, $name){
    $queryBuilder
        ->insert('memebenutzer')
        ->values([
            "Name" => ":Name"
        ])
        ->setParameter("Name",$name)
        ->execute();
}

function insertMeme($queryBuilder, $TextUP, $TextDown, $pk_name,$pk_bild){
    $queryBuilder
    ->insert('meme')
        ->values([
            "FK_UserID" => ":pk_name",
            "TextUP" => ":TextUP",
            "TextDOWN" => ":TextDown",
            "FK_PictureID" => ":pk_bild",
        ])
        ->setParameter("pk_name",$pk_name)
        ->setParameter("TextUP",$TextUP)
        ->setParameter("TextDown",$TextDown)
        ->setParameter("pk_bild",$pk_bild)
        ->execute();

    echo file_get_contents("Template/add_meme.html");


}


