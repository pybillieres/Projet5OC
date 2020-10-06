<?php

namespace Controller;

use Framework\Controller;

class ApiController extends Controller
{

	function lastReviewsApi()
	{
//bloquer referer et verifier origine de la requete
		if ($this->request->existParameter('id')) {
			$page = $this->request->Parameter('id');
		} else {
			$page = 1;
		}
		$controller = new ReviewController;
		$reviews = $controller->lastReviewsId($page);
		$this->reponse_json($reviews);
	}

	function reponse_json($data)
	{ //penser a ajouter variable sucess true or false

		$array['result'] = $data['reviewsId'];
		$array['total_pages'] = $data['nbrPages'];
		header('Content-Type: application/json');
		echo json_encode($array);
	}
}
