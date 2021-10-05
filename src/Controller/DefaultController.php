<?php

namespace App\Controller;

use App\Entity\User;
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

        $form = $this->createFormBuilder()
            ->add('username')
            ->add('age')
            ->add('phone')
            /*->add('register', SubmitType::class,[
                'attr'=> [
                    'class' => 'btn btn-primary float-right'
                ]
                ]
            )*/
            ->getForm();

        $form->handleRequest($request);

        if ($request->request->all()){
            dd($request->request->all());
            $data = $form->getData();

            $user = new User();
            dd($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

        }

        return $this->render('registration/index.html.twig', [
            'form'=>$form->createView()
        ]);
    }
}
