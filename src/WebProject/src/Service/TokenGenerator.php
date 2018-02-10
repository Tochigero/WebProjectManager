<?php

namespace App\Service;

use App\Entity\Project;
use App\Entity\Token;
use Doctrine\Common\Persistence\ObjectManager;

class TokenGenerator
{
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function newToken(Project $project)
    {
        if (isset($_SESSION['token'])) {
            $token = $this->em->getRepository(Token::class)->findByToken($_SESSION['token']);
            $this->em->remove($token);
        }

        $expire_date = new \DateTime('now');
        $expire_date = $expire_date->add(\DateInterval::createFromDateString('12 hours'));

        $token = new Token();
        $token->setToken(md5($project->getName() . rand(1, 9999999)));
        $token->setProjectId($project);
        $token->setExpireDate($expire_date);

        $this->em->persist($token);
        $this->em->flush();

        return $token->getToken();
    }

    public function removeAll(Project $project = null)
    {
        $tokenRepo = $this->em->getRepository(Token::class);
        if (!is_null($project)) {
            $tokens = $tokenRepo->getAll();
        } else {
            $tokens = $tokenRepo->findByProjectId($project->getId());
        }
        foreach ($tokens as $token) {
            $this->em->remove($token);
        }
        $this->em->flush();
    }

    public function remove(Token $token)
    {
        $tokenRepo = $this->em->getRepository(Token::class);
        $token = $tokenRepo->find($token->getToken());
        $this->em->remove($token);
        $this->em->flush();
    }
}