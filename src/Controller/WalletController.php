<?php

namespace App\Controller;

use App\Form\WalletType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Wallet;

class WalletController extends AbstractController
{
    /**
     * @Route("/", name="appwallet")
     */
    public function index(): Response
    {
        $wal = $this->getDoctrine()->getManager()->getRepository(Wallet::class)->findAll();
        return $this->render('ctr_wallet/index.html.twig', ['b' => $wal]);
    }



    /**
     * @Route("/addwallet", name="addwallet")
     */
    public function addWallet (Request $request) :Response
    {
        $wall = new Wallet();
        $form = $this-> createForm(WalletType::class,$wall);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid())
        {$em = $this -> getDoctrine()->getManager();
            $em -> persist ($wall);
            $em -> flush();
            return $this-> redirectToRoute('appwallet');
        }
        else
            return $this->render('ctr_wallet/create.html.twig',['f'=> $form->createView()]);
    }


    /**
     * @Route("/delwallet/{id}", name="delwallet")
     */
    public function Delete(Wallet $wallet): Response
    {
        $em = $this -> getDoctrine()->getManager();
        $em->remove($wallet);
        $em->flush();
        return $this-> redirectToRoute('appwallet');

    }

    /**
     * @Route("/updatewallet/{id}", name="updatewallet")
     */
    public function updateWallet (Request $request,$id) :Response
    {
        $wall = $this->getDoctrine()->getManager()->getRepository(Wallet::class)->find($id);
        $form = $this-> createForm(WalletType::class,$wall);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid())
        {$em = $this -> getDoctrine()->getManager();
            $em -> flush();
            return $this-> redirectToRoute('appwallet');
        }
        else
            return $this->render('ctr_wallet/update.html.twig',['f'=> $form->createView()]);
    }
}
