<?php

namespace App\Controller;

use App\Entity\Sortief;
use App\Entity\Produitf;
use App\Form\SortiefType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortiefController extends AbstractController
{
    #[Route('/Sortief/liste', name: 'sortief_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        //$data['produits'] = $em->getRepository(Produit::class)->findAll();
        $s = new Sortief();
        
        $form = $this->createForm(SortiefType::class, $s, 
                                                array('action' => $this->generateUrl('sortief_add'))
                                            );
        $data['form'] = $form->createView();
        
        $data['sortiefs'] = $em->getRepository(Sortief::class)->findAll();
        return $this->render('sortief/liste.html.twig', $data);
    }

    #[route('/Sortief/edit/{id}', name: 'sortief_edit')]
    public function getentree($id): Response
    {
        return $this->render('sortief/liste.html.twig');
    }

    #[route('/Sortief/add', name: 'sortief_add')]
    public function add(ManagerRegistry $doctrine, Request $request ): Response
    {
        $s = new Sortief();
       
        $form = $this->createForm(SortiefType::class, $s);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $s= $form->getData();
            $qsortie = $s->getQtS();
            $p = $em->getRepository(Produitf::class)->find($s->getProduit()->getId());
            if($p->getQtStock() <  $s->getQtS()) {
                $s = new Sortief();
        
                $form = $this->createForm(SortiefType::class, $s, 
                                                        array('action' => $this->generateUrl('sortief_add'))
                                                    );
                                                    
                $data['form'] = $form->createView();
                $data['sortiefs'] = $em->getRepository(Sortief::class)->findAll();
                $data['error_message'] = 'Le stock disponible est inferieur a '.$qsortie ;
                
                return $this->render('sortief/liste.html.twig', $data);
            }else{

            
            $em->persist($s);
            $em->flush();
            //mise a jour produit
            
             $stock = $p->getQtStock() - $s->getQtS();
             $p->setQtStock($stock);
             $em->flush();
             return $this->redirectToRoute('sortief_liste');
            }
        }
       
    }

    #[route('/Sortief/delete/{id}', name: 'sortief_delete')]
    public function delete($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $qsortie = $em->getRepository(Sortief::class)->find($id);
        if ($qsortie != null) {
            $em->remove($qsortie);
            $em->flush();
        }
        return $this->redirectToRoute('sortief_liste');  
    }

    #[route('/Sortief/edit/{id}', name: 'sortief_edit')]
    public function edit($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $ent = $em->getRepository(Sortief::class)->find($id);
     
       
        $form = $this->createForm(SortiefType::class, $ent, 
                                            array('action' => $this->generateUrl('sortief_update', ['id' => $id]))
                                            );
        $data['form'] = $form->createView();
        
        $data['sortiefs'] = $em->getRepository(Sortief::class)->findAll();
        return $this->render('sortief/liste.html.twig', $data);
      
    }

    #[route('/Entreef/update/{id}', name: 'sortief_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request ): Response
    {
        $s = new Sortief();
        $form = $this->createForm(SortiefType::class, $s);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $s = $form->getData();
            $s->setUser($this->getUser()); // en cas de blem delete this line 
            $s->setId($id);
            $em = $doctrine->getManager();
            $qsortie = $em->getRepository(Sortief::class)->find($id);
            $qsortie->setDateS($s->getDateS());
            $qsortie->setProduit($s->getProduit());
            $qsortie->setCategorie($s->getCategorie());
            $qsortie->setQtE($s->getQtE());
            $em->flush();
        }

        return $this->redirectToRoute('sortief_liste');
    }
}
