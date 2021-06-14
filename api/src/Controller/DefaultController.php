<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class DefaultController.
 */
class DefaultController extends AbstractController
{

    public function __invoke(User $data): User
    {
        return $data;
    }

}
