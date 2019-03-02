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

        $numberDataem = $this->getDoctrine()->getManager()->getRepository(NumberData::class);

        $smsStatem =  $this->getDoctrine()->getManager()->getRepository(SmsStat::class);

        $smsStatem->clearTable();

        $rawData = $numberDataem->findAll();

        for($i=0; $i<count($rawData); $i++)
        {
            $data = new SmsStat();

           switch(substr($rawData[$i]->getNumber(), '1', '3'))
           {
               case '999':
                   $data->setRegionName($numberToName['0']);
                   $data->setUndelivered($rawData[$i]->getUndelivered());
                   $data->setDay($rawData[$i]->getDay()->format('Y-m-d'));
                   break;

               case '888':
                   $data->setRegionName($numberToName['1']);
                   $data->setUndelivered($rawData[$i]->getUndelivered());
                   $data->setDay($rawData[$i]->getDay()->format('Y-m-d'));
                   break;
           }

           $this->getDoctrine()->getManager()->persist($data);
           $this->getDoctrine()->getManager()->flush();

           unset($data);

        }

        for($i=0; $i<count($rawData); $i++)
        $arrayOfDate[] =  $smsStatem->find($i+1)->getDay();
        $arrayOfDate = array_unique($arrayOfDate);


        for($i=0; $i<count($arrayOfDate); $i++)
        {
           for($c=0; $c<count($numberToName);$c++)
           {
               $data = new SmsStat();

               $different = count($smsStatem->findBy(['region_name' => $numberToName[$c], 'undelivered' => 1]) ) / count($smsStatem->findBy(['region_name' => $numberToName[$c]]) );

               $data->setRegionName($numberToName[$c]);
               $data->setDay($arrayOfDate[$i]);
               $data->setUndelivered($different * 100);

               $this->getDoctrine()->getManager()->persist($data);

           }


//            $this->getDoctrine()->getManager()->persist($data);


            unset($data);

        }
        $this->getDoctrine()->getManager()->flush();
//        return $this->render('dump.html.twig', [
//
//           'var' => $different
//
//        ]);


        if ($request->request->has('make')){

            $data = $smsStatem->selectFromMax(count($numberToName)+1);

            return $this->render('table/index.html.twig', [
                'data' => $data,
            ]);

        } else  return $this->render('table/index.html.twig', [
            'data' => false,
        ]);


    }

}
//switch ( substr($rawData[$i]->getNumber(), '1', '3') ) регион


//$perUndeliv = count($em->findBy(['region_name' => $numberToName['0'], 'undelivered' => '1'])) / count($em->findBy(['region_name' => $numberToName['0']])) * 100; общее / на недошедшие