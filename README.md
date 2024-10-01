# ClientInvoice-Manager-API

ClientInvoice-Manager-API is a Laravel-based API that provides a robust system for managing customers and their associated invoices. This API includes token-based authentication and authorization using **Laravel Sanctum** to ensure secure access and operation management. The API supports typical CRUD operations for both customers and invoices, as well as bulk operations for invoices.

## Features

- **Authentication & Authorization**: Secured with Laravel Sanctum, allowing only authorized users to access and modify resources.
- **Customers Management**:
  - List all customers with filtering and pagination options.
  - Create new customer records.
  - View customer details along with their related invoices.
  - Update and delete customer records.
- **Invoices Management**:
  - List all invoices with filtering and pagination options.
  - Create new invoices or bulk insert multiple invoices.
  - View, update, and delete individual invoices.
- **Token Permissions**: Operations are protected with abilities such as `view`, `create`, `update`, and `delete`.

## Prerequisites

- PHP >= 8.0
- Laravel >= 9.x
- Composer
- MySQL or any other database supported by Laravel
- Laravel Sanctum

## Installation

Follow these steps to get the project up and running:

1. **Clone the repository**:

    ```bash
    git clone https://github.com/your-username/ClientInvoice-Manager-API.git
    cd ClientInvoice-Manager-API
    ```

2. **Install dependencies**:

    ```bash
    composer install
    ```

3. **Copy the `.env` file**:

    ```bash
    cp .env.example .env
    ```

4. **Generate the application key**:

    ```bash
    php artisan key:generate
    ```

5. **Configure the database** in the `.env` file:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

6. **Run the migrations** to set up the database schema:

    ```bash
    php artisan migrate
    ```

7. **Install Laravel Sanctum**:

    ```bash
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    php artisan migrate
    ```

8. **Serve the application**:

    ```bash
    php artisan serve
    ```

## Authentication

This API uses **Laravel Sanctum** for authentication. Users need to be authenticated and have specific token abilities to access the endpoints.

### Token Abilities:
- `view`: Allows viewing customer and invoice details.
- `create`: Allows creating new customers and invoices.
- `update`: Allows updating existing customers and invoices.
- `delete`: Allows deleting customers and invoices.

## API Endpoints

### Customers

- `GET /v1/customers`: List all customers with optional filters.
- `POST /v1/customers`: Create a new customer (requires `create` ability).
- `GET /v1/customers/{id}`: View a specific customer’s details (requires `view` ability).
- `PUT /v1/customers/{id}`: Update customer information (requires `update` ability).
- `DELETE /v1/customers/{id}`: Delete a customer (requires `delete` ability).

### Invoices

- `GET /v1/invoices`: List all invoices with optional filters.
- `POST /v1/invoices`: Create a new invoice (requires `create` ability).
- `POST /v1/invoices/bulk`: Bulk insert multiple invoices (requires `create` ability).
- `GET /v1/invoices/{id}`: View a specific invoice’s details (requires `view` ability).
- `PUT /v1/invoices/{id}`: Update an invoice (requires `update` ability).
- `DELETE /v1/invoices/{id}`: Delete an invoice (requires `delete` ability).

## Running Tests

You can run the tests to ensure everything is working correctly:

```bash
php artisan test
