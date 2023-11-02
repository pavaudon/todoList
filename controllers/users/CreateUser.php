<?php

// Entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: POST");

require("../../models/User.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $database = new Database();
  $db = $database->getConnexion();
  $user = new User($db);
  // On récupère les infos envoyées
  $data = json_decode(file_get_contents("php://input"));
  if (!empty($data->name) && !empty($data->email)) {
      $user->name = htmlspecialchars($data->name);
      $user->email = htmlspecialchars($data->email);
      if (!$user->is_valid_email($user->email)) {
        http_response_code(503);
        echo json_encode(['message' => "Le mail renseigné n'est pas valide"]);
      } else if ($user->email_already_exists($data->email)) {
        http_response_code(503);
        echo json_encode(['message' => "Le mail renseigné est déjà utilisés"]);
      } else {
        $result = $user->create();
      if ($result) {
          http_response_code(201);
          echo json_encode(['message' => "Nouveau user ajouté"]);
      } else {
          http_response_code(503);
          echo json_encode(['message' => "L'ajout du user a échoué"]);
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