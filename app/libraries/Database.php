<?php
    /*
    *PDO Database Class
    * Connect to database
    * Create prepared statements
    * Bind Values
    * Return rows and results
    */
    class Database {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;
        // database handler
        private $dbh;
        private $stmt;
        private $error;

        public function __construct(){
            // Set DSN
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            //$dsn = mysql:host=localhost;dbname=testmvc;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            // Create PDO instance 
            try{
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            } catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        // 1. Prepare statement with query
        public function query($sql){
            $this->stmt = $this->dbh->prepare($sql);
        }

        // 2. Bind Values
        public function bind($param, $value, $type = null){
            if(is_null($type)){
                switch(true){
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }

            $this->stmt->bindValue($param, $value, $type);
        }

        // 3. Execute the prepared statement above
        public function execute(){
            return $this->stmt->execute();
        }

        // 4. Couple Methods to get the results
        // 4a. Get result set as an array of objects
        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        // 4b. Get result a single row/record as object
        public function single(){
            $this->execute();
            return $this->stmt->fetch(FETCH_OBJ);
        }

        // 5. Get Row Count
        public function rowCount(){
            return $this->stmt->rowCount();
        }
    }


?>