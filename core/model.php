<?php

abstract class Model
{

    protected PDO $pdo;

    public function __construct()
    {
        require_once "app/config.php";
        extract($config);
        $hostPDO = new PDO(
            "mysql:host=$host",
            $username,
            $password
        );
        $hostPDO->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
        $this->pdo = new PDO(
            "mysql:host=$host;dbname=$dbname",
            $username,
            $password
        );
        $this->createTables();
    }

    public function createTables(): void
    {
        $statements = [
            "
            CREATE TABLE IF NOT EXISTS `user`(
                id INT NOT NULL AUTO_INCREMENT,
                username VARCHAR(32) NOT NULL,
                salt VARCHAR(255) NOT NULL,
                pwd_hash VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id),
                UNIQUE(username)
            );
            ",
            "
            CREATE TABLE IF NOT EXISTS `car`(
                id INT NOT NULL AUTO_INCREMENT,
                title VARCHAR(255) NOT NULL,
                brand VARCHAR(32) NOT NULL,
                scale VARCHAR(10) NOT NULL,
                category VARCHAR(32) NOT NULL,
                car_brand VARCHAR(32) NOT NULL,
                year INT NOT NULL,
                country VARCHAR(32) NOT NULL,
                price INT NOT NULL,
                PRIMARY KEY(id)
            );
            ",
            "
            CREATE TABLE IF NOT EXISTS `cart`(
                id INT NOT NULL AUTO_INCREMENT,
                user_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL,
                PRIMARY KEY(id),
                FOREIGN KEY(user_id) REFERENCES user(id),
                FOREIGN KEY(product_id) REFERENCES car(id),
                UNIQUE(user_id, product_id)
            );
            ",
            "
            CREATE TABLE IF NOT EXISTS `order`(
                id INT NOT NULL AUTO_INCREMENT,
                order_id INT NOT NULL,
                user_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL,
                PRIMARY KEY(id),
                FOREIGN KEY(user_id) REFERENCES user(id),
                FOREIGN KEY(product_id) REFERENCES car(id)
            );
            "
        ];
        foreach ($statements as $statement) {
            $this->pdo->exec($statement);
        }
    }
}