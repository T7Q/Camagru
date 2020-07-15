# CAMAGRU - Photo Editing App
This project is a part of the web branch at [Hive Helsinki](https://www.hive.fi/) coding school. 

## Task
The aim of this project is to build an Instagram-like web app, that allows to make basic photo editing using webcam and predefied images.Users are able to select and a frame, take a picture with webcam and admire the result of mixing both pictures.

The app requirements:
- MVC structure
- Responsive design
- Website secure (no SQL, HTML injections, plain passwords in the dataases)
- Authorized languages:
	[Server] PHP
	[Client] HTML - CSS - JavaScript (only wiht browser native API)
- Authorized frameworks:
	[Server] None
	[Client] CSS Framework tolerated, unless adds forbidden JavaScript
- Firefox and Chrome support
- MySQL with PDO.


## Functionality
* User features: 
	* Register / Login (including activating account and reseting password through a unique link send by email)
	* User profile page
	* User data management: modify user data (username, email, password), delete create images, set notification preferences.
* Gallery features:
	* All images are public and likeable and commentable by logged in users.
	* Once image is commented or liked the author is notified by email.
	* Infinite scroll gallery
* Editing features:
	* Create custom images using webcam or images downloaded from computer combined with filters

## Tech stack
* PHP
* HTML
* CSS
* JavaScript
* AJAX

## Website wireframe
![Gallery draft](../assets/Gallery.png?raw=true)
![Profile draft](../assets/Profile.png?raw=true)
![Photo draft](../assets/Photo.png?raw=true)

## Database structure
![Database planning](../assets/db.png?raw=true)


## Run locally

* Install [mamp](https://bitnami.com/stack/mamp)
* Make sure you can send main from terminal, here is a good link if you have [macOS Catalina](https://gist.github.com/loziju/66d3f024e102704ff5222e54a4bfd50e)


* Git clone repo
* Update the following files to match your environment:
	* go to htaccess file, change ```RewriteBase /camagru/public``` to the name of the folder the repo is cloned, e.g. ```/YOUR_FOLDER_RNAME/public```
	* go to app/config/config.php updated URL Root ```define('URLROOT', 'http://localhost:8080/camagru')```
	* go to app/config/database.php update database user name, password and database

* Launch app/config/setup.php to create database
* Open http://localhost:8080/ in your prefered browser
