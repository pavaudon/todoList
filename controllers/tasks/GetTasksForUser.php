<?php

// Entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: GET");

require("../../models/User.php");
require("../../models/Task.php");

if ($_SERVER['REQUEST_METHOD'] === "GET") {
  $database = new Database();
  $db = $database->getConnexion();
  $task = new Task($db);
  $user = new User($db);
  $data = json_decode(file_get_contents("php://input"));
  if (!empty($data->user_id)) {
    if (!$user->getUserById(intval($data->user_id))) {
      http_response_code(503);
      echo json_encode(['message' => "Le user renseigné n'existe pas"]);
    } else {
      $tasks = $task->getTasks($data->user_id);
      if ($tasks->rowCount() > 0) {
        $res_tasks = [];
        $res_tasks[] = $tasks->fetchAll();
        http_response_code(200);
        echo json_encode($res_tasks);
      } else {
        echo json_encode(["message" => "Aucune donnée à renvoyer"]);
      }
    }
  } else {
    http_response_code(503);
    echo json_encode(['message' => "Les données ne sont pas complètes"]);
  }
} else {
  http_response_code(405);
  echo json_encode(['message' => "La méthode n'est pas autorisée"]);
}