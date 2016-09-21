<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";

    $server = 'mysql:host=localhost;dbname=best_restaurants';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();

    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

  //loads actual twig file
    $app->get("/", function() use ($app) {
      return $app['twig']->render("home.html.twig", array('restaurants' => Restaurant::getAll()));
    });

    $app->post("/restaurants", function() use($app) {
        $name = $_POST['restaurant_name'];
        $description = $_POST['restaurant_description'];
        $inputCuisine = strtolower($_POST['restaurant_cuisine']);
        $cuisines = Cuisine::getAll();
        $cuisine_id = null;
        foreach ($cuisines as $cuisine) {
            if ($cuisine->getCuisineType() == $inputCuisine) {
                $cuisine_id = $cuisine->getId();
            }
        }
        if ($cuisine_id == null) {
            $newCuisine = new Cuisine($inputCuisine);
            $newCuisine->save();
            $cuisine_id = $newCuisine->getId();
        }

        $newRestaurant = new Restaurant($name, $description, $cuisine_id);
        $newRestaurant->save();

        return $app['twig']->render("restaurants.html.twig", array('restaurants' => Restaurant::getAll(), 'cuisines' => Cuisine::getAll()));
    });

    $app->get("/restaurant/{id}", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        return $app['twig']->render("restaurant.html.twig", array('restaurant' => $restaurant, 'cuisine' =>$cuisine));
    });

  //loads basic php
    $app->get("/test", function() use ($app) {
      return 'test variables here';
    });

    return $app;
?>
