<?php

require_once("../config/Database.php");
class User
{
    private $table = "user";
    private $connexion = null;

    // Les propritées de l'objet etudiant
    public $id;
    public $name;
    public $email;
    public function __construct($db)
    {
        if ($this->connexion == null) {
            $this->connexion = $db;
        }
    }

    // Lecture des étudiants

    public function getAll()
    {
        // On ecrit la requete
        $sql = "SELECT * FROM $this->table ORDER BY id DESC";

        // On éxecute la requête
        $req = $this->connexion->query($sql);

        // On retourne le resultat
        return $req;
    }
    public function create()
    {
        $sql = "INSERT INTO $this->table(name,email) VALUES(:name,:email)";

        // Préparation de la requête
        $req = $this->connexion->prepare($sql);

        // éxecution de la requête
        $re = $req->execute([
            ":name" => $this->name,
            ":email" => $this->email
        ]);
        if ($re) {
            return true;
        } else {
            return false;
        }
    }

    public function update($updataName, $updateEmail)
    {
        $sql = "UPDATE $this->table SET name=:name, email=:email WHERE id=:id";

        // Préparation de la réqête
        $req = $this->connexion->prepare($sql);

        // éxecution de la reqête
        $re = $req->execute([
            ":name" => $updataName,
            ":email" => $updateEmail,
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