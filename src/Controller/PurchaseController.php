<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    #[Route('/purchase', name: 'get_price', methods: 'GET')]
    public function getPurchase(): JsonResponse
    {

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PriceController.php',
        ]);
    }

    #[Route('/purchase', name: 'post_price', methods: 'POST')]
    public function postPurchase(Request $request): JsonResponse
    {
        $data = $request->query->all();
        $keyMap = ['product', 'taxNumber', 'couponCode'];

        foreach ($data as $key => $value) {
            if (!in_array($key, $keyMap) || !is_string($value)) {
                throw new BadRequestHttpException('Message');
            }
        }


        return new JsonResponse(['message' => 'POST request handled successfully']);
    }
}
