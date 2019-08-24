<?php
    class Category {
    
        // database connection and table name
        private $conn;
        private $table_name = "categories";

        // object properties
        public $id;
        public $name;
        public $description;
        public $created;
    
        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        // read category
        public function read() {

            //select all data
            $query = "SELECT
                        id, name, description
                    FROM
                        " . $this->table_name . "
                    ORDER BY
                        name";
        
            $stmt = $this->conn->prepare( $query );
            $stmt->execute();
        
            return $stmt;
        }

        // create category
        public function create() {
 
            // query to insert record
            $query = "INSERT INTO
                        " . $this->table_name . "
                    SET
                        name = :name, description = :description, created = :created";
          
            // prepare query
            $stmt = $this->conn->prepare($query);
        
            // sanitize
            $this->name         =  htmlspecialchars(strip_tags($this->name));
            $this->description  =  htmlspecialchars(strip_tags($this->description));
            $this->created      =  htmlspecialchars(strip_tags($this->created));
        
            // bind values
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":created", $this->created);
        
            // execute query
            if($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n ", $stmt->error);
        
            return false;
            
        }

        // read one category
        public function readOne() {
        
            // query to read single record
            $query = "SELECT
                        id, name, description
                    FROM
                        " . $this->table_name . "
                    WHERE
                        id = ?";
        
            // prepare query statement
            $stmt = $this->conn->prepare($query);
        
            // bind id of category to be updated
            $stmt->bindParam(1, $this->id);
        
            // execute query
            $stmt->execute();
        
            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // set values to object properties
            $this->name = $row['name'];
            $this->description = $row['description'];
        }

        // update the category
        public function update() {
 
            // update query
            $query = "UPDATE
                        " . $this->table_name . "
                    SET
                        name = :name,
                        description = :description
                    WHERE
                        id = :id"; 
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
         
            // sanitize
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->id = htmlspecialchars(strip_tags($this->id));
         
            // bind new values
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':id', $this->id);
         
            // execute the query
            if ($stmt->execute()) {
                return true;
            }
            
            return false;

            // Print error if something goes wrong
            printf("Error: %s.\n ", $stmt->error);
        }

        // delete the category
        public function delete() {
 
            // delete query
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
         
            // prepare query
            $stmt = $this->conn->prepare($query);
         
            // sanitize
            $this->id = htmlspecialchars(strip_tags($this->id));
         
            // bind id of record to delete
            $stmt->bindParam(1, $this->id);
         
            // execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n ", $stmt->error);
            
            return false;
        }

         /**
         * Returns an array containing $keywords serached
         * @param    $keywords  searched keyword
         * @property $stmt      variable, prepares query , bind params, execute and returned
         * @return   $stmt
         */
        public function search($keywords) {

        }

        // read category with pagination
        public function readPaging() {

        }

        // used for paging category
        public function count() {
            
        }

    }
?>