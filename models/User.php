<?php

//C:/xampp/htdocs/todorepo/config/Database.php
require("../../config/Database.php");
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
    public function is_valid_email($email) {
        $email = trim($email);
        //"@.fr" vaut 4, donc une adresse mail valide vaut minimum 6
        if (strlen($email) < 6) {
            return false;
        }
        $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
        if (preg_match($pattern, $email) !== 1) {
            return false;
        }
        // Vérifier la présence d'au moins un point (.) après l'@
        if (strpos($email, '@') !== false && strpos($email, '.', strpos($email, '@')) === false) {
            return false;
        }
        // Vérifier que l'e-mail ne commence pas par un point (.)
        if (strpos($email, '.') === 0) {
            return false;
        }
        return true;
    } 

    public function email_already_exists($email) {
        $sql = "SELECT COUNT(*) FROM $this->table WHERE email = :email";
        $req = $this->connexion->query($sql);
        $req->bindParam(':email', $email);
        $req->execute();

        $count = $req->fetchColumn();

        if ($count > 0) {
            echo "L'adresse e-mail existe déjà dans la table.";
            return true;
        }
        return false;
    }
    public function getAll()
    {
        // On ecrit la requete
        $sql = "SELECT * FROM $this->table ORDER BY id DESC";

        // On éxecute la requête
        $req = $this->connexion->query($sql);

        // On retourne le resultat
        return $req;
    }

    public function getUserById($id) {
        $sql = "SELECT id FROM $this->table WHERE id = :id";
        // Préparation de la requête
        $req = $this->connexion->prepare($sql);
        // éxecution de la requête
        $req->bindParam(':id', $id, PDO::PARAM_STR);
        $req->execute();
        $user = $req->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return $user;
        } else {
            return null; // L'utilisateur n'a pas été trouvé
        }
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

    public function update($updateaName, $updateEmail)
    {
        $sql = "UPDATE $this->table SET name=:name, email=:email WHERE id=:id";

        // Préparation de la réqête
        $req = $this->connexion->prepare($sql);

        // éxecution de la reqête
        $re = $req->execute([
            ":name" => $updateaName,
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