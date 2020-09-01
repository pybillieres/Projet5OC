<?php
namespace Controller;

use Framework\Controller;
use Model\ReviewManager;

class ReviewController extends Controller
{


    function getReviews($id)
    {
        $manager = new ReviewManager;
        $reviews = $manager->getReviewsByFilm($id);
        return $reviews;
    }
}