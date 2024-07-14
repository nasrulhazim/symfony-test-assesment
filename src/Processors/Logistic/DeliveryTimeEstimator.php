<?php

namespace App\Processors\Logistic;

use App\Entity\Order;

class DeliveryTimeEstimator
{
    public function calculateDeliveryTime(Order $order): int
    {
        $availabilityTime = $this->getProductAvailabilityTime($order);
        $shippingTime = $this->getShippingTime($order);
        $locationTime = $this->getLocationTime($order);

        return $availabilityTime + $shippingTime + $locationTime;
    }

    /**
     * Check if all products in the order are in stock.
     * If not, the estimated delivery time should be based on the longest lead time of any backordered item.
     */
    private function getProductAvailabilityTime(Order $order): int
    {
        $maxLeadTime = 0;
        foreach ($order->getProducts() as $product) {
            if (!$product->isInStock()) {
                $maxLeadTime = max($maxLeadTime, $product->getLeadTime());
            }
        }
        return $maxLeadTime;
    }

    /**
     * Different shipping methods have different delivery timeframes.
     * Access the chosen shipping method data from the Order object.
     */
    private function getShippingTime(Order $order): int
    {
        $shippingMethod = $order->getShippingMethod();
        return $shippingMethod->getDeliveryTime();
    }

    /**
     * The delivery time may vary depending on the customer's location.
     * For test purpose, we only add 1 day extra if outside major cities.
     */
    private function getLocationTime(Order $order): int
    {
        $customerLocation = $order->getCustomer()?->getLocation();

        if(! $customerLocation) {
            return 0;
        }

        return $customerLocation->isOutsideMajorCity() ? 1 : 0;
    }
}
