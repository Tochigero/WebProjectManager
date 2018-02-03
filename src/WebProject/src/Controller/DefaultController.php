<?php

namespace App\Controller;

use App\Form\ProjectMinimalType;
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
        $form = $this->createForm(ProjectMinimalType::class);

        if ($form->isSubmitted() and $form->isValid()) {
            dump("ok");die;
        }

        return $this->render("front/homepage.html.twig", [
            "form" => $form->createView()
        ]);
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
