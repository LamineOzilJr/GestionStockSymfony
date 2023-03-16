<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Produitf;
use App\Form\ProduitfType;
use Symfony\Bundle\Frameworkbundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitfController extends AbstractController
{
    #[route('/Produitf/liste', name: 'produitf_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $p = new Produitf();
        $form = $this->createForm(ProduitfType::class, $p, 
                                                array('action' => $this->generateUrl('produitf_add'))
                                            );
        $data['form'] = $form->createView();
        
        $data['produitfs'] = $em->getRepository(Produitf::class)->findAll();
        return $this->render('produitf/liste.html.twig', $data);
    }


    #[route('/Produitf/get/{id}', name: 'produitf_get')]
    public function getproduit($id): Response
    {
        return $this->render('produitf/liste.html.twig');
    }

    #[route('/Produitf/add', name: 'produitf_add')]
    public function add(ManagerRegistry $doctrine, Request $request ): Response
    {
        $p = new Produitf();
        $form = $this->createForm(ProduitfType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $p= $form->getData();
            $em = $doctrine->getManager();
            $em->persist($p);
            $em->flush();

        }
       
        return $this->redirectToRoute('produitf_liste');
    }

    #[route('/Produitf/delete/{id}', name: 'produitf_delete')]
    public function delete($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $produitf = $em->getRepository(Produitf::class)->find($id);
        if ($produitf != null) {
            $em->remove($produitf);
            $em->flush();
        }
        return $this->redirectToRoute('produitf_liste');  
    }

    #[route('/Produitf/edit/{id}', name: 'produitf_edit')]
    public function edit($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $p = $em->getRepository(Produitf::class)->find($id);
     
        $form = $this->createForm(ProduitfType::class, $p, 
                                            array('action' => $this->generateUrl('produitf_update', ['id' => $id]))
                                            );
        $data['form'] = $form->createView();
        
        $data['produitfs'] = $em->getRepository(Produitf::class)->findAll();
        return $this->render('produitf/liste.html.twig', $data);
      
    }

    #[route('/Produitf/update/{id}', name: 'produitf_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request ): Response
    {
        $p = new Produitf();
        $form = $this->createForm(ProduitfType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $p = $form->getData();
            $p->setUser($this->getUser()); // en cas de blem delete this line 
            $p->setId($id);
            $em = $doctrine->getManager();
            $produit = $em->getRepository(Produitf::class)->find($id);
            $produit->setLibelle($p->getLibelle());
            $produit->setCategorie($p->getCategorie());
            $produit->setQtStock($p->getQtStock());

            $em->flush();

        }
       
        return $this->redirectToRoute('produitf_liste');
    }
}
