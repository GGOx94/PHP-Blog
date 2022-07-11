# P5-PHP-Blog

Projet 5 de la formation **PHP/Symfony** d'OpenClassrooms : Créez votre premier blog en PHP !

## Essayer le projet

Pour installer le projet sur votre machine, suivez ces étapes :
- Installez un environnement PHP / MySQL / Apache *(par exemple avec [XAMPP](https://www.apachefriends.org/))*
- Installez [Composer](https://getcomposer.org/download/)
- Clonez le projet dans un répertoire et exécutez :
	
		composer install
- Créez la base de données via */sql/create_db_demo_data.sql*
	>Ce script créera une base de données "p5phpblogDEMO" avec un jeu de démo
		Les informations sur les accès utilisateurs sont disponibles au début de ce script
	
- Modifiez *config/config.php* avec :
	- Un utilisateur ayant les accès à cette nouvelle base de données
	- Le host de la base de données *(par exemple: `localhost`)*
	- L'URL du blog *(par exemple : `http://localhost:80`)*, ceci est utile pour la partie Mailer
	- Le DSN du serveur de mail que vous souhaitez utiliser
		>Par exemple, en utilisant [Mailtrap](https://mailtrap.io/) : 
		`smtp://[USER]:[PASSWD]@smtp.mailtrap.io:2525`

### Tout est prêt !
Une fois Apache et MySQL lancés, le blog sera accessible (par défaut sur : http://localhost:80)
