<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{

    private $EntityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager= $entityManager;
    }
    /**
     * @Route("/compte/password", name="account_password")
     */
    

    
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $notification = null;
        $user=$this->getUser();
        $form = $this->createForm(ChangePasswordType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $old_password = $form->get('old_password')->getData();
           
            if($passwordHasher->isPasswordValid($user,$old_password)){
                $new_password = $form->get('new_password')->getData();
                $password = $passwordHasher->hashPassword($user, $new_password);
                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification="Votre mot de passe a bien été modifié.";
            } else{
                $notification="Votre mot de passe actuel n'est pas bon.";
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

        }
        return $this->render('account/password.html.twig',[
            'form2' =>$form->createView(),
            'notification' => $notification
        ]);
    }
}
