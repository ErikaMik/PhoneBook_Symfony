<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="home.")
 */

class  MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $userId = $this->getUser()->getId();
        $contacts = $this->getDoctrine()
            ->getRepository('App\Entity\Contacts')
            ->findBy(array('user_id' => $userId));

        return $this->render(
            'show.html.twig',
            array('contacts' => $contacts)
        );
    }

}
