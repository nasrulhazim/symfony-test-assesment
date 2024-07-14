<?php

namespace App\Controller;

use App\Entity\Order;
use App\Processors\Logistic\DeliveryTimeEstimator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogisticController extends AbstractController
{
    #[Route('/order/{id}/delivery-time', name: 'order_delivery_time')]
    public function deliveryTime(Order $order, DeliveryTimeEstimator $estimator): Response
    {
        $deliveryTime = $estimator->calculateDeliveryTime($order);
        $shippingMethod = $order->getShippingMethod()->getName();
        $customerLocation = $order->getCustomer()->getLocation()->getName();

        $orderDetails = [];
        foreach ($order->getProducts() as $product) {
            $orderDetails[] = [
                'name' => $product->getName(),
                'in_stock' => $product->isInStock(),
                'lead_time' => $product->getLeadTime(),
            ];
        }

        $responseContent = [
            'delivery_time' => "Estimated delivery time: $deliveryTime business days",
            'shipping_method' => "Shipping method used: $shippingMethod",
            'customer_location' => "Customer location: $customerLocation",
            'order_details' => $orderDetails,
        ];

        return new Response(json_encode($responseContent, JSON_PRETTY_PRINT));
    }
}
