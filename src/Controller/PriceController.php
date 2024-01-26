<?php

namespace App\Controller;

use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Flex\Response;

class PriceController extends AbstractController
{
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

//    #[Route('/calculate-price', name: 'get_price', methods: ['GET'])]
    /**
     * @Route("/calculate-price", methods={"GET"})
     */
    public function getCalculatePrice(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PriceController.php',
        ]);
    }

//    #[Route('/calculate-price', name: 'post_price', methods: ['POST'])]
    /**
     * @Route("/calculate-price", methods={"POST"})
     */
    public function calculatePrice(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $requestDataParam = $request->query->all();
        //Checking ID from response with DB Object ORM

        try {
            $price= 100000;
            //$price = $this->paymentService->calculatePrice($requestDataParam);
            return new JsonResponse(['price' => $price]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    # Получение продукта
    public function getProduct (PaymentService $paymentService)
    {
        $result = $paymentService->processPayment();


        return $result;
    }

}
