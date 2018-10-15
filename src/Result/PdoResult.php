<?php

namespace Rougin\Windstorm\Result;

use PDO;

class PdoResult implements ResultInterface
{
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function execute($sql, array $parameters, array $types)
    {
        $stmt = $this->pdo->prepare((string) $sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
