<?php
class Database
{
    private $connection;

    public function __construct()
    {
        $servername = "localhost";
        $dbName = "presentation_invite_creator";
        $username = "root";
        $password = "";

        $this->connection = new PDO("mysql:host=$dbhost;dbname=$dbName", $username, $password);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function close() {
        $this->connection = null;
    }
}
?>
