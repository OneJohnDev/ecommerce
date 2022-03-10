<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager=$entityManager;
    }
    /**
     * @Route("/produits", name="product")
     */
    public function index(): Response
    {
        $products=$this->entityManager->getRepository(Product::class)->findAll();
        //dd($products);
        return $this->render('product/index.html.twig',[
            'products'=>$products
        ]);
    }
}
