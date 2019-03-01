<?php

namespace App\Controller;

use App\Entity\SmsStat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TableController extends AbstractController
{
    /**
     * @Route("/table", name="table")
     */
    public function index()
    {
        $em =$this->getDoctrine()->getManager()->getRepository(SmsStat::class);

        $data = $em->findAll();


        return $this->render('table/index.html.twig', [
            'data' => $data,
        ]);
    }
}
