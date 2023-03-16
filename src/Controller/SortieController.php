<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\Produit;
use App\Form\SortieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/Sortie/liste', name: 'sortie_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        //$data['produits'] = $em->getRepository(Produit::class)->findAll();
        $s = new Sortie();
        
        $form = $this->createForm(SortieType::class, $s, 
                                                array('action' => $this->generateUrl('sortie_add'))
                                            );
        $data['form'] = $form->createView();
        
        $data['sorties'] = $em->getRepository(Sortie::class)->findAll();
        return $this->render('sortie/liste.html.twig', $data);
    }

    #[route('/Sortie/edit/{id}', name: 'sortie_edit')]
    public function getentree($id): Response
    {
        return $this->render('sortie/liste.html.twig');
    }

    #[route('/Sortie/add', name: 'sortie_add')]
    public function add(ManagerRegistry $doctrine, Request $request ): Response
    {
        $s = new Sortie();
       
        $form = $this->createForm(SortieType::class, $s);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $s= $form->getData();
            $qsortie = $s->getQtS();
            $p = $em->getRepository(Produit::class)->find($s->getProduit()->getId());
            if($p->getQtStock() <  $s->getQtS()) {
                $s = new Sortie();
        
                $form = $this->createForm(SortieType::class, $s, 
                                                        array('action' => $this->generateUrl('sortie_add'))
                                                    );
                                                    
                $data['form'] = $form->createView();
                $data['sorties'] = $em->getRepository(Sortie::class)->findAll();
                $data['error_message'] = 'Le stock disponible est inferieur a '.$qsortie ;
                
                return $this->render('sortie/liste.html.twig', $data);
            }else{

            
            $em->persist($s);
            $em->flush();
            //mise a jour produit
            
             $stock = $p->getQtStock() - $s->getQtS();
             $p->setQtStock($stock);
             $em->flush();
             return $this->redirectToRoute('sortie_liste');
            }
            
        } 
    }

    #[route('/Sortie/delete/{id}', name: 'sortie_delete')]
    public function delete($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $qsortie = $em->getRepository(Sortie::class)->find($id);
        if ($qsortie != null) {
            $em->remove($qsortie);
            $em->flush();
        }
        return $this->redirectToRoute('sortie_liste');
       
    }

    #[route('/Sortie/edit/{id}', name: 'sortie_edit')]
    public function edit($id, ManagerRegistry $doctrine)
    {
        $em = $doctrine->getManager();
        $ent = $em->getRepository(Sortie::class)->find($id);
     
       
        $form = $this->createForm(SortieType::class, $ent, 
                                                array('action' => $this->generateUrl('sortie_update', ['id' => $id]))
                                            );
        $data['form'] = $form->createView();
        
        $data['sorties'] = $em->getRepository(Sortie::class)->findAll();
        return $this->render('sortie/liste.html.twig', $data);
      
    }

    #[route('/Entree/update/{id}', name: 'sortie_update')]
    public function update($id, ManagerRegistry $doctrine, Request $request ): Response
    {
        $s = new Sortie();
        $form = $this->createForm(SortieType::class, $s);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $s = $form->getData();
            $s->setUser($this->getUser()); // en cas de blem delete this line 
            $s->setId($id);
            $em = $doctrine->getManager();
            $qsortie = $em->getRepository(Sortie::class)->find($id);
            $qsortie->setDateS($s->getDateS());
            $qsortie->setProduit($s->getProduit());
            $qsortie->setCategorie($s->getCategorie());
            $qsortie->setQtE($s->getQtE());
            $em->flush();
        }

        return $this->redirectToRoute('sortie_liste');
    }

}
