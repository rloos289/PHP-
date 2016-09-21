<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";
    require_once "src/Review.php";


    $server = 'mysql:host=localhost;dbname=best_restaurants_test';
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
            Cuisine::deleteAll();
            Restaurant::deleteAll();
            Review::deleteAll();
        }

        function test_save()
        {
            $restaurant = "Olive Garden";
            $description = "Serves food";
            $test_restaurant = new Restaurant($restaurant, $description, 1);
            $test_restaurant->save();

            $result = Restaurant::getAll();

            $this->assertEquals($test_restaurant, $result[0]);
        }

        function test_get_all()
        {
            $restaurant1 = "Olive Garden";
            $description1 = "Serves food";
            $restaurant2 = "Thai Orchid";
            $description2 = "Serves food";
            $test_restaurant1 = new Restaurant($restaurant1, $description1, 1);
            $test_restaurant1->save();
            $test_restaurant2 = new Restaurant($restaurant2, $description2, 2);
            $test_restaurant2->save();

            $result = Restaurant::getAll();

            $this->assertEquals([$test_restaurant1, $test_restaurant2], $result);
        }

        function test_deleteAll()
        {
            $restaurant1 = "Olive Garden";
            $description1 = "Serves food";
            $restaurant2 = "Thai Orchid";
            $description2 = "Serves food";
            $test_restaurant1 = new Restaurant($restaurant1, $description1, 1);
            $test_restaurant1->save();
            $test_restaurant2 = new Restaurant($restaurant2, $description2, 2);
            $test_restaurant2->save();

            Restaurant::deleteAll();
            $result = Restaurant::getAll();

            $this->assertEquals([], $result);
        }

        function test_update()
        {
            $restaurant = "Olive Garden";
            $description = "Serves food";
            $test_restaurant = new Restaurant($restaurant, $description, 1);
            $test_restaurant->save();
            $test_restaurant->update("Thai Orchid");

            $result = $test_restaurant->getName();

            $this->assertEquals("Thai Orchid", $result);
        }

        function test_delete()
        {
            $restaurant = "Olive Garden";
            $description = "Serves food";
            $test_restaurant = new Restaurant($restaurant, $description, 1);
            $test_restaurant->save();
            $id = $test_restaurant->getId();
            $test_restaurant->delete();

            $result = Restaurant::find($id);

            $this->assertEquals(null, $result);
        }

        function test_find()
        {
            $restaurant1 = "Olive Garden";
            $description1 = "Serves food";
            $restaurant2 = "Thai Orchid";
            $description2 = "Serves food";
            $test_restaurant1 = new Restaurant($restaurant1, $description1, 1);
            $test_restaurant1->save();
            $test_restaurant2 = new Restaurant($restaurant2, $description2, 2);
            $test_restaurant2->save();

            $result = Restaurant::find($test_restaurant1->getId());

            $this->assertEquals($test_restaurant1, $result);
        }

        function test_reviewSearch()
        {
            $restaurant = "Olive Garden";
            $description = "Serves food";
            $test_restaurant = new Restaurant($restaurant, $description, 1);
            $test_restaurant->save();
            $text_review1 = "It were gud";
            $score_review1 = 3;
            $test_review1 = new Review($text_review1, $score_review1, $test_restaurant->getId());
            $test_review1->save();
            $text_review2 = "It were bad";
            $score_review2 = 1;
            $test_review2 = new Review($text_review2, $score_review2, $test_restaurant->getId());
            $test_review2->save();

            $result = $test_restaurant->reviewSearch();

            $this->assertEquals([$test_review1, $test_review2], $result);
        }

        function test_review_score_average()
        {
            $restaurant = "Olive Garden";
            $description = "Serves food";
            $test_restaurant = new Restaurant($restaurant, $description, 1);
            $test_restaurant->save();
            $text_review1 = "It were gud";
            $score_review1 = 3;
            $test_review1 = new Review($text_review1, $score_review1, $test_restaurant->getId());
            $test_review1->save();
            $text_review2 = "It were bad";
            $score_review2 = 1;
            $test_review2 = new Review($text_review2, $score_review2, $test_restaurant->getId());
            $test_review2->save();
            $text_review3 = "I like";
            $score_review3 = 5;
            $test_review3 = new Review($text_review3, $score_review3, $test_restaurant->getId());
            $test_review3->save();

            $result = $test_restaurant->scoreAverage();

            $this->assertEquals(3, $result);
        }
    }
?>
