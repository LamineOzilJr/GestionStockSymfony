<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;


use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    #[route('/User/add', name: 'user_add')]
    public function add(ManagerRegistry $doctrine, Request $request ): Response
    {
        $u = new User();
       
        $form = $this->createForm(UserType::class, $u);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $u= $form->getData();
            $em = $doctrine->getManager();
            $em->persist($u);
            $em->flush();
            //mise a jour users
            $em->flush();

        }
       
        return $this->redirectToRoute('user_liste');
    }
}
