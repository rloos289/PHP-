<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Restaurant.php";
    require_once "src/Review.php";

    $server = 'mysql:host=localhost;dbname=best_restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ReviewTest extends PHPUnit_Framework_TestCase

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
            $text_review = "It were gud";
            $score_review = 3;
            $test_review = new Review($text_review, $score_review, 1);
            $test_review->save();

            $result = Review::getAll();

            $this->assertEquals($test_review, $result[0]);
        }

        function test_get_all()
        {
            $text_review1 = "It were gud";
            $score_review1 = 3;
            $test_review1 = new Review($text_review1, $score_review1, 1);
            $test_review1->save();
            $text_review2 = "It were bad";
            $score_review2 = 1;
            $test_review2 = new Review($text_review2, $score_review2, 2);
            $test_review2->save();

            $result = Review::getAll();

            $this->assertEquals([$test_review1, $test_review2], $result);
        }

        function test_delete_all()
        {
            $text_review1 = "It were gud";
            $score_review1 = 3;
            $test_review1 = new Review($text_review1, $score_review1, 1);
            $test_review1->save();
            $text_review2 = "It were bad";
            $score_review2 = 1;
            $test_review2 = new Review($text_review2, $score_review2, 2);
            $test_review2->save();

            Review::deleteAll();
            $result = Review::getAll();

            $this->assertEquals([], $result);
        }
    }
