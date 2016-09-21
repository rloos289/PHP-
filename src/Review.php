<?php
    Class Review
    {
        private $id;
        private $text_review;
        private $score_review;
        private $restaurant_id;

        function __construct($text_review, $score_review, $restaurant_id = null, $id = null)
        {
            $this->text_review = $text_review;
            $this->score_review = $score_review;
            $this->id = $id;
            $this->restaurant_id = $restaurant_id;
        }

        function setTextReview()
        {
            $this->text_review = $text_review;
        }

        function getTextReview()
        {
            return $this->text_review;
        }
        function setScoreReview()
        {
            $this->score_review = $score_review;
        }

        function getScoreReview()
        {
            return $this->score_review;
        }

        function getiD()
        {
            return $this->id;
        }

        function getRestaurantId()
        {
            return $this->restaurant_id;
        }
//-------------functions--------------//
        function save() {
            $GLOBALS['DB']->exec("INSERT INTO reviews (text_review, score_review, restaurant_id) VALUES ('{$this->getTextReview()}',{$this->getScoreReview()},{$this->getRestaurantId()});");
            $this->id= $GLOBALS['DB']->lastInsertId();
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM reviews;");
        }

        static function getAll()
        {
            $returned_reviews = $GLOBALS['DB']->query("SELECT * FROM reviews;");
            $reviewArray = array();
            foreach ($returned_reviews as $review) {
                $text_review = $review['text_review'];
                $score_review = (int) $review['score_review'];
                $id = $review['id'];
                $restaurant_id = $review['restaurant_id'];
                $new_review = new Review ($text_review, $score_review, $restaurant_id, $id);
                array_push($reviewArray, $new_review);
            }
            return $reviewArray;
        }
    }

 ?>
