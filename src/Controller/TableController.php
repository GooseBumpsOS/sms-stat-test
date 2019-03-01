<?php

namespace App\Controller;

use App\Entity\NumberData;
use App\Entity\SmsStat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TableController extends AbstractController
{
    /**
     * @Route("/table", name="table")
     */
    public function index(Request $request)
    {
        $numberToName = ['Москва', 'Питер'];

        $entitym = $this->getDoctrine()->getManager()->getRepository(NumberData::class);

        $em =  $this->getDoctrine()->getManager()->getRepository(SmsStat::class);

        $em->clearTable();

        $rawData = $entitym->findAll();

        for($i=0; $i<count($rawData); $i++)
        {
            $data = new SmsStat();

           switch(substr($rawData[$i]->getNumber(), '1', '3'))
           {
               case '999':
                   $data->setRegionName($numberToName['0']);
                   $data->setUndelivered($rawData[$i]->getUndelivered());
                   $data->setDay(($rawData[$i]->getDay()));
                   break;

               case '888':
                   $data->setRegionName($numberToName['1']);
                   $data->setUndelivered($rawData[$i]->getUndelivered());
                   $data->setDay(($rawData[$i]->getDay()));
                   break;
           }

           $this->getDoctrine()->getManager()->persist($data);
           $this->getDoctrine()->getManager()->flush();

           unset($data);

        }

        for($i=0; $i<count($numberToName); $i++)
        {

            $perUndeliv = count($em->findBy(['region_name' => $numberToName['0'], 'undelivered' => '1'])) / count($em->findBy(['region_name' => $numberToName['0']])) * 100;

            $data = new SmsStat();

            $data->setUndelivered($perUndeliv);
            $data->setDay($rawData['0']->getDay());
            $data->setRegionName($numberToName[$i]);

            $this->getDoctrine()->getManager()->persist($data);
          //  unset($data);

        }


        $this->getDoctrine()->getManager()->flush();



//        return $this->render('dump.html.twig', [
//            'var' => $perUndeliv,
//        ]);



        if ($request->request->has('make')){

            $data = $em->selectFromMax(count($numberToName)+1);

            return $this->render('table/index.html.twig', [
                'data' => $data,
            ]);

        } else  return $this->render('table/index.html.twig', [
            'data' => false,
        ]);


    }

}
//switch ( substr($rawData[$i]->getNumber(), '1', '3') ) регион