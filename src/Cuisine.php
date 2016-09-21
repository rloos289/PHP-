<?php
    class Cuisine
    {
        private $id;
        private $cuisine_type;

        function __construct($cuisine_type, $id = null)
        {
            $this->id = $id;
            $this->cuisine_type = $cuisine_type;
        }

        function setCuisineType()
        {
            $this->cuisine_type = $cuisine_type;
        }

        function getCuisineType()
        {
            return $this->cuisine_type;
        }

        function getId()
        {
            return $this->id;
        }
//-------------functions--------------//
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisine (cuisine_type) VALUES ('{$this->getCuisineType()}')");
            $this->id= $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisine;");
            $cuisineArray = array();
            foreach ($returned_cuisines as $cuisine) {
                $cuisine_name = $cuisine['cuisine_type'];
                $id = $cuisine['id'];
                $new_cuisine = new Cuisine ($cuisine_name, $id);
                array_push($cuisineArray, $new_cuisine);
            }
            return $cuisineArray;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisine;");
        }
    }
?>
