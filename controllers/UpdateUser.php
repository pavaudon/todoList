<?php
// Les entêtes requises
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset= UTF-8");
header("Access-Control-Allow-Methods: PUT");

require_once '../config/Database.php';
require_once '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === "PUT") {

  $database = new Database();
  $db = $database->getConnexion();

  // On instancie l'objet user
  $user = new User($db);

  // On récupère les infos envoyées
  $data = json_decode(file_get_contents("php://input"));
  if (!empty($data->id)) {
    $user->id = intval($data->id);
    $update_name = $user->name;
    $update_email = $user->email;
    $data_update = false;
    if (!empty($data->name)) {
      $update_name = htmlspecialchars($data->name);
      $data_update = true;
    }
    if (!empty($data->email)) {
      $update_email = htmlspecialchars($data->email);
      $data_update = true;
    }
    if (!$data_update) {
      http_response_code(503);
      echo json_encode(['message' => "Veuillez donner les modifications a effectuer"]);
    } else {
      $result = $user->update($update_name, $update_email);
      if ($result) {
        http_response_code(201);
        echo json_encode(['message' => "Le user a été modifié"]);
      } else {
        http_response_code(503);
        echo json_encode(['message' => "La modification du user a échouée"]);
      }
    }
  } else {
    echo json_encode(['message' => "Les données ne sont au complètes"]);
  }
} else {
  http_response_code(405);
  echo json_encode(['message' => "La méthode n'est pas autorisée"]);
}