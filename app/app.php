<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Restaurant.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Review.php";

    $server = 'mysql:host=localhost;dbname=best_restaurants';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();

    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

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

    $app->post("/clear", function() use ($app) {
        Restaurant::deleteAll();
        Cuisine::deleteAll();
        Review::deleteAll();
        return $app['twig']->render("home.html.twig", array('restaurants' => Restaurant::getAll(), 'cuisine' => Cuisine::getAll()));
    });

    $app->get("/restaurants", function() use($app) {
        return $app['twig']->render("restaurants.html.twig", array('restaurants' => Restaurant::getAll(), 'cuisines' => Cuisine::getAll()));
    });

    $app->get("/restaurants", function() use($app) {
        return $app['twig']->render("home.html.twig", array('restaurants' => Restaurant::getAll(), 'cuisines' => Cuisine::getAll()));
    });

    $app->delete("/restaurant/{id}", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $restaurant->delete();
        return $app['twig']->render("restaurants.html.twig", array('restaurants' => Restaurant::getAll(), 'cuisines' => Cuisine::getAll()));
    });

    $app->get("/restaurant/{id}", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        $restaurant = Restaurant::find($id);
        $allReviews = $restaurant->reviewSearch();
        return $app['twig']->render("restaurant.html.twig", array('restaurant' => $restaurant, 'cuisine' =>$cuisine, 'reviews' => $allReviews));
    });

    $app->patch("/restaurant/{id}", function($id) use ($app) {
        $restaurant = Restaurant::find($id);
        $newName = $_POST['name'];
        $restaurant->update($newName);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        $restaurant = Restaurant::find($id);
        $allReviews = $restaurant->reviewSearch();
        return $app['twig']->render("restaurant.html.twig", array('restaurant' => $restaurant, 'cuisine' =>$cuisine, 'reviews' => $allReviews));
    });

    $app->patch("/restaurantreview/{id}", function($id) use ($app) {
        $new_review_text = null;
        $new_review_score = null;
        $new_review_text = $_POST['review_input'];
        $new_review_score = $_POST['score_input'];
        $newReview = new Review ($new_review_text, $new_review_score, $id);
        $newReview->save();
        $restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        $allReviews = $restaurant->reviewSearch();
        return $app['twig']->render("restaurant.html.twig", array('restaurant' => $restaurant, 'cuisine' =>$cuisine, 'reviews' => $allReviews));
    });

    $app->get("/cuisine/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $restaurant_list = $cuisine->restaurantSearch();
        return $app['twig']->render("cuisine.html.twig", array('restaurants' => $restaurant_list, 'cuisine' => $cuisine));
    });

  //loads basic php
    $app->get("/test", function() use ($app) {
      return 'test variables here';
    });

    return $app;
?>
