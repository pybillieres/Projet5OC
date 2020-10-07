<?php

namespace Controller;

use Framework\Controller;

class ApiController extends Controller
{

	/**
	 * Récupère les id des films ayant recu des commentaires
	 */
	function lastReviewsApi()
	{
		if ($this->request->existParameter('id')) {
			$page = $this->request->Parameter('id');
		} else {
			$page = 1;
		}
		$controller = new ReviewController;
		$reviews = $controller->lastReviewsId($page);
		$this->reponse_json($reviews);
	}

	/**
	 * converti la réponse de l'API en JSON
	 */
	function reponse_json($data)
	{

		$array['result'] = $data['reviewsId'];
		$array['total_pages'] = $data['nbrPages'];
		header('Content-Type: application/json');
		echo json_encode($array);
	}
}
