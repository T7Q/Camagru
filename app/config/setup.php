<?php
    require_once('database.php');

    try{
        $db_name = DB_NAME;

        $conn = new PDO('mysql:host='. DB_HOST, DB_USER, DB_PASS); 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "CREATE DATABASE $db_name";
        $conn->exec($sql);
        echo "Database created successfully<br>";

        $sql = "USE $db_name";
        $conn->exec($sql);

        $sql = "CREATE TABLE `user`(
            `id_user`                 int AUTO_INCREMENT PRIMARY KEY,
            `username`                varchar(255) NOT NULL ,
            `password`                varchar(1000) NOT NULL ,
            `active`                  tinyint DEFAULT 0 ,
            `first_name`              varchar(255) NULL ,
            `last_name`               varchar(255) NULL ,
            `email`                   varchar(255) NOT NULL ,
            `notification_preference` tinyint DEFAULT 1 ,
            `profile_pic_path`        varchar(255) NULL ,
            `created_at`              datetime DEFAULT CURRENT_TIMESTAMP,
            `token`                   varchar(255) NULL
            ) ENGINE=InnoDB";
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "All tables (user, ";

        // create user table
        $sql = "CREATE TABLE `filter`(
           `id_filter` int AUTO_INCREMENT PRIMARY KEY ,
            `name`      varchar(45) NOT NULL ,
            `path`      varchar(45) NOT NULL
        ) ENGINE=InnoDB";
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "filter, ";

        $sql = "CREATE TABLE `gallery` (
            `id_image`   int AUTO_INCREMENT PRIMARY KEY,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP ,
            `path`       varchar(45) NOT NULL ,
            `title`      varchar(45) NOT NULL ,
            `id_user`    int NOT NULL ,

            KEY `fkIdx_201` (`id_user`),
            CONSTRAINT `FK_201` FOREIGN KEY `fkIdx_201` (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
        ) ENGINE=InnoDB";
        $conn->exec($sql);
        echo "gallery, ";

        $sql = "CREATE TABLE `comment`(
            `id_comment` int AUTO_INCREMENT PRIMARY KEY,
            `comment`    varchar(150) NOT NULL ,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP ,
            `id_user`    int NOT NULL ,
            `id_image`   int NOT NULL ,

            KEY `fkIdx_204` (`id_user`),
            CONSTRAINT `FK_204` FOREIGN KEY `fkIdx_204` (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
            KEY `fkIdx_216` (`id_image`),
            CONSTRAINT `FK_216` FOREIGN KEY `fkIdx_216` (`id_image`) REFERENCES `gallery` (`id_image`) ON DELETE CASCADE
        ) ENGINE=InnoDB";
        $conn->exec($sql);
        echo "comment, ";

        $sql = "CREATE TABLE `like`(
            `id_like`     int AUTO_INCREMENT PRIMARY KEY ,
            `created_at`  datetime DEFAULT CURRENT_TIMESTAMP ,
            `id_user`     int NOT NULL ,
            `id_image`    int NOT NULL ,

            KEY `fkIdx_207` (`id_user`),
            CONSTRAINT `FK_207` FOREIGN KEY `fkIdx_207` (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
            KEY `fkIdx_213` (`id_image`),
            CONSTRAINT `FK_213` FOREIGN KEY `fkIdx_213` (`id_image`) REFERENCES `gallery` (`id_image`) ON DELETE CASCADE
        ) ENGINE=InnoDB";
        $conn->exec($sql);
        echo "like, ";

        $sql = "CREATE TABLE `follow`(
            `id_follow`    int AUTO_INCREMENT PRIMARY KEY ,
            `created_at`   datetime DEFAULT CURRENT_TIMESTAMP ,
            `follower_id`  int NOT NULL ,
            `following_id` int NOT NULL ,

            KEY `fkIdx_210` (`follower_id`),
            CONSTRAINT `FK_210` FOREIGN KEY `fkIdx_210` (`follower_id`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
        ) ENGINE=InnoDB";
        $conn->exec($sql);
        echo "follow) ";

        echo "are successfully created.";

        
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
    