<?php
    declare(strict_types=1);
    class database {
        private PDO $connection;
        private PDOStatement $statement;

        public function __construct(
            string $host = "127.0.0.1",
            int $port = 3306,
            string $user = "root",
            string $pass = "",
            string $name = "myphpfw"
        ) {
            $this->connection = new PDO("mysql:dbname=".$name.";host=".$host.":".$port, $user, $pass);
        }

        public function prepare(string $query):void {
            if(!$this->statement = $this->connection->prepare($query)) {
                die("Prepare failed: ".$this->statement->errorInfo()[2]);
            }
        }

        public function bind_and_execute(array $parameters = []) {
            foreach($parameters as $key => $val) {
                if ($this->statement->bindValue($key, $val) === FALSE) {
                    die("Binding parameters failed: ".$this->statement->errorInfo()[2]);
                }
            }
            if($this->statement->execute() === FALSE) {
                die("Execute failed: ".$this->statement->errorInfo()[2]);
            }
        }

        public function fetch_assoc():array {
            return $this->statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
