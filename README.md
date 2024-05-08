# ALPS (Automated Logistics and Procurement System) Readme

## Introduction
Automated Logistics and Procurement System is a web-based application designed to streamline the logistics and procurement processes within an organization. It provides a centralized platform for managing internal requisition orders, inventory availability, deliveries, and backorders. The system is developed using PHP, MySQL, and AJAX technologies.

## Features
- User Roles: ALPS supports five user roles: Admin, Project Manager (PM), CEO, Driver, and Store Manager (SM).
- Internal Requisition Orders: PMs can create internal requisition orders for required items.
- CEO Approval: The CEO reviews and approves the internal requisition orders.
- Inventory Management: SMs manage the availability of products in the store.
- Delivery Process: SMs create delivery notes for approved orders, which are then delivered by the driver to the PM.
- Goods Received Notes: PMs create good received notes upon receiving the delivered goods.
- Backorders: Items not delivered are backordered by the SM and require CEO approval.

## Technologies Used
- PHP: The server-side scripting language used for building the application's logic.
- MySQL: The relational database management system for storing and retrieving data.
- AJAX: Asynchronous JavaScript and XML is used to facilitate real-time data exchange between the client and server.

## Installation
To install ALPS on your system, please follow these steps:

1. Clone the ALPS repository to your local machine.
```
git clone https://github.com/Zanadigm/ALPS.git
```

2. Configure the database settings by updating the `config.php` file with your MySQL database credentials.
```php
// config.php

define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_username');
define('DB_PASSWORD', 'your_password');
```

3. Import the database schema by executing the SQL script provided in `purchase_order_db.sql` file.

4. Ensure that you have a compatible web server environment (e.g., Apache) with PHP support installed.

5. Launch the application by accessing the appropriate URL in your web browser.

## Usage
1. Upon launching the application, the admin can create user accounts for PM, CEO, Driver, and SM.
2. PMs can log in and create internal requisition orders for the required items.
3. The CEO can review and approve the internal requisition orders.
4. SMs manage the availability of products in the store and create delivery notes for approved orders.
5. Drivers deliver the goods along with the delivery notes to the PM.
6. PMs receive the goods and create good received notes.
7. If any items are not delivered, the SM can backorder them for CEO approval.

## Support
If you encounter any issues or have any questions or suggestions regarding ALPS, please feel free to contact our support team at support@alps.com.

## License
ALPS is open-source software released under the [MIT License](https://opensource.org/licenses/MIT). See the [LICENSE](https://github.com/your-username/ALPS/blob/main/LICENSE) file for more information.

## Acknowledgements
We would like to express our gratitude to the developers and contributors of the libraries, frameworks, and resources used in this project. Their hard work and dedication make projects like ALPS possible.
