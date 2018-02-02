<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Homepage
     * First test templating
     *
     * @return Response
     */
    public function index()
    {
        return $this->render("front/homepage.html.twig");
    }

    /**
     * Test get url parameters
     *
     * @param string $id
     * @return object|Response
     */
    public function get($id) {
        return $this->render('front/get.html.twig', [
            "id" => $id
        ]);
    }
}
