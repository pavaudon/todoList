<?php

//require("../../config/Database.php");

define(1, "à faire");
define(2, "en cours");
define(3, "fini");
class Task {
  private $table = "task";
  private $connexion = null;
  // Les propritées de l'objet etudiant
  public $id;
  public $user_id;
  public $title;
  public $description;
  public $creation_date;
  public $status;
  public function __construct($db)
  {
      if ($this->connexion == null) {
          $this->connexion = $db;
      }
  }

  public function vakidStatus($status) {
    if (!is_numeric($status)) {
      return false;
    }
    $int_status = intval($status);
    if (!is_int($int_status) || $int_status > 3 || $int_status < 1) {
      return false;
    }
    return true;
  }

  public function getTasks($user_id) {
    $sql = "SELECT t.* FROM $this->table t WHERE t.user_id = :user_id";
    $req = $this->connexion->prepare($sql);
    $req->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $req->execute();
    return $req;
  }
  public function getAll()
    {
      $sql = "SELECT * FROM $this->table ORDER BY id DESC";
      $req = $this->connexion->query($sql);
      return $req;
    }

    public function create()
    {
      $sql = "INSERT INTO $this->table(user_id, title, description, creation_date, status) VALUES(:user_id,:title,:description,NOW(),:status)";
      // Préparation de la requête
      $req = $this->connexion->prepare($sql);
      // éxecution de la requête
      $re = $req->execute([
          ":user_id" => $this->user_id,
          ":title" => $this->title,
          ":description" => $this->description,
          ":status" => $this->status
      ]);
      if ($re) {
          return true;
      } else {
          return false;
      }
    }

    public function update($updatetitle, $updateDescription, $updateStatus)
    {
      $sql = "UPDATE $this->table SET title=:title, description=:description, status=:status WHERE id=:id";
      // Préparation de la réquête
      $req = $this->connexion->prepare($sql);
      // éxecution de la requête
      $re = $req->execute([
          ":title" => $updatetitle,
          ":description" => $updateDescription,
          ":status" => $updateStatus,
          ":id" => $this->id
      ]);
      if ($re) {
          return true;
      } else {
          return false;
      }
    }

    public function delete()
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $req = $this->connexion->prepare($sql);

        $re = $req->execute(array(":id" => $this->id));

        if ($re) {
            return true;
        } else {
            return false;
        }
    }
}