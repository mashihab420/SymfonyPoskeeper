<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegisterFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index(UserRepository $repository): Response
    {
        $records = $repository->findAll();

        return $this->render('registration/index.html.twig', [
            'records' => $records
        ]);
    }

    /**
     * @Route("/product", name="product")
     */
    public function products(UserRepository $repository): Response
    {
        $records = $repository->findAll();

        return $this->render('product/index.html.twig', [
            'records' => $records
        ]);
    }

    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserRegisterFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success', 'Registration succesfully!');
            return $this->redirectToRoute('register');

        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
