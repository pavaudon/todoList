<?php
// Les entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: PUT");

require("../../models/User.php");
require("../../models/Task.php");

if ($_SERVER['REQUEST_METHOD'] === "PUT") {

  $database = new Database();
  $db = $database->getConnexion();
  // On instancie l'objet user
  $user = new User($db);
  $task = new Task($db);

  // On récupère les infos envoyées
  $data = json_decode(file_get_contents("php://input"));
  if (!empty($data->id)) {
    $task->id = intval($data->id);
    $update_title = $task->title;
    $update_description = $task->description;
    if (!$task->vakidStatus($data->status)) {
      http_response_code(503);
      echo json_encode(['message' => "Le status ne peut être que entre 1 et 3"]);
    } else {
      $update_status = intval($task->status);
      $data_update = false;
      if (!empty($data->title)) {
        $update_title = htmlspecialchars($data->title);
        $data_update = true;
      }
      if (!empty($data->description)) {
        $update_description = htmlspecialchars($data->description);
        $data_update = true;
      }
      if (!empty($data->status)) {
        $update_status = intval($data->status);
        $data_update = true;
      }
      if (!$data_update) {
        http_response_code(503);
        echo json_encode(['message' => "Veuillez donner les modifications à effectuer"]);
      } else {
        $result = $task->update($update_title, $update_description, $update_status);
        if ($result) {
          http_response_code(201);
          echo json_encode(['message' => "La tâche a été modifiée"]);
        } else {
          http_response_code(503);
          echo json_encode(['message' => "La modification de la tâche a échouée"]);
        }
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