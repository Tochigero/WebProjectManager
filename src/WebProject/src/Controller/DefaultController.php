<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ForgetPasswordType;
use App\Form\ProjectCreateType;
use App\Form\ProjectMinimalType;
use App\Service\RandomGenerator;
use App\Service\TokenGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
                    'name' => $project_name
                ]);
            } else {
                   $error = "Le Projet recherché n'a pas été trouvé.";
                 return $this->render("front/index/homepage.html.twig", [
            "form" => $form->createView(),
            "error" => $error
        ]);
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
    public function create(Request $request, TokenGenerator $tg, RandomGenerator $rng)
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
                ->setPassword(null);
            $mailer = new \Swift_Mailer($transport);

            $message = (new \Swift_Message('Your new Project'))
                ->setFrom(['no-reply@project.com' => 'Project Contact'])
                ->setTo([$create['admin'] => $create['admin']])
                ->setContentType('text/html')
                ->setBody($this->renderView("mail/project_create.html.twig", [
                        "project" => $project
                    ]
                ));
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
    public function forgetPassword(Request $request, RandomGenerator $rng)
    {
        $form = $this->createForm(ForgetPasswordType::class);

        $session = $this->container->get('session');

        if ($request->isMethod('POST')) {
            $values = $request->request->get('forget_password');

            $forgetToken = $session->get('forgetToken');
            $passwordToken = $session->get('passwordToken');
            if ($values['key'] == $forgetToken and $values['token'] == $passwordToken) {
                $em = $this->getDoctrine()->getManager();
                $projectRepo = $em->getRepository(Project::class);

                $project = $projectRepo->findOneByName($values['name']);
                $project->setPassword($values['password']);

                $em->persist($project);
                $em->flush();

                // TODO Ok signal or redirect into the project
                return $this->redirectToRoute('index');
            } else {
                // Error
                $errors = [];
                $errors[] = "Clef invalide";

                return $this->render("front/index/forget_password.html.twig", [
                    'form' => $form->createView(),
                    'errors' => $errors
                ]);
            }
        }

        $session->set('forgetToken', $rng->randomForgetKey());

        return $this->render("front/index/forget_password.html.twig", [
            'form' => $form->createView()
        ]);

    }

    /**
     * Check the token and send it by mail
     *
     * @return Response
     */
    public function forgetToken()
    {
        $session = $this->container->get('session');
        if ($session->has('forgetToken') and isset($_POST['project_name'])) {
            // Find project
            $em = $this->getDoctrine()->getManager();
            $projectRepo = $em->getRepository(Project::class);
            $project = $projectRepo->findOneByName($_POST['project_name']);

            if (!is_null($project)) {
                $transport = (new \Swift_SmtpTransport('mail', 25))
                    ->setUsername(null)
                    ->setPassword(null);
                $mailer = new \Swift_Mailer($transport);

                $message = (new \Swift_Message('Did you lose something ?'))
                    ->setFrom(['no-reply@project.com' => 'Project Contact'])
                    ->setTo($project->getAdmin())
                    ->setContentType('text/html')
                    ->setBody($this->renderView("mail/forget_token.html.twig", [
                            "token" => $session->get('forgetToken')
                        ]
                    ));
                $mailer->send($message);

                return new Response("true");
            } else {
                return new Response("false");
            }

        }
    }

    /**
     * Check token posted with token in session and generate a new hash code
     *
     * @param $key
     * @param RandomGenerator $rng
     * @return Response
     */
    public function forgetCheck($key, RandomGenerator $rng)
    {
        $session = $this->container->get('session');
        if ($session->has('forgetToken') and strlen($key) === 5 and $session->get('forgetToken') === $key) {
            $session->set('passwordToken', $rng->randomHash());
            return new Response($session->get('passwordToken'));
        }
        return new Response("false");
    }

}
