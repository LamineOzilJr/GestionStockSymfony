<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Entreef;
use App\Entity\Produitf;

use App\Form\EntreefType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntreefController  extends AbstractController
{
    #[Route('/Entreef/liste', name: 'entreef_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        //$data['produits'] = $em->getRepository(Produit::class)->findAll();
        $e = new Entreef();
        
        $form = $this->createForm(EntreefType::class, $e, 
                                                array('action' => $this->generateUrl('entreef_add'))
                                            );
        $data['form'] = $form->createView();
        
        $data['entreefs'] = $em->getRepository(Entreef::class)->findAll();
        return $this->render('entreef/liste.html.twig', $data);
    }

    #[route('/Entreef/edit/{id}', name: 'entreef_edit')]
    public function getentree($id): Response
    {
        return $this->render('entreef/liste.html.twig');
    }

    #[route('/Entreef/add', name: 'entreef_add')]
    public function add(ManagerRegistry $doctrine, Request $request ): Response
    {
        $e = new Entreef();
       
        $form = $this->createForm(EntreefType::class, $e);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $e= $form->getData();
            $em = $doctrine->getManager();
            $em->persist($e);
            $em->flush();
            //mise a jour produit
            $p = $em->getRepository(Produitf::class)->find($e->getProduit()->getId());
            $stock = $p->getQtStock() + $e->getQtE();
            $p->setQtStock($stock);
            $em->flush();

        }
       
        return $this->redirectToRoute('entreef_liste');
    }

    #[route('/Entreef/delete/{id}', name: 'entreef_delete')]
    public function delete($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $entree = $em->getRepository(Entreef::class)->find($id);
        if ($entree != null) {
            $em->remove($entree);
            $em->flush();
        }
        return $this->redirectToRoute('entreef_liste');
       
    }

    #[route('/Entreef/edit/{id}', name: 'entreef_edit')]
    public function edit($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $ent = $em->getRepository(Entreef::class)->find($id);
     
       
        $form = $this->createForm(EntreefType::class, $ent, 
                                                array('action' => $this->generateUrl('entreef_update', ['id' => $id]))
                                            );
        $data['form'] = $form->createView();
        
        $data['entreefs'] = $em->getRepository(Entreef::class)->findAll();
        return $this->render('entreef/liste.html.twig', $data);
      
    }

    #[route('/Entreef/update/{id}', name: 'entreef_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request ): Response
    {
        $e = new Entreef();
        $form = $this->createForm(EntreefType::class, $e);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $e = $form->getData();
            $e->setUser($this->getUser()); // en cas de blem delete this line 
            $e->setId($id);
            $em = $doctrine->getManager();
            $entree = $em->getRepository(Entreef::class)->find($id);
            $entree->setDateE($e->getDateE());
            $entree->setProduit($e->getProduit());
            $entree->setCategorie($e->getCategorie());
            $entree->setQtE($e->getQtE());
            $em->flush();
        }  

        return $this->redirectToRoute('entreef_liste');
    }
   
}
