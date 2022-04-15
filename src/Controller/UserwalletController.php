<?php

namespace App\Controller;

use App\Form\WalletType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Wallet;
class UserwalletController extends AbstractController
{
    /**
     * @Route("/userwallet", name="userwallet")
     */
    public function index(): Response
    {
        $wal = $this->getDoctrine()->getManager()->getRepository(Wallet::class)->findAll();
        return $this->render('userwallet/index.html.twig', ['b' => $wal]);
    }

    /**
     * @Route("/useraddwallet", name="useraddwallet")
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
            return $this-> redirectToRoute('userwallet');
        }
        else
            return $this->render('userwallet/create.html.twig',['f'=> $form->createView()]);
    }

    /**
     * @Route("/userdelwallet/{id}", name="userdelwallet")
     */
    public function Delete(Wallet $wallet): Response
    {
        $em = $this -> getDoctrine()->getManager();
        $em->remove($wallet);
        $em->flush();
        return $this-> redirectToRoute('userwallet');

    }

    /**
     * @Route("/userupdatewallet/{id}", name="userupdatewallet")
     */
    public function updateWallet (Request $request,$id) :Response
    {
        $wall = $this->getDoctrine()->getManager()->getRepository(Wallet::class)->find($id);
        $form = $this-> createForm(WalletType::class,$wall);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form ->isValid())
        {$em = $this -> getDoctrine()->getManager();
            $em -> flush();
            return $this-> redirectToRoute('userwallet');
        }
        else
            return $this->render('userwallet/update.html.twig',['f'=> $form->createView()]);
    }
}
