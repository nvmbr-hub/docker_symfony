<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;
use Symfony\Component\HttpFoundation\Request;

class PriceController extends AbstractController
{
//    private PaymentService $paymentService;
//
//    public function __construct(PaymentService $paymentService)
//    {
//        $this->paymentService = $paymentService;
//    }
//
//    /**
//     * @Route("/calculate-price", methods={"POST"})
//     */
//    public function calculatePrice(Request $request): JsonResponse
//    {
//        // Получение данных из тела запроса
//        $requestData = json_decode($request->getContent(), true);
//
//        // Обработка запроса через сервис
//        try {
//            $price = $this->paymentService->calculatePrice($requestData);
//            return new JsonResponse(['price' => $price]);
//        } catch (\Exception $e) {
//            return new JsonResponse(['error' => $e->getMessage()], 400);
//        }
//    }
//
//    /**
//     * @Route("/purchase", methods={"POST"})
//     */
//    public function purchase(Request $request): JsonResponse
//    {
//        // Получение данных из тела запроса
//        $requestData = json_decode($request->getContent(), true);
//
//        // Обработка запроса через сервис
//        try {
//            $this->paymentService->processPurchase($requestData);
//            return new JsonResponse(['message' => 'Purchase successful']);
//        } catch (\Exception $e) {
//            return new JsonResponse(['error' => $e->getMessage()], 400);
//        }
//    }

//    /**
//     * @Route("/calculate-price", methods={"GET"})
//     */
    #[Route('/calculate-price', name: 'get_price', methods: 'GET')]
    public function getCalculatePrice(): JsonResponse
    {

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PriceController.php',
        ]);
    }
//    #[Route('/calculate-price', name: 'post_price', methods: 'POST')]
    /**
     * @Route("/calculate-price", methods={"POST"})
     */
    public function calculatePrice(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);
        $requestDataParam = $request->query->all();
        try {
            $price = $this->paymentService->calculatePrice($requestData);
            return new JsonResponse(['price' => $price]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

}
