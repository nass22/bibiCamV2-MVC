<?php 

/*
//Permet de display les erreurs
error_reporting(E_ALL);
ini_set("display_errors", 1);
*/


//On se connecte à la db grâce à PDO
function dbConnect(){
    $servname='localhost';
    $dbname='bibicam';
    $user='root';
    $password='root';
    
    try{
        $db= new PDO(
            "mysql:host=$servname;dbname=$dbname;charset=utf8", $user, $password);
            //On définit le mode d'erreur de PDO sur Exception
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e){
        //On capture les exceptions si une exception est lancée et on affiche les informations relatives à celle-ci
        die('Erreur: ' . $e->getMessage());
    }
}

//On set le fuseau 
date_default_timezone_set('Europe/Paris');
$todayDate=date('Y-m-d');

//On récupère les bibi dans la DB
function getBibi(){
    $db=dbConnect();
    $sqlBibiQuery='SELECT id, date, qty FROM bibi ORDER BY date DESC LIMIT 0,10';
    $sqlBibiStm= $db -> prepare($sqlBibiQuery);
    $sqlBibiStm->execute();
    return $sqlBibiStm;
}

//On récupère les pipi dans la DB
function getPipi(){
    $db=dbConnect();
    $sqlPipiQuery='SELECT id, date FROM pipi ORDER BY date DESC LIMIT 0,10';
    $sqlPipiStm= $db -> prepare($sqlPipiQuery);
    $sqlPipiStm->execute();
    return $sqlPipiStm;
}

//On récupère les popo dans la DB
function getPopo(){
    $db=dbConnect();
    $sqlPopoQuery='SELECT id, date FROM popo ORDER BY date DESC LIMIT 0,10';
    $sqlPopoStm= $db -> prepare($sqlPopoQuery);
    $sqlPopoStm->execute();
    return $sqlPopoStm;
}

//On calcule le nombre de ml du jour
function getMlBibi(){
    $db=dbConnect();
    $sqlSumQuery='SELECT SUM(qty) AS sum_today FROM bibi WHERE date BETWEEN :date AND :date + INTERVAL 1 DAY';
    $sqlSumStm= $db -> prepare($sqlSumQuery);
    $sqlSumStm->bindParam('date', $todayDate);
    $sqlSumStm->execute();
    $sqlSumResp=$sqlSumStm->fetch();
    return $sqlSumResp;
}

//On calcule le nbre de bibi du jour
function getNumberBibi(){
    $db=dbConnect();
    $sqlNumberBibiQuery='SELECT COUNT(qty) AS count_today FROM bibi WHERE date BETWEEN :date AND :date + INTERVAL 1 DAY';
    $sqlNumbBibiStm= $db -> prepare($sqlNumberBibiQuery);
    $sqlNumbBibiStm->bindParam('date', $todayDate);
    $sqlNumbBibiStm->execute();
    $sqlNumbBibiResp=$sqlNumbBibiStm->fetch();
    return $sqlNumbBibiResp;
}










?>