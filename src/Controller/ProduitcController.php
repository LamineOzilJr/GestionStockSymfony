<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Produitc;
use App\Form\ProduitcType;
use Symfony\Bundle\Frameworkbundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Httpfoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitcController extends AbstractController
{
    #[route('/Produitc/liste', name: 'produitc_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $p = new Produitc();
        $form = $this->createForm(ProduitcType::class, $p, 
                                                array('action' => $this->generateUrl('produitc_add'))
                                            );
        $data['form'] = $form->createView();
        
        $data['produitcs'] = $em->getRepository(Produitc::class)->findAll();
        return $this->render('produitc/liste.html.twig', $data);
    }


    #[route('/Produitc/get/{id}', name: 'produitc_get')]
    public function getproduit($id): Response
    {
        return $this->render('produitc/liste.html.twig');
    }

    #[route('/Produitc/add', name: 'produitc_add')]
    public function add(ManagerRegistry $doctrine, Request $request ): Response
    {
        $p = new Produitc();
        $form = $this->createForm(ProduitcType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $p= $form->getData();
            $em = $doctrine->getManager();
            $em->persist($p);
            $em->flush();

        }
       
        return $this->redirectToRoute('produitc_liste');
    }

    #[route('/Produitc/delete/{id}', name: 'produitc_delete')]
    
    public function delete($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $produitc = $em->getRepository(Produitc::class)->find($id);
        if ($produitc != null) {
            $em->remove($produitc);
            $em->flush();
        }
        return $this->redirectToRoute('produitc_liste');  
    }

    #[route('/Produitc/edit/{id}', name: 'produitc_edit')]
    public function edit($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $p = $em->getRepository(Produitc::class)->find($id);
     
        $form = $this->createForm(ProduitcType::class, $p, 
                                            array('action' => $this->generateUrl('produitc_update', ['id' => $id]))
                                            );
        $data['form'] = $form->createView();
        
        $data['produitcs'] = $em->getRepository(Produitc::class)->findAll();
        return $this->render('produitc/liste.html.twig', $data);
      
    }

    #[route('/Produitc/update/{id}', name: 'produitc_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request ): Response
    {
        $p = new Produitc();
        $form = $this->createForm(ProduitcType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $p = $form->getData();
            $p->setUser($this->getUser()); // en cas de blem delete this line 
            $p->setId($id);
            $em = $doctrine->getManager();
            $produit = $em->getRepository(Produitc::class)->find($id);
            $produit->setLibelle($p->getLibelle());
            $produit->setCategorie($p->getCategorie());
            $produit->setQtStock($p->getQtStock());

            $em->flush();

        }
       
        return $this->redirectToRoute('produitc_liste');
    }
}
