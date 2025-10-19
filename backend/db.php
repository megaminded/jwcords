<?php
final class DBConnection
{
    private $host = "localhost";
    private $db = 'jw';
    private $user = 'root';
    private $password = 'protected';

    function __construct()
    {
        $this->connect();
    }
    protected $connection;

    private function connect()
    {
        $connection = new mysqli($this->host, $this->user, $this->password, $this->db);
        if ($connection) {
            $this->connection = $connection;
            return $this->connection;
        } else {
            die("Unable to connect to database");
        }
    }

    public function save($data)
    {
        $congregation = mysqli_escape_string($this->connection, $data['congregation'] ?? null);
        $name = mysqli_escape_string($this->connection, $data['name'] ?? null);
        $phone = mysqli_escape_string($this->connection, $data['phone'] ?? null);
        $publishers = mysqli_escape_string($this->connection, $data['publishers'] ?? null);
        $longitude = mysqli_escape_string($this->connection, $data['longitude'] ?? null);
        $latitude = mysqli_escape_string($this->connection, $data['latitude'] ?? null);
        $time = date('Y-m-d h:i:s');
        $statement = "INSERT INTO coordinates (congregation, name, phone, publishers, longitude, latitude, create_time)";
        $statement .= "VALUES ('$congregation', '$name', '$phone', '$publishers', '$longitude', '$latitude', '$time')";

        $result = $this->connect()->query($statement);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function congregation($congregation)
    {
        $statement = "SELECT * FROM coordinates WHERE congregation = '$congregation'";
        $result = $this->connect()->query($statement);
        return $result;
    }
}
