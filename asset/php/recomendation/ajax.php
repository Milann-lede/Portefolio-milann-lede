<?php
// Connexion BDD + démarrage de session
require '../header.php';

if (isset($_GET['action']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if ($_GET['action'] === 'change_ordrerecomendation') {
        
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        var_dump($data);

        if ($data['oldIndex'] < $data['newIndex']) {
            $req = $bdd->prepare("UPDATE recomendation SET ordre =  -1 WHERE ordre = :ordre");
            $req->execute(array(
            'ordre' => $data['oldIndex']
            )); 
            
        for($i = $data['oldIndex'] + 1; $i <= $data['newIndex']; $i++){
            $req = $bdd->prepare("UPDATE recomendation SET ordre =  ?  WHERE ordre = ?");
            $req->execute(array(
            $i -1, $i

            )); 
        }

        $req = $bdd->prepare("UPDATE recomendation SET ordre = :ordre   WHERE ordre = -1 ");
            $req->execute(array(
            'ordre' => $data['newIndex']
            )); 
            
            
        } elseif ($data['oldIndex'] > $data['newIndex']) {
            $req = $bdd->prepare("UPDATE recomendation SET ordre = -1 WHERE ordre = :ordre");
            $req->execute(array(
                'ordre' => $data['oldIndex']
            ));

            for ($i = $data['oldIndex'] - 1; $i >= $data['newIndex']; $i--) {
                $req = $bdd->prepare("UPDATE recomendation SET ordre = ? WHERE ordre = ?");
                $req->execute(array(
                    $i + 1, $i
                ));
            }

            $req = $bdd->prepare("UPDATE recomendation SET ordre = :ordre WHERE ordre = -1");
            $req->execute(array(
                'ordre' => $data['newIndex']
            ));
        }
        
        
    }
        
}
    
