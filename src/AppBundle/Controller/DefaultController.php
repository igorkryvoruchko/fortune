<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function indexAction(Request $request)
    {
        $prizes = ["phone", "car", "boeing 777"];
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:main.html.twig', array(
            "prizes" => $prizes
        ));
    }
}
