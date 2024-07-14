<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ShippingMethod;
use App\Entity\Customer;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create a Location
        $location = new Location();
        $location->setName('Remote Area');
        $location->setOutsideMajorCity(true);
        $manager->persist($location);

        // Create a Customer
        $customer = new Customer();
        $customer->setName('John Doe');
        $customer->setLocation($location);
        $manager->persist($customer);

        // Create Shipping Method
        $shippingMethod = new ShippingMethod();
        $shippingMethod->setName('Standard Shipping');
        $shippingMethod->setDeliveryTime(3);
        $manager->persist($shippingMethod);

        // Create Products
        $product1 = new Product();
        $product1->setName('Product 1');
        $product1->setInStock(true);
        $product1->setLeadTime(0);
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName('Product 2');
        $product2->setInStock(false);
        $product2->setLeadTime(5);
        $manager->persist($product2);

        // Create an Order
        $order = new Order();
        $order->addProduct($product1);
        $order->addProduct($product2);
        $order->setShippingMethod($shippingMethod);
        $order->setCustomer($customer);
        $manager->persist($order);

        $manager->flush();
    }
}
