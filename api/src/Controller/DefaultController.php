<?php

// api/src/Controller/BookController.php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function __invoke(User $data): User
    {
        //$this->bookPublishingHandler->handle($data);

        return $data;
    }
}
