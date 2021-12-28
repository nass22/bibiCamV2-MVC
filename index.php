<?php
require ('model.php');
/*
//Permet de display les erreurs
error_reporting(E_ALL);
ini_set("display_errors", 1);
*/


//On insert les données bibi/pipi/popo des inputs dans la db
$type=$_POST['type'];
$date=$_POST['date'];
$quantity=(int)$_POST['qty'];

switch ($type){
    case "bibi":
        if (isset($date) && !empty($quantity)){
            $db=dbConnect();
            $insertBibi=$db->prepare('INSERT INTO bibi(date, qty) VALUES (:date, :qty)');
            $insertBibi->bindParam('date', $date);
            $insertBibi->bindParam('qty', $quantity);
            $insertBibi->execute();
        }
        break;
    case "pipi":
        if (isset($date)){
            $insertPipi=$db->prepare('INSERT INTO pipi(date) VALUES (:date)');
            $insertPipi->bindParam('date', $date);
            $insertPipi->execute();
        }
        break;
    case "popo":
        if (isset($date)){
            $insertPopo=$db->prepare('INSERT INTO popo(date) VALUES (:date)');
            $insertPopo->bindParam('date', $date);
            $insertPopo->execute();
        }
        break;
}


//On récupère le nombre de bibi par jour
$sqlNumbBibiResp=getNumberBibi();
$numberBibi=$sqlNumbBibiResp['count_today'];

//On récupère le nbre de ml par jour
$sqlSumResp=getMlBibi();
$numberMl= $sqlSumResp['sum_today'];

//On récupère les données des Bibi
$sqlBibiResp=getBibi()->fetch();
$bibiId=$sqlBibiResp['id'];
$bibiDate=date('d/m/Y H:i:s', strtotime($sqlBibiResp['date']));
$bibiQty=$sqlBibiResp['qty'];

//On récupère les données des Popo
$sqlPopoResp = getPopo()->fetch();
$popoId=$sqlPopoResp['id'];
$datePopo=date('d/m/Y H:i:s', strtotime($sqlPopoResp['date']));

//On récupère les données des Pipi
$sqlPipiResp=getPipi()->fetch();
$pipiId=$sqlPipiResp['id'];
$datePipi=date('d/m/Y H:i:s', strtotime($sqlPipiResp['date']));


//On supprime un élément
$table=$_GET['name'];
$id=$_GET['id'];

if (!empty($table) && !empty($id)){
    switch ($table){
        case 'bibi':
            $sqlDeleteQuery='DELETE FROM bibi WHERE id = :id';
            $sqlDeleteStm=$db->prepare($sqlDeleteQuery);
            $sqlDeleteStm->bindParam('id', $id);
            $sqlDeleteStm->execute();
            header("Location:index.php");
            break;
        case 'pipi':
            $sqlDeleteQuery='DELETE FROM pipi WHERE id = :id';
            $sqlDeleteStm=$db->prepare($sqlDeleteQuery);
            $sqlDeleteStm->bindParam('id', $id);
            $sqlDeleteStm->execute();
            header("Location:index.php");
            break;
        case 'popo':
            $sqlDeleteQuery='DELETE FROM popo WHERE id = :id';
            $sqlDeleteStm=$db->prepare($sqlDeleteQuery);
            $sqlDeleteStm->bindParam('id', $id);
            $sqlDeleteStm->execute();
            header("Location:index.php");
            break;
    } 
}


require('view.php');

?>