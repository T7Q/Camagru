CREATE TABLE `user`
(
 `id_user`                 int NOT NULL AUTO_INCREMENT ,
 `username`                varchar(255) NOT NULL ,
 `password`                varchar(255) NOT NULL ,
 `active`                  tinyint NULL DEFAULT 0 ,
 `first_name`              varchar(255) NULL ,
 `last_name`               varchar(255) NULL ,
 `email`                   varchar(255) NOT NULL ,
 `notification_preference` tinyint NULL DEFAULT 1 ,
 `profile_pic_path`        varchar(255) NULL ,
 `created_at`              datetime NULL DEFAULT CURRENT_TIMESTAMP ,

PRIMARY KEY (`id_user`)
);


INSERT INTO `user` (`username`, `password`, `email`) VALUES ('tanya', 123456, `email`);

