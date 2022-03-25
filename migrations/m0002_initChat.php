<?php

use app\core\Application;

class m0002_initChat
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE messages (
                msg_id INT AUTO_INCREMENT PRIMARY KEY,
                incoming INT(11) NOT NULL,
                outgoing INT(11) NOT NULL,
                message VARCHAR(1024) NULL,
                saw TINYINT DEFAULT '0',
                img VARCHAR(1024) NULL,
                msg_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )  ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE users;";
        $db->pdo->exec($SQL);
    }
}