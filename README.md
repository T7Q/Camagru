# CAMAGRU - Photo Editing App
This project is a part of the web branch at Hive Helsinki coding school. 

## Task
The aim of this project is to build an Instagram-like web app, that allows to make basic photo editing using webcam and predefied images.
Users are able to select and a frame, take a picture with webcam and admire the result of mixing both pictures.
The app should have MVC structure, responsive design and be secure (no SQL, HTML injections, plain passwords in the dataases), support Firefox and Chrome and use MySQL with PDO.
Authorized languages:
[Server] PHP
[Client] HTML - CSS - JavaScript (only wiht browser native API)
Authorized frameworks:
[Server] None
[Client] CSS Framework tolerated, unless adds forbidden JavaScript

## Functionality
* User features: 
** Register / Login (including activating account and reseting password through a unique link send by email)
** User profile page
** User data management: modify user data (username, email, password), delete create images, set notification preferences.
* Gallery features:
** All images are public and likeable and commentable by logged in users.
** Once image is commented or liked the author is notified by email.
** Infinite scroll gallery
* Editing features:
** Create custom images using webcam or images downloaded from computer combined with filters

## Tech stack
PHP
HTML
CSS
JavaScript
AJAX

## Website wireframe
![Gallery draft](../assets/Gallery.png?raw=true)
![Profile draft](../assets/Profile.png?raw=true)
![Photo draft](../assets/Photo.png?raw=true)

## Database structure
![Database planning](../assets/db.png?raw=true)


## Run locally
Make sure you can send emails from terminal
Install mamp 
Run this command git clone ….
Go to .... and update database settings
Launch ... setup.php to create database
Open http://localhost:8080/ in your prefered browser
