<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";

    $server = 'mysql:host=localhost;dbname=best_restaurants';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase

    //run test in terminal: ./vendor/bin/phpunit tests

    //on Mac: run: export PATH=$PATH:./vendor/bin
    //then run phpunit tests
    {
        protected function teardown()
        {
            Cuisine::deleteAll();
        }

        function test_save()
        {
            $cuisine = "Italian";
            $test_cuisine = new Cuisine($cuisine);
            $test_cuisine->save();

            $result = Cuisine::getAll();

            $this->assertEquals($test_cuisine, $result[0]);
        }

        function test_get_all()
        {
            $cuisine1 = "Italian";
            $cuisine2 = "Thai";
            $test_cuisine1 = new Cuisine($cuisine1);
            $test_cuisine1->save();
            $test_cuisine2 = new Cuisine($cuisine2);
            $test_cuisine2->save();

            $result = Cuisine::getAll();

            $this->assertEquals([$test_cuisine1, $test_cuisine2], $result);
        }

        function test_deleteAll()
        {
            $cuisine1 = "Italian";
            $cuisine2 = "Thai";
            $test_cuisine1 = new Cuisine($cuisine1);
            $test_cuisine1->save();
            $test_cuisine2 = new Cuisine($cuisine2);
            $test_cuisine2->save();

            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            $this->assertEquals([], $result);
        }

        function test_update()
        {
            $cuisine = "Italian";
            $test_cuisine = new Cuisine($cuisine);
            $test_cuisine->save();
            $test_cuisine->update("Thai");

            $result = $test_cuisine->getCuisineType();

            $this->assertEquals("Thai", $result);
        }

        function test_delete()
        {
            $cuisine = "Italian";
            $test_cuisine = new Cuisine($cuisine);
            $test_cuisine->save();
            $id = $test_cuisine->getId();
            $test_cuisine->delete();

            $result = Cuisine::find($id);

            $this->assertEquals(null, $result);
        }

        function test_find()
        {
            $cuisine1 = "Italian";
            $cuisine2 = "Thai";
            $test_cuisine1 = new Cuisine($cuisine1);
            $test_cuisine1->save();
            $test_cuisine2 = new Cuisine($cuisine2);
            $test_cuisine2->save();

            $result = Cuisine::find($test_cuisine1->getId());

            $this->assertEquals($test_cuisine1, $result);
        }
    }
      // Testcode example
      //  function test_makeTitleCase_oneWord()
      //  {
      //      //Arrange
      //      $test_TitleCaseGenerator = new Template;
      //      $input = "beowulf";
       //
      //      //Act
      //      $result = $test_TitleCaseGenerator->testTemplate($input);
       //
      //      //Assert
      //      $this->assertEquals("Beowulf", $result);
      //  }

        //TEST FOR LOOPING THROUGH MULTIPLE INPUTS
    //   function test_numword_ones()
    // {
    //     $test_NumWord_Ones = new Numword;
    //     $input_array = ['0','1', '2', '3', '4', '5', '6', '7', '8', '9'];
    //     $expected_results = ['','One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
    //     $result_array = array();
    //
    //     foreach ($input_array as $input)
    //     {
    //       array_push($result_array, $test_NumWord_Ones->process_thru_nineteen($input));
    //     }
    //     $this->assertEquals($expected_results, $result_array);
    // }

 ?>
