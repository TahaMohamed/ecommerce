# Ecommerce App

Laravel API e-commerce project to achieve these requirements:
- Visitors can register/login either as merchants or end consumers.
- Merchants can set their store name.
- Merchants can decide if the VAT is included in the products price or should be calculated
from the products price.
- (optional) Merchants can set shipping cost
- Merchants can set VAT percentage in case the VAT isn’t included in the product’s price.
- Merchants can add products with multilingual names and descriptions and prices.
- Merchants can end-consumers to add products to their carts.
- Calculate the cart’s total considering these subtotals:
    - Cart’s products prices.
    - Store VAT settings.
    - (optional) Store shipping cost.


## Installation

1. Clone the repo and `cd` into it
1. `composer install`
1. Rename or copy `.env.example` file to `.env`
1. `php artisan key:generate`
1. Set your database credentials in your `.env`
1. `php artisan migrate`
1. `php artisan serve`
1. Use this postman collection for run api services 
    https://documenter.getpostman.com/view/6784299/VUjLLSxJ

## Tesing
- Run `php artisan test --filter test_merchant_add_product`.