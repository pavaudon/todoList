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
    $user = new User($db);
    $task = new Task($db);
    // On récupère les infos envoyées
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->id)) {
        $user->id = $data->id;
        $tasks = $task->getTasks($data->id);
        if ($tasks->rowCount() > 0) {
            foreach ($tasks as $row) {
                $task->id = intval($row["id"]);
                if ($task->delete()) {
                    http_response_code(200);
                    echo json_encode(array("message" => "La tâche a été supprimée"));
                } else {
                    http_response_code(503);
                    echo json_encode(array("message" => "La suppression n'a pas été éffectuée"));
                }
            }
        }
        if ($user->delete()) {
            http_response_code(200);
            echo json_encode(array("message" => "Le user a été supprimé"));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "La suppression n'a pas été éffectuée"));
        }
    } else {
        http_response_code(503);
        echo json_encode(['message' => "Vous devez preciser l'identifiant du user"]);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => "La méthode n'est pas autorisée"]);
}