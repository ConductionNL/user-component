<?php

// api/src/Controller/BookController.php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function __invoke(User $data): User
    {

        return $data;
    }

    /**
     * @Route("/public_key")
     */
    public function getPublicKey(): Response
    {
        return new Response(base64_decode($this->getParameter('public_key')), 200, ['Content-Type' => 'application/x-pem-file']);
    }
}
