<?php

namespace AppBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Place;

class PlaceController extends Controller
{
    /**
     * @Route("/api/places", name="places_list")
     * @Method({"GET"})
     */
    public function getPlacesAction()
    {

        $places = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Place')
            ->findAll();
        /* @var $places Place[] */

        if (!count($places)) {
            $response = [
                'code' => 1,
                'message' => 'places not found',
                'error' => null,
                'result' => null
            ];
            return new JsonResponse($response, Response::HTTP_NOT_FOUND);
        }

        $data = $this->get('jms_serializer')->serialize($places, 'json');

        $response = [
            'code' => 0,
            'message' => 'success',
            'errors' => null,
            'result' => json_decode($data)
        ];

        return new JsonResponse($response, 200);
    }
}