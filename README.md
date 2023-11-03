### Tables :

## User :
  id
  name
  email

## règles :

# Get all => http://localhost/todoList/controllers/users/getAllUsers.php
-> return tous les users

# Post => http://localhost/todoList/controllers/users/CreateUser.php
Demande : 
  "name": "nom",
  "email": "email"
-> return "Nouveau user ajouté" si la requête est bonne

# Put => http://localhost/todoList/controllers/users/UpdateUser.php
Demande :
  "id": nb_id_du_user_a_modifier,
  ET/OU "name": "nom",
  ET/OU "email": "email"
-> return "Le user a été modifié" si la requête est bonne

# Delete => http://localhost/todoList/controllers/users/UpdateUser.php
Demande :
  "id": nb_id_du_user_a_supprimer
-> return "Le user a été supprimé" si la requête est bonne
-> return "la tâche a été supprimée" si il y en a pour ce user

# Get all => http://localhost/todoList/controllers/tasks/getAllTasks.php
-> return toutes les tasks
  
# Get => http://localhost/todoList/controllers/tasks/GetTasksForUser.php
Demande :
  "user_id": nb_id_du_user
-> return toutes les tasks pour un user donné

# Post => http://localhost/todoList/controllers/tasks/CreateTask.php
Demande : 
  "title": "titre",
  "description": "description",
  "status": 1 / 2 / 3
-> return "Nouvelle Tâche ajoutée" si la requête est bonne

# Put => http://localhost/todoList/controllers/tasks/UpdateTask.php
Demande :
  "id": nb_id_de_la_Task_a_modifier,
  ET/OU "title": "titre",
  ET/OU "description": "description",
  ET/OU "status": 1 / 2 / 3
-> return "La tâche a été modifié" si la requête est bonne

# Delete => http://localhost/todoList/controllers/tasks/UpdateTask.php
Demande :
  "id": nb_id_de_la_task_a_supprimer
-> return "La tâche a été supprimé" si la requête est bonne


## Task :
  id
  user_id
  title
  description
  creation_date
  status
