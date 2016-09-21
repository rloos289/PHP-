<?php
    class Restaurant
    {
        private $id;
        private $name;
        private $cuisine_id;
        private $description;

        function __construct($name, $description, $cuisine_id = null, $id = null)
        {
            $this->id = $id;
            $this->cuisine_id = $cuisine_id;
            $this->name = $name;
            $this->description = $description;
        }

        function setName()
        {
            $this->name = $name;
        }

        function setDescription()
        {
            $this->description = $description;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function getDescription()
        {
            return $this->description;
        }
//-------------functions--------------//
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurant (name, cuisine_id, description) VALUES ('{$this->getName()}', {$this->getCuisineId()}, '{$this->getDescription()}');");
            $this->id= $GLOBALS['DB']->lastInsertId();
        }

        function update($newName)
        {
            $GLOBALS['DB']->exec("UPDATE restaurant SET name = '{$newName}' WHERE id = {$this->getID()};");
            $this->name = $newName;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurant WHERE id = {$this->getID()};");
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurant;");
            $restaurantArray = array();
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

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurant;");
        }

        static function find($search_id)
        {
            $found_restaurant = null;
            $restaurants = Restaurant::getAll();
            foreach($restaurants as $restaurant) {
                $restaurant_id = $restaurant->getId();
                if ($restaurant_id == $search_id) {
                  $found_restaurant = $restaurant;
                }
            }
            return $found_restaurant;
        }
    }
?>
