<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ForgetPasswordType;
use App\Form\ProjectCreateType;
use App\Form\ProjectMinimalType;
use App\Service\RandomGenerator;
use App\Service\TokenGenerator;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request, TokenGenerator $tg)
    {
        $form = $this->createForm(ProjectMinimalType::class);

        if ($request->isMethod('POST')) {
            $project_name = $request->request->get('project_minimal')['name'];
            $password = $request->request->get('project_minimal')['password'];

            $em = $this->getDoctrine()->getManager();
            $projectRepo = $em->getRepository(Project::class);

            $project = $projectRepo->findOneBy(['name' => $project_name, 'password' => $password]);

            if (!is_null($project)) {
                $_SESSION['token'] = $tg->newToken($project);

                return $this->redirectToRoute('show_project', [
                    'name' => 'random_name'
                ]);
            } else {
                // TODO Add error
            }
        }

        return $this->render("front/index/homepage.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * ProjectCreationPage
     *
     * @return Response
     */
    public function create(Request $request, TokenGenerator $tg, RandomGenerator $rng, \Swift_Mailer $mailer)
    {
        // If POST we create new Project
        if ($request->isMethod('POST')) {
            // Traitement admin/password
            $em = $this->getDoctrine()->getManager();

            $create = $_POST['project_create'];
            $project = new Project();
            $project->setAdmin($create['admin']);
            $project->setAdminPassword($create['password']);

            // Project Creation
            $project->setName($rng->randomCode());
            $project->setPassword($rng->randomPassword());

            $em->persist($project);
            $em->flush();

            // Mail Send
            $transport = (new \Swift_SmtpTransport('mail', 25))
                ->setUsername(null)
                ->setPassword(null)
            ;
            $mailer = new \Swift_Mailer($transport);

            $message = (new \Swift_Message('Your new Project'))
                ->setFrom(['no-reply@project.com' => 'Project Contact'])
                ->setTo([$create['admin'] => $create['admin']])
                ->setContentType('text/html')
                ->setBody($this->renderView("mail/project_create.html.twig", [
                        "project" => $project
                    ]
                ))
            ;
            $mailer->send($message);

            // Session Token
            $_SESSION['token'] = $tg->newToken($project);

            return $this->redirectToRoute('show_project', [
                'name' => $project->getName()
            ]);
        }

        // Else send form
        $form = $this->createForm(ProjectCreateType::class);
        return $this->render("front/index/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * Forget Password Action
     */
    public function forgetPassword()
    {
        $form = $this->createForm(ForgetPasswordType::class);

        // TODO Forget Password Process

        return $this->render("front/index/forget_password.html.twig", [
            'form' => $form->createView()
        ]);

    }

}
