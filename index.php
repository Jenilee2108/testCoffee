<?php
    require("vendor/autoload.php");

    if($_SERVER['REQUEST_URI'] != "testcoffee-1.herokuapp.com"){
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }

    $path="mysql:dbname=".$_ENV['DB_NAME'].";host=".$_ENV['DB_HOST'].":".$_ENV['DB_PORT'].";charset=utf8";
    $user= $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];
        try{
            $bdd=new PDO($path,$user,$password);
        }
        catch(PDOException $e){
            echo "connexion dist refusée :".$e -> getMessage();
        };

// $requete =
//     "SELECT serveur.nom AS nom, FORMAT(SUM(cc.prix),2) AS turnover FROM `commande`
//     INNER JOIN `commandeconsommation`AS cc ON commande.id = cc.id_commande
//     INNER JOIN `serveur` ON commande.id_serveur = serveur.id
//     GROUP BY serveur.id
//     ";
// foreach($bdd2->query($requete) as $reponse){
//     echo "<p>".$reponse['nom']. "<br>". $reponse['turnover']. "</p>";
// };

$requete = 
    "SELECT serveur.nom AS nom, FORMAT(SUM(cc.prix),2) AS turnover FROM `commande`
    INNER JOIN `commandeconsommation`AS cc ON commande.id = cc.id_commande
    INNER JOIN `serveur` ON commande.id_serveur = serveur.id
    GROUP BY serveur.id
    ";

$reponses=$bdd->query($requete);
// var_dump($reponses->fetch());
$reponses =$reponses->fetchAll();
foreach($reponses as $reponse){
    echo $reponse['nom']  ." ". $reponse['turnover']. "<br>";
}


?>