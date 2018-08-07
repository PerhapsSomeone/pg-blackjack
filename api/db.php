<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 06.08.18
 * Time: 16:51
 */

class DB {
    public static function getPDOConn() {
        $host = '127.0.0.1';
        $db   = 'blackjack';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $opt);
        return $pdo;
    }

    public static function checkMatchExists($uuid) {
        $pdo = self::getPDOConn();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `matches` WHERE uuid = ?");
        $stmt->execute(array($uuid));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row["COUNT(*)"] === 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function initalInsert($uuid, $cardJSON) {
        $pdo = self::getPDOConn();

        try {
            $stmt = $pdo->prepare("INSERT INTO `matches` (`uuid`, `cards`) VALUES (?, ?)");
            $stmt->execute(array($uuid, $cardJSON));
        } catch (Exception $exception) {
            return false;
        }
        return true;
    }

    public static function updateCards($uuid, $cardJSON) {
        $pdo = self::getPDOConn();

        try {
            $stmt = $pdo->prepare("UPDATE `matches` SET `cards` = ? WHERE `matches`.`uuid` = ?");
            $stmt->execute(array($cardJSON, $uuid));
        } catch (Exception $exception) {
            return false;
        }
        return true;
    }

    public static function getCards($uuid) {
        $pdo = self::getPDOConn();

        $stmt = $pdo->prepare("SELECT cards FROM matches WHERE uuid = ?");
        $stmt->execute(array($uuid));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return json_decode($row["cards"], true);
    }

    public static function endMatch($uuid) {
        $pdo = self::getPDOConn();

        try {
            $stmt = $pdo->prepare("UPDATE `matches` SET `done` = ? WHERE `matches`.`uuid` = ?");
            $stmt->execute(array("true", $uuid));
        } catch (Exception $exception) {
            return false;
        }
        return true;
    }
}
