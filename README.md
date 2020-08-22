# CAMAGRU - Photo Editing App
This project is a part of the web branch at [Hive Helsinki](https://www.hive.fi/) coding school. 

## Task
The aim of this project is to build an Instagram-like web app, that allows to make basic photo editing using webcam and predefied images.Users are able to select and a frame, take a picture with webcam and admire the result of mixing both pictures.

The app requirements:
- MVC structure
- Responsive design
- Website security (no SQL, HTML injections, plain passwords in the dataases)
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
	* Register / Login, including activating account and reseting password through a unique link send by email.
	* User data management: modify user data (username, email, etc), change password, set notification preferences.
	* View own own gallery and gallery of all users you follow.
	* Set created images as profile and delete own images
	* View other users profiles
* Gallery features:
	* Infinite scroll gallery.
	* All images are public, likeable, commentable and followable by logged in users.
	* Image modal box with image details.
	* Once image is commented the author is notified by email.
	* Set created images as profile and delete own images
* Editing features:
<details>
  <summary>Click to expand!</summary>
	* Create custom images using webcam or images downloaded from computer and combine them with filters.
	* Live preview of the edited result, directly on the webcam preview.
	* Preview displaying thumbnails of all previously taken images with ability to save or delete them.
	* Once saved image is visible in public gallery
</details>

## Tech stack
* PHP
* HTML
* CSS
* JavaScript
* AJAX
* Bootstrap

## Website wireframe
<details>
<summary>click to view</summary>
![Gallery draft](../assets/Gallery.png?raw=true)
![Profile draft](../assets/Profile.png?raw=true)
![Photo draft](../assets/Photo.png?raw=true)
</details>

## Database structure
![Database planning](../assets/db.png?raw=true)


## Run locally

* Set a local webserver, e.g. install [mamp](https://bitnami.com/stack/mamp)
* Make sure you can send email from terminal. Here is a good link to configer POSTFIX if you have [macOS Catalina](https://gist.github.com/loziju/66d3f024e102704ff5222e54a4bfd50e)


* Git clone repo
* In app/config/database.php update database user name, password and database to match your environemnt

* Launch app/config/setup.php to create database
* Open http://localhost/folder_name in your prefered browser
