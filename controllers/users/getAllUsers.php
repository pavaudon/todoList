<?php

// Entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: GET");

require("../../models/User.php");

if ($_SERVER['REQUEST_METHOD'] === "GET") {
  $database = new Database();
  $db = $database->getConnexion();
  $user = new User($db);
  // Récupération des données
  $users = $user->getAll();
  if ($users->rowCount() > 0) {
    $data = [];
    $data[] = $users->fetchAll();
    // renvoie des données sous format json
    http_response_code(200);
    echo json_encode($data);
  } else {
    http_response_code(503);
    echo json_encode(["message" => "Aucune donnée à renvoyer"]);
  }
} else {
  http_response_code(405);
  echo json_encode(['message' => "La méthode n'est pas autorisée"]);
}