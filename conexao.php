<?php
function getConnection() {
    $host = 'srv-pjesupbd01.tjm.net';
    $port = '5432';
    $db = 'pje_descanso';
    $user = 'postgres';
    $pass = 'vB2Tqc39';
    
    try {
        $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
        $pdo->exec("SET NAMES 'UTF8'"); // Força UTF-8
        return $pdo;
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco: " . $e->getMessage());
    }
}
