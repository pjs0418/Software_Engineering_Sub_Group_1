<?php

//DB 정보
function pdoSqlConnect()
{
    try {
        $DB_HOST = "sg1db.cufepyonzqt5.ap-northeast-2.rds.amazonaws.com";
        $DB_NAME = "SG1";
        $DB_USER = "admin";
        $DB_PW = "akrmsk15984";
        $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PW);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}