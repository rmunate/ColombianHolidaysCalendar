<?php

namespace Rmunate\Calendar\Database;

class DatabaseManager
{
    private $name_db = 'Holidays.db';
    public $nameTable = 'holidays';
    private $connection;
    public $path_db;

    /**
     * Definimos la ruta donde se va a alojar la data del calendario.
     */
    public function __construct()
    {
        $this->path_db = dirname(__FILE__).'\\SQLite\\'.$this->name_db;
        $this->connect();
    }

    /**
     * Este método genera la conexión a la base de datos de SQLite3.
     *
     * @throws \Exception
     *
     * @return \SQLite3
     */
    private function connect()
    {
        if (empty($this->connection)) {
            try {
                $this->connection = new \SQLite3($this->path_db);
            } catch (\Exception $e) {
                throw new \Exception('Error al conectar a la base de datos del paquete: '.$e->getMessage());
            }
        }

        return $this->connection;
    }

    /**
     * Crea el esquema de la tabla de días festivos.
     */
    public function createSchema()
    {
        $this->connection->exec('DROP TABLE IF EXISTS '.$this->nameTable);

        $ddlTable = '
        CREATE TABLE IF NOT EXISTS '.$this->nameTable." (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            country TEXT NOT NULL DEFAULT 'Colombia',
            year INTEGER NOT NULL,
            month INTEGER NOT NULL,
            day INTEGER NOT NULL,
            full_date TEXT NOT NULL,
            day_of_year INTEGER NOT NULL,
            iso_week INTEGER NOT NULL,
            iso_day INTEGER NOT NULL,
            holiday_reason TEXT NOT NULL,
            day_name TEXT NOT NULL,
            month_name TEXT NOT NULL
        )";

        $this->connection->exec($ddlTable);
    }

    /**
     * Ejecuta el seeder para insertar datos en la tabla de días festivos.
     */
    public function executeSeeder()
    {
        $dataDir = dirname(__FILE__).DIRECTORY_SEPARATOR.'Seeders';
        $startYear = 2000;
        $endYear = 2100;

        for ($year = $startYear; $year <= $endYear; $year++) {
            $filePath = $dataDir.DIRECTORY_SEPARATOR."CO_{$year}.php";

            if (!file_exists($filePath)) {
                break;
            }

            $data = include $filePath;

            foreach ($data as $value) {
                $this->insertHoliday($value);
            }
        }
    }

    /**
     * Inserta un día festivo en la base de datos.
     *
     * @param array $value
     */
    private function insertHoliday(array $value)
    {
        $insertQuery = '
            INSERT INTO '.$this->nameTable." (
                country,
                year,
                month,
                day,
                full_date,
                day_of_year,
                iso_week,
                iso_day,
                holiday_reason,
                day_name,
                month_name
            ) VALUES (
                'Colombia',
                :year,
                :month,
                :day,
                :full_date,
                :day_of_year,
                :iso_week,
                :iso_day,
                :holiday_reason,
                :day_name,
                :month_name
            )
        ";

        $stmt = $this->connection->prepare($insertQuery);
        $this->bindValues($stmt, $value);
        $stmt->execute();
    }

    /**
     * Ejecuta una consulta con parámetros.
     *
     * @param string $query
     * @param array  $params
     *
     * @return array|null
     */
    public function execute(string $query, array $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            if ($stmt === false) {
                throw new \Exception("Error al preparar la consulta: {$this->connection->lastErrorMsg()}");
            }

            foreach ($params as $key => $value) {
                $paramType = $this->getParamType($value);
                $stmt->bindValue(":{$key}", $value, $paramType);
            }

            $result = $stmt->execute();
            if ($result === false) {
                throw new \Exception("Error al ejecutar la consulta: {$this->connection->lastErrorMsg()}");
            }

            $data = [];
            if (preg_match('/^\s*SELECT/i', $query)) {
                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $data[] = $row;
                }
            }

            $stmt->close();

            return $data;
        } catch (\Exception $e) {
            throw new \Exception('Error: '.$e->getMessage());
        }
    }

    /**
     * Determina el tipo de parámetro SQLite.
     *
     * @param mixed $value
     *
     * @return int
     */
    private function getParamType($value)
    {
        switch (gettype($value)) {
            case 'integer':
                return SQLITE3_INTEGER;
            case 'double':
                return SQLITE3_FLOAT;
            case 'boolean':
                return SQLITE3_INTEGER;
            case 'NULL':
                return SQLITE3_NULL;
            default:
                return SQLITE3_TEXT;
        }
    }

    /**
     * Vincula valores a una declaración preparada.
     *
     * @param \SQLite3Stmt $stmt
     * @param array        $values
     */
    private function bindValues(\SQLite3Stmt $stmt, array $values)
    {
        foreach ($values as $key => $value) {
            $paramType = $this->getParamType($value);
            $stmt->bindValue(":{$key}", $value, $paramType);
        }
    }
}
