<?php
// Entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: DELETE");

require("../../models/User.php");
require("../../models/Task.php");

if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    $database = new Database();
    $db = $database->getConnexion();
    $task = new Task($db);
    // On récupère les infos envoyées
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->id)) {
        $task->id = $data->id;
        if ($task->delete()) {
            http_response_code(200);
            echo json_encode(array("message" => "La tâche a été supprimée"));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "La suppression n'a pas été éffectuée"));
        }
    } else {
        echo json_encode(['message' => "Vous devez preciser l'identifiant du user"]);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => "La méthode n'est pas autorisée"]);
}