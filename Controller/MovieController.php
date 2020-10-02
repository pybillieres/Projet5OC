<?php

namespace Controller;

use Framework\Controller;
use Controller\ReviewController;
use Model\Review;

class MovieController extends Controller
{

    function index()
    {
        $this->lastMovies();
    }

    function lastMovies()
    {
        if ($this->request->existParameter('id') && $this->request->Parameter('id') > 0) {
            $page = $this->request->Parameter('id');
        } else {
            $page = 1;
        }
        $orderBy = ['label' => 'Le plus récent', 'parameter' => 'release_date.desc', 'action' => 'lastMovies'];
        $this->View('home.twig', ['page' => $page, 'orderBy' => $orderBy]);
    }

    function orderByReviews()
    {
        if ($this->request->existParameter('id') && $this->request->Parameter('id') > 0) {
            $page = $this->request->Parameter('id');
        } else {
            $page = 1;
        }
        $orderBy = ['label' => 'Avis le plus récent', 'parameter' => 'lastComment'];
        $this->View('home.twig', ['page' => $page, 'orderBy' => $orderBy]);
    }

    function orderByPopularity()
    {
        if ($this->request->existParameter('id') && $this->request->Parameter('id') > 0) {
            $page = $this->request->Parameter('id');
        } else {
            $page = 1;
        }
        $orderBy = ['label' => 'Le plus populaire', 'parameter' => 'popularity.desc', 'action' => 'orderByPopularity'];
        $this->View('home.twig', ['page' => $page, 'orderBy' => $orderBy]);
    }

    function Search()
    {
        $keyword = $this->request->Parameter('keyword');
        if ($this->request->existParameter('id') && $this->request->Parameter('id') > 0) {
            $page = $this->request->Parameter('id');
        } else {
            $page = 1;
        }
        $this->View('searchResults.twig', ['keyword' => $keyword, 'page' => $page, 'action' => 'Search']);
    }

    function movieDetails()
    {
        $id = $this->request->Parameter('id');
        $reviewController = new ReviewController;
        $reviews = $reviewController->getReviews($id);

        if ($reviews !== null) {
            $CommentAllowed = true;
            if ($this->checksession()) {
                foreach ($reviews as $review) {
                    $checkUser[] = $review->userId();
                }
                if (in_array($this->request->getSession()->getAttribut('userId'), $checkUser)) {
                    $CommentAllowed = false;
                }
            }
            for ($i = 0; $i < count($reviews); $i++) {
                $ratings[] = $reviews[$i]->rating();
            }
            $average = bcdiv((array_sum($ratings) / count($ratings)), 1, 2);
            $this->View('details.twig', ['reviews' => $reviews, "idMovie" => $id, "averageRating" => $average, 'commentAllowed' => $CommentAllowed]);
        } else {
            $CommentAllowed = true;
            $this->View('details.twig', ["idMovie" => $id, "averageRating" => '-', 'commentAllowed' => $CommentAllowed]);
        }
    }
}
