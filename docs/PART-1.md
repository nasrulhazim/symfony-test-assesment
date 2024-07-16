# Part 1 - Coding Challenge

Author: [Nasrul Hazim](https://github.com/nasrulhazim)

**Scenario**
Our in-house operating system manages orders for our e-commerce platform. We need a new feature to calculate and display the estimated delivery time for each order based on various factors.

**Task**
Develop a PHP function using the Symphony Framework that takes an Order object as input and returns an estimated delivery time string (e.g., "Delivery in 2-3 business days"). The function should consider the following factors:

- [ ] **Product availability** Check if all products in the order are in stock. If not, the estimated delivery time should be based on the longest lead time of any backordered item.
- [ ] **Shipping method** Different shipping methods have different delivery timeframes. Access the chosen shipping method data from the Order object.
- [ ] **Customer location** The delivery time may vary depending on the customer's location. You can assume a simple logic for this challenge (e.g., +1 day for areas outside major cities).

## Setting up

Install Symfony installer:

```bash
curl -sS https://get.symfony.com/cli/installer | bash
```

Set the following in `~/.zsrch`:

```plaintext
export PATH="$HOME/.symfony5/bin:$PATH"
```

Create new Symfony project:

```bash
symfony new e-commerce --webapp
```

Set `.env`:

```plaintext
DATABASE_URL="mysql://root:@127.0.0.1:3306/test?serverVersion=8.0.32&charset=utf8mb4"
```

THen create the database:

```bash
php bin/console doctrine:database:create
```

Create the relevant entities:

```bash
php bin/console make:entity Order
php bin/console make:entity Product
php bin/console make:entity ShippingMethod
php bin/console make:entity Customer
```

Then setup the processor for delivery time estimator in `src/Processors/Logistic`.

Add a route to display delivery time estimation - `src/Controller/LogisticController.php` - `/order/{id}/delivery-time`

Now, set sample data with Doctrine Fixtures:

```bash
# install the package
composer require --dev orm-fixtures

# create the order fixtures
php bin/console make:fixture OrderFixtures
```

Setup the fixture accordingly.

Then run:

```bash
symfony serve
```

Then visit the browser at URL: <http://127.0.0.1:8000/order/1/delivery-time>

You should get the following output:

```json
{
    "delivery_time": "Estimated delivery time: 8 business days",
    "shipping_method": "Shipping method used: Standard Shipping",
    "customer_location": "Customer location: Remote Area",
    "order_details": [
        {
            "name": "Product 1",
            "in_stock": true,
            "lead_time": 0
        },
        {
            "name": "Product 2",
            "in_stock": false,
            "lead_time": 5
        }
    ]
}
```
