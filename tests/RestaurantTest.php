<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";


    $server = 'mysql:host=localhost;dbname=best_restaurants';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase

    //run test in terminal: ./vendor/bin/phpunit tests

    //on Mac: run: export PATH=$PATH:./vendor/bin
    //then run phpunit tests
    {
        protected function teardown()
        {
            Restaurant::deleteAll();
            Cuisine::deleteAll();
        }

        function test_save()
        {
            $restaurant = "Olive Garden";
            $test_restaurant = new Restaurant($restaurant, 1);
            $test_restaurant->save();

            $result = Restaurant::getAll();

            $this->assertEquals($test_restaurant, $result[0]);
        }

        function test_get_all()
        {
            $restaurant1 = "Olive Garden";
            $restaurant2 = "Thai Orchid";
            $test_restaurant1 = new Restaurant($restaurant1, 1);
            $test_restaurant1->save();
            $test_restaurant2 = new Restaurant($restaurant2, 2);
            $test_restaurant2->save();

            $result = Restaurant::getAll();

            $this->assertEquals([$test_restaurant1, $test_restaurant2], $result);
        }

        function test_deleteAll()
        {
            $restaurant1 = "Olive Garden";
            $restaurant2 = "Thai Orchid";
            $test_restaurant1 = new Restaurant($restaurant1, 1);
            $test_restaurant1->save();
            $test_restaurant2 = new Restaurant($restaurant2, 2);
            $test_restaurant2->save();

            Restaurant::deleteAll();
            $result = Restaurant::getAll();

            $this->assertEquals([], $result);
        }

        function test_update()
        {
            $restaurant = "Olive Garden";
            $test_restaurant = new Restaurant($restaurant, 1);
            $test_restaurant->save();
            $test_restaurant->update("Thai Orchid");

            $result = $test_restaurant->getName();

            $this->assertEquals("Thai Orchid", $result);
        }

        function test_delete()
        {
            $restaurant = "Olive Garden";
            $test_restaurant = new Restaurant($restaurant, 1);
            $test_restaurant->save();
            $id = $test_restaurant->getId();
            $test_restaurant->delete();

            $result = Restaurant::find($id);

            $this->assertEquals(null, $result);
        }

        function test_find()
        {
            $restaurant1 = "Olive Garden";
            $restaurant2 = "Thai Orchid";
            $test_restaurant1 = new Restaurant($restaurant1, 1);
            $test_restaurant1->save();
            $test_restaurant2 = new Restaurant($restaurant2, 2);
            $test_restaurant2->save();

            $result = Restaurant::find($test_restaurant1->getId());

            $this->assertEquals($test_restaurant1, $result);
        }
    }
?>
