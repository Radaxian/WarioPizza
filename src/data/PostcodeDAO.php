<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../../config/Config.php';
require_once __DIR__ . '/../entities/Postcode.php';

class PostcodeDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host='.Config::$DBHOST.';dbname='.Config::$DBNAME.';charset=utf8', Config::$DBUSER, Config::$DBPWD);
    }

    public function findAll() : array
    {
        $sql = 'select * from Postcode';

        $postcodes = [];

        foreach ($this->pdo->query($sql) as $row) {
            list($id, $postcode, $area) = $row;
            $postcode = new Postcode((int) $id, $postcode, $area);
            $postcodes[] = $postcode;
        }

        return $postcodes;
    }

    public function findPostcode(int $postcodeId) : Postcode
    {
        $sql = 'select * from Postcode where postcodeId = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $postcodeId);
        $stmt->execute();

        list($id, $postcode, $area) = $stmt->fetch();
        $postcode = new Postcode((int) $id, $postcode, $area);
        return $postcode;
    }


}