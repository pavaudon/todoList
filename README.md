### Tables :

## User :
  id
  name
  email

## règles :

# Get all => http://localhost/todoList/controllers/getAll.php
-> return tous les users
  # TODO ajouter getUserById (nécessaire pour les règles de la table Task)

# Post => http://localhost/todoList/controllers/Create.php
Demande : 
  "name": "nom",
  "email": "email"
-> return "Nouveau user ajouté" si la requête est bonne

# Put => http://localhost/todoList/controllers/Update.php
Demande :
  "id": nb_id_du_user_a_modifier,
  ET/OU "name": "nom",
  ET/OU "email": "email"
-> return "Le user a été modifié" si la requête est bonne

# Delete => http://localhost/todoList/controllers/Update.php
Demande :
  "id": nb_id_du_user_a_supprimer
-> return "Le user a été supprimé" si la requête est bonne

## Task :
  id
  user_id
  title
  description
  creation_date
  status
