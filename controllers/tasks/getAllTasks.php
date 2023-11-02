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
  // Récupération des données
  $statement = $task->getAll();
  if ($statement->rowCount() > 0) {
    $data = [];
    $data[] = $statement->fetchAll();
    // renvoie des données sous format json
    http_response_code(200);
    echo json_encode($data);
  } else {
    echo json_encode(["message" => "Aucune donnée à renvoyer"]);
  }
} else {
  http_response_code(405);
  echo json_encode(['message' => "La méthode n'est pas autorisée"]);
}