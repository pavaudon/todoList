<?php

// Entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: POST");

require("../../models/User.php");
require("../../models/Task.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {

  $database = new Database();
  $db = $database->getConnexion();
  $task = new Task($db);
  $user = new User($db);
  $data = json_decode(file_get_contents("php://input"));
  if (!empty($data->user_id) && !empty($data->title) && !empty($data->description) && !empty($data->status)) {
    if (!$task->vakidStatus($data->status)) {
      http_response_code(503);
      echo json_encode(['message' => "Le status ne peut être que entre 1 et 3"]);
    } if (! $user->getUserById($data->user_id)) {
      http_response_code(503);
      echo json_encode(['message' => "Le user renseigné n'existe pas"]);
    } else {
      $task->user_id = intval($data->user_id);
      $task->title = htmlspecialchars($data->title);
      $task->description = htmlspecialchars($data->description);
      $task->status = htmlspecialchars($data->status);
      $result = $task->create();
      if ($result) {
        http_response_code(201);
        echo json_encode(['message' => "Nouvelle tâche ajoutée"]);
      } else {
          http_response_code(503);
          echo json_encode(['message' => "L'ajout de la tâche a échoué"]);
      }
    }
  }
} else {
  http_response_code(405);
  echo json_encode(['message' => "La méthode n'est pas autorisée"]);
}