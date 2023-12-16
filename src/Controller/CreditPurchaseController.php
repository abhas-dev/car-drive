<?php

namespace App\Controller;

use App\Payment\PaymentMethodRegistry;
use App\Payment\PaypalHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreditPurchaseController extends AbstractController
{
    public function __construct(
        private readonly PaymentMethodRegistry $registry,
    )
    {}

    #[Route('/purchase', name: 'app_credit_purchase')]
    public function purchase(Request $request): Response
    {
        $paymentMethod = $request->get('payment_method');
        $paymentMethod = 'stripe';
        $this->registry->payWith(strtolower($paymentMethod));

        return $this->render('credit_purchase/index.html.twig', [
            'controller_name' => 'CreditPurchaseController',
        ]);
    }
}
