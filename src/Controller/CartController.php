<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/panier', name: 'app_cart')]
    public function index(SessionInterface $session, ProductRepository $productRepoitory): Response
    {
        $panier = $session->get('panier', []);
        $panierWithData = [];
        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'product' => $productRepoitory->find($id),
                'quantity' => $quantity
            ];
        }
        $total=0;
        foreach ($panierWithData as $item) {
$totalItem = $item['product']->getPrice() * $item['quantity']; 
$total+=$totalItem;
}
        // dd($panierWithDate);
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'items' => $panierWithData,
            'nbreItems'=>count($panierWithData),
            'total'=>$total
        ]);
    }
    /**
     * @Route("/panier/add/{id}",name="cart_add")
     */
    public function add($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);
        // $session->get('panier');
        // dd($panierWithDate);
        $nbreitems = 0;
        $nbreitems=count($panier);
        return $this->redirectToRoute('app_product_index', [
            'controller_name' => 'CartController',
            // dd(count($panier))
            'nbreItems'=>$nbreitems
        
        ]);
    }
/**
 * @Route("/panier/remove/{id}",name="cart_remove")
 */
    public function remove($id,SessionInterface $session){

        $panier =$session->get('panier',[]);

        if (!empty($panier[$id])) {
unset($panier[$id]); 
       }
       $session->set('panier',$panier);

       return $this->redirectToRoute('app_cart');

    }
}
