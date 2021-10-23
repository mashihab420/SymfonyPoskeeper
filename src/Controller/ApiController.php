<?php

namespace App\Controller;

use App\Entity\ComplainDetails;
use App\Entity\Orders;
use App\Entity\Product;
use App\Repository\ApiRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Controller
 * @Route("/api")
 */
class ApiController extends AbstractController
{

    /**
     * @Route("/", name="api")
     */
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
     * @Route("/products", name="products")
     * @param Request $request
     * @param ApiRepository $apiRepository
     * @return JsonResponse|Response
     */
    public function sendProducts(Request $request, ApiRepository $apiRepository)
    {
        //dd($request);
        //    if ($request->getMethod() == 'GET' && ($request->headers->get('Content-Type') == 'application/json' && $request->headers->get('key') == '8821')) {
        if ($request->getMethod() == 'GET' /*&& $request->headers->get('Content-Type') == 'application/json' && $request->headers->get('key') == '8821'*/) {
            $records = $apiRepository->getProducts();

            $data['Status'] = 200;
            $data['Content-Type'] = $request->headers->get('Content-Type');
            $data['data'] = $records;

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
//            $response->setContent(json_encode($data));
            $response->setContent(json_encode($records));
            $response->setStatusCode(Response::HTTP_OK);
            return $response;
        } else {
            return new JsonResponse([
                'message' => 'Invalied request',
                'status' => 500
            ]);
        }
    }


    /**
     * @Route("/users", name="users")
     * @param Request $request
     * @param ApiRepository $apiRepository
     * @return JsonResponse|Response
     */
    public function sendUsers(Request $request, ApiRepository $apiRepository)
    {
        //dd($request);
        //    if ($request->getMethod() == 'GET' && ($request->headers->get('Content-Type') == 'application/json' && $request->headers->get('key') == '8821')) {
        if ($request->getMethod() == 'GET' && $request->headers->get('Content-Type') == 'application/json' && $request->headers->get('key') == '8821') {

            $records = $apiRepository->getUsers();

            $data['Status'] = 200;
            $data['Content-Type'] = $request->headers->get('Content-Type');
            $data['data'] = $records;

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
//            $response->setContent(json_encode($data));
            $response->setContent(json_encode($records));
            $response->setStatusCode(Response::HTTP_OK);
            return $response;
        } else {
            return new JsonResponse([
                'message' => 'Invalied request',
                'status' => 500
            ]);
        }
    }


    /**
     * @Route("/usersbyid", name="usersbyid")
     * @param Request $request
     * @param ApiRepository $apiRepository
     * @return JsonResponse|Response
     */
    public function sendUsersPost(Request $request, ApiRepository $apiRepository)
    {
        //dd($request);
        //    if ($request->getMethod() == 'GET' && ($request->headers->get('Content-Type') == 'application/json' && $request->headers->get('key') == '8821')) {
        if ($request->getMethod() == 'POST') {

            $id = $request->request->get('id');
            $results = $apiRepository->getProductPost($id);
//            return new JsonResponse([$results]);

            /*$array = ["red","blue","black"];

            $data['productinfo'] = $results;
            $data['color'] = $array;*/

            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
//            $response->setContent(json_encode($data));
            $response->setContent(json_encode($results));
            $response->setStatusCode(Response::HTTP_OK);
            return $response;
        } else {
            return new JsonResponse([
                'message' => 'Invalied request',
                'status' => 500
            ]);
        }
    }


    /**
     * @Route("/update", name="update_product")
     * @param Request $request
     * @param ApiRepository $apiRepository
     * @return JsonResponse
     */
    public function update(Request $request,ProductRepository $repository)
    {
        $data = json_decode($request->getContent(), true);
       // return new JsonResponse([$data['id']]);
       // $dataa = json_decode($request->getContent(), true);




       // return new JsonResponse([$data[1]['name']]);

        $product = $repository->find($data['id']);



        if ($product != null){
            //return new JsonResponse([$product]);
            $em = $this->getDoctrine()->getManager();

            $product->setName($data['name']);
            $product->setMrp($data['mrp']);
            $em->persist($product);
            $em->flush();

            return new JsonResponse([
                'status' => 200,
                'message' => 'Update successful'
            ]);
        }else{
            return new JsonResponse([
                'status' => 500,
                'message' => 'Not found'
            ]);
        }


    }


    /**
     * @Route("/products/{id}", name="delete_product", methods={"DELETE"})
     * @param Product $product
     * @return JsonResponse
     */
    public function delete(Product $product): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();

        if ($product){
            $em->remove($product);
            $em->flush();
            return new JsonResponse([
                'status' => 200,
                'message' => 'success'
            ]);
        }else{
            return new JsonResponse([
                'status' => 500,
                'message' => 'Not found'
            ]);
        }

    }


    /**
     * @Route("/insertproduct", name="insert_product")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function createProduct(Request $request,ProductRepository $productRepository,CategoryRepository $categoryRepository)
    {
        if ($request->getMethod() === 'POST') {
            $data = $request->request->all();
            $name = $request->request->get('name');
//            $products = $productRepository->getProductPost($name);
            $product = $productRepository->findOneBy(['name' => $name]);

            // return new JsonResponse([$products]);


            $findcat = $categoryRepository->find($data['category_id']);



            if (!$product) {
                if (isset($data['name']) && isset($data['mrp'])) {
                    $product = new Product();
                    $product->setMrp($data['mrp']);
                    $product->setName($data['name']);
                    $product->setStock($data['stock']);
                    $product->setCategory($findcat);
                    $product->setSize(isset($data['size']) ? $data['size'] : "");
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($product);
                    $em->flush();

                    return new JsonResponse([
                        'status' => 200,
                        'message' => 'insert successful',
                    ]);
                }
            } else {
                return new JsonResponse([
                    'status' => 500,
                    'message' => 'Product Already exist',
                ]);
            }
        }
    }



    /**
     * @Route("/orders", name="order_product")
     * @param Request $request
     * @return Response
     */
    public function orders(Request $request, ProductRepository $productRepository)
    {
        if ($request->getMethod() === 'POST') {
            $data = $request->request->all();

            $items = json_decode($data["items"], true);

            return new JsonResponse($items);

            /*foreach ($data as $product){

            }*/

            foreach ($items as $key => $item) {

            }

            if (isset($data['invoiceno'])){
                $orders = new Orders();
                $orders->setInvoiceno($data['invoiceno']);
                $orders->setProductid($data['productid']);
                $orders->setQuantity($data['quantity']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($orders);
                $em->flush();

                $product = $productRepository->find($data['productid']);

                if ($product){
                    $product->setStock($product->getStock() - $data['quantity']);
                    $em->persist($product);
                    $em->flush();
                }


                return new JsonResponse([
                    'status' => 200,
                    'message' => 'Order Successful',
                ]);
            }else{
                return new JsonResponse([
                    'status' => 250,
                    'message' => 'failed',
                ]);
            }

        } else {
            return new JsonResponse([
                'status' => 250,
                'message' => 'failed',
            ]);
        }
    }


    /**
     * @Route("/search", name="search_product")
     * @param Request $request
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function search(Request $request, ProductRepository $productRepository)
    {
        if ($request->getMethod() === 'POST') {
          /*  $data = $request->request->all();*/

          /*  $id = $request->request->get('id');*/


            $products = $productRepository->findAll();
            $data = [];
            foreach ($products as $key => $product) {
                $data[$key]['id'] = $product->getId();
                $data[$key]['name'] = $product->getName();
            }

            return new JsonResponse($data);




        } else {
            return new JsonResponse([
                'status' => 250,
                'message' => 'failed',
            ]);
        }
    }

    /**
     * @Route("/uploadsimg", name="uploadsimg")
     * @param Request $request
     * @param ParameterBagInterface $parameterBag
     * @return Response
     */
    public function imageupload(Request $request,ParameterBagInterface $parameterBag)
    {
        if ($request->getMethod() == 'POST') {
            $data = $request->request->all();


            $em = $this->getDoctrine()->getManager();


            $comments = json_decode($data['comments'], true);
            foreach ($comments as $comment) {
                $fileName = '';
                if (preg_match('/^data:image\/(\w+);base64,/', $comment['attachment'], $type)) {
                    $extension = $type[1];
                    $attachment = substr($comment['attachment'], strpos($comment['attachment'], ',') + 1);
                    $attachment = str_replace(' ', '+', $attachment);
                    $attachment = base64_decode($attachment);
                    $fileName = $comment['comment'] . '_' . date('d-m-Y') . '_' . time() . '.' . $extension;

                    file_put_contents($parameterBag->get('uploadDir') . '\public\ecommerce\uploads\\' . $fileName, $attachment);
                }

                $details = new ComplainDetails();
                $details->setComment($comment['comment']);
                $details->setUrl($fileName);
                $em->persist($details);
                $em->flush();

            }

            return new JsonResponse([
                'status' => 200,
                'message' => 'success'
            ]);

        }

    }

}
