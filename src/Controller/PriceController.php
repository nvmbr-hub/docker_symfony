<?php

namespace App\Controller;

use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PriceController extends AbstractController
{
    public function __construct(
        private readonly PaymentService     $paymentService,
        private readonly ValidatorInterface $validator
    ) {}

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
        $requestData = $request->query->all();
        $constraints = $this->getCalculatePriceConstraints();
        $violations = $this->validator->validate($requestData, $constraints);

        if (count($violations) > 0) {
            return $this->createValidationErrorResponse($violations);
        }
        try {
            $price = $this->paymentService->processCalculatePrice($requestData);
            return new JsonResponse(['price' => $price]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    #[Route('/purchase', name: 'post_purchase', methods: ['POST'])]
    public function postPayment(Request $request): JsonResponse
    {
        // TODO: DTO
        $requestData = $request->query->all();
        $constraints = $this->getPurchaseConstraints();
        if (isset($requestData['product'])) {
            $requestData['product'] = intval($requestData['product']);
        }
        $violations = $this->validator->validate($requestData, $constraints);

        if (count($violations) > 0) {
            return $this->createValidationErrorResponse($violations);
        }
        try {
            $response = $this->paymentService->processPurchase($requestData);
            if ($response) {
                return new JsonResponse(['Payment was successful' => $response]);
            } else {
                return new JsonResponse(['Payment is not successful' => $response]);
            }
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }

    private function getCalculatePriceConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'product' => [
                new Assert\NotBlank(),
                new Assert\Type('integer'),
                new Assert\GreaterThanOrEqual([
                    'value' => 0,
                    'message' => 'The value must be a non-negative number.',
                ]),
            ],
            'taxNumber' => [
                new Assert\NotBlank(),
                new Assert\Length(
                    min: 11,
                    max: 13,
                    minMessage: 'Ваше имя должно быть хотя бы {{ limit }} символов в длину',
                    maxMessage: 'Ваше имя не может быть больше {{ limit }} символов в длину',
                ),
                new Assert\Regex([
                    'pattern' => $this->getTaxNumberRegex(),
                    'message' => 'Invalid tax number format.',
                ]),
            ],
            'couponCode' => [
                new Assert\NotBlank(),
                new Assert\Length(
                    min: 3,
                    max: 8,
                    minMessage: 'Ваше имя должно быть хотя бы {{ limit }} символов в длину',
                    maxMessage: 'Ваше имя не может быть больше {{ limit }} символов в длину',
                ),
            ],
        ]);
    }

    private function getPurchaseConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'product' => [
                new Assert\NotBlank(),
                new Assert\Type('integer'),
                new Assert\GreaterThanOrEqual([
                    'value' => 0,
                    'message' => 'The value must be a non-negative number.',
                ]),
            ],
            'taxNumber' => [
                new Assert\NotBlank(),
                new Assert\Length(
                    min: 11,
                    max: 13,
                    minMessage: 'Ваше имя должно быть хотя бы {{ limit }} символов в длину',
                    maxMessage: 'Ваше имя не может быть больше {{ limit }} символов в длину',
                ),
                new Assert\Regex([
                    'pattern' => $this->getTaxNumberRegex(),
                    'message' => 'Invalid tax number format.',
                ]),
            ],
            'couponCode' => [
                new Assert\NotBlank(),
                new Assert\Length(
                    min: 3,
                    max: 8,
                    minMessage: 'Ваше имя должно быть хотя бы {{ limit }} символов в длину',
                    maxMessage: 'Ваше имя не может быть больше {{ limit }} символов в длину',
                ),
            ],
            'paymentProcessor' => new Assert\NotBlank(),
        ]);
    }

    private function createValidationErrorResponse($violations): JsonResponse
    {
        $errors = [];
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }
        return new JsonResponse(['errors' => $errors], 400);
    }

    private function getTaxNumberRegex(): string
    {
        return '/^(DE|IT|GR|FR\D{2})\w{9,11}/';
    }


}

