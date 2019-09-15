<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function getEntityManager()
    {
        $entityManager = $this->getDoctrine()->getManager();
        return $entityManager;
    }

}