<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Flex\Response;

class PriceController extends AbstractController
{

    public function __construct(
        private PaymentService $paymentService,
    )
    {

    }

    #[Route('/calculate-price', name: 'get_price', methods: ['GET'])]
    public function getCalculatePrice(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PriceController.php',
        ]);
    }

    #[Route('/calculate-price', name: 'post_price', methods: ['POST'])]
    public function postCalculatePrice(Request $request): JsonResponse
    {
        $requestDataParam = $request->query->all();

        try {
            $price = $this->paymentService->calculatePrice($requestDataParam);
            return new JsonResponse(['price' => $price]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/purchase', name: 'post_purchase', methods: ['POST'])]
    public function postPayment(Request $request): JsonResponse
    {
        // TODO: Сделать реализовать валидацию всех полей (в том числе корректность tax номера согласно формату) в теле запросов, используя Symfony validator
        $requestDataParam = $request->query->all();

        try {
            $response = $this->paymentService->processPurchase($requestDataParam);
            if ($response || $response === null) {
                return new JsonResponse(['Payment was successful' => $response]);
            } else {
                return new JsonResponse(['Payment is not successful' => $response]);
            }

        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }


}
