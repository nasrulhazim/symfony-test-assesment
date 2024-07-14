<?php

namespace App\Controller;

use App\Entity\Order;
use App\Processors\Logistic\DeliveryTimeEstimator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogisticController extends AbstractController
{
    /**
     * @Route("/order/{id}/delivery-time", name="order_delivery_time")
     */
    public function deliveryTime(Order $order, DeliveryTimeEstimator $estimator): Response
    {
        $deliveryTime = $estimator->calculateDeliveryTime($order);

        return new Response("Estimated delivery time: $deliveryTime business days");
    }
}
