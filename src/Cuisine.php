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

        function update($newType)
        {
            $GLOBALS['DB']->exec("UPDATE cuisine SET cuisine_type = '{$newType}' WHERE id = {$this->getID()};");
            $this->cuisine_type = $newType;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisine WHERE id = {$this->getID()};");
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

        static function find($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach($cuisines as $cuisine) {
                $cuisine_id = $cuisine->getId();
                if ($cuisine_id == $search_id) {
                  $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }
        function restaurantSearch()
        {
            $restaurantArray = array();
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant WHERE cuisine_id = {$this->getId()};");
            foreach ($returned_restaurants as $restaurant) {
                $restaurant_name = $restaurant['name'];
                $cuisine_id = $restaurant['cuisine_id'];
                $id = $restaurant['id'];
                $description = $restaurant['description'];
                $new_restaurant = new Restaurant ($restaurant_name, $description, $cuisine_id, $id);
                array_push($restaurantArray, $new_restaurant);
            }
        return $restaurantArray;
        }
    }
?>
