<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ForgetPasswordType;
use App\Form\ProjectCreateType;
use App\Form\ProjectMinimalType;
use App\Service\TokenGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProjectController extends Controller
{
    /**
     * Project Action
     *
     * @param $name
     * @return Response
     */
    public function showProject($name)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Project::class);

        $project = $repo->findOneByName($name);

        return $this->render("front/project/main.html.twig", [
            "project" => $project
        ]);
    }
}
