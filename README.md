# Laravel E-Commerce API - Senior Developer Coding Test

A production-ready RESTful API built with Laravel 12, featuring complete e-commerce functionality including orders, products, transactions, and comprehensive analytics dashboard.

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [API Documentation](#api-documentation)
- [Authentication](#authentication)
- [Testing](#testing)
- [Performance Optimization](#performance-optimization)
- [Project Structure](#project-structure)
- [Contributing](#contributing)

---

## ✨ Features

### Core Functionality
- ✅ **RESTful API** for Products, Orders, and Transactions
- ✅ **Full CRUD Operations** with validation
- ✅ **Authentication** using Laravel Sanctum (token-based)
- ✅ **Pagination, Filtering & Sorting** on all list endpoints
- ✅ **API Resources** for clean data transformation
- ✅ **Exception Handling** with consistent error responses
- ✅ **Transaction Processing** (payments, refunds, partial payments)
- ✅ **Analytics Dashboard** with caching

### Advanced Features
- ✅ **Query Optimization** with N+1 prevention
- ✅ **Eager Loading** for efficient database queries
- ✅ **Database Caching** (Redis/File support)
- ✅ **Soft Deletes** for data preservation
- ✅ **Database Indexes** for performance
- ✅ **Comprehensive Validation** with Form Requests
- ✅ **Realistic Demo Data** with seeders

---

## 🛠 Tech Stack

- **Framework:** Laravel 12
- **PHP:** 8.2+
- **Database:** MySQL 8.0+ 
- **Authentication:** Laravel Sanctum
- **Caching:** database
- **API:** RESTful JSON API
- **Testing:** PHPUnit

---

## 📦 System Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0 or PostgreSQL >= 14
- Node.js & NPM (for frontend, if needed)

---

## 🚀 Installation

### 1. Clone the Repository

```bash
mkdir laravel-ecommerce-api
git clone <repository-url> .
cd laravel-ecommerce-api
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_api
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Configure Cache (Optional)

For Redis caching:

```env
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

For file caching (default):

```env
CACHE_DRIVER=file
```

---

## 💾 Database Setup

### Run Migrations

```bash
php artisan migrate
```

### Seed Demo Data

```bash
# Seed all data (recommended for demo)
php artisan db:seed

# Or fresh migration with seeding
php artisan migrate:fresh --seed
```

**Demo Data Includes:**
- 6 Users (including test@example.com / password)
- 20 Products with stock
- ~18 Orders with items
- ~24-27 Transactions (various scenarios)

### Database Schema

```
users
├── id, name, email, password
├── timestamps

products
├── id, name, description, price, stock, is_active
├── timestamps, soft_deletes

orders
├── id, user_id, order_number
├── total_amount, tax_amount, discount_amount
├── status, completed_at
├── timestamps, soft_deletes

order_items
├── id, order_id, product_id
├── quantity, unit_price, subtotal
├── timestamps

transactions
├── id, order_id, user_id, transaction_number
├── amount, type, payment_method, status
├── payment_gateway, gateway_transaction_id
├── processed_at, failed_at, refunded_at
├── timestamps, soft_deletes
```

---

## 📚 API Documentation

### Base URL

```
http://localhost:8000/api
```

### Authentication Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/register` | Register new user | No |
| POST | `/login` | Login user | No |
| POST | `/logout` | Logout user | Yes |
| GET | `/user` | Get authenticated user | Yes |
| POST | `/refresh` | Refresh token | Yes |

### Product Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/products` | List all products | Yes |
| GET | `/products/{id}` | Get single product | Yes |
| POST | `/products` | Create product | Yes |
| PUT | `/products/{id}` | Update product | Yes |
| DELETE | `/products/{id}` | Delete product | Yes |

### Order Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/orders` | List all orders | Yes |
| GET | `/orders/{id}` | Get single order | Yes |
| POST | `/orders` | Create order | Yes |
| PUT | `/orders/{id}` | Update order | Yes |
| DELETE | `/orders/{id}` | Delete order | Yes |

### Transaction Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/transactions` | List all transactions | Yes |
| GET | `/transactions/{id}` | Get single transaction | Yes |
| POST | `/transactions` | Create transaction | Yes |
| PUT | `/transactions/{id}` | Update transaction | Yes |
| DELETE | `/transactions/{id}` | Delete transaction | Yes |
| POST | `/transactions/{id}/process` | Process pending transaction | Yes |
| POST | `/transactions/{id}/fail` | Mark transaction as failed | Yes |
| POST | `/transactions/{id}/refund` | Refund transaction | Yes |
| GET | `/transactions-stats` | Get transaction statistics | Yes |

### Analytics Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/analytics/dashboard` | Get analytics data | Yes |
| POST | `/analytics/clear-cache` | Clear analytics cache | Yes |

---

## 🔐 Authentication

This API uses **Laravel Sanctum** for token-based authentication.

### Register & Login

```bash
# Register
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'

# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password"
  }'

# Response
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "Test User",
    "email": "test@example.com"
  },
  "access_token": "1|xxxxxxxxxxxxxxxxxxx",
  "token_type": "Bearer"
}
```

### Using the Token

Include the token in the `Authorization` header:

```bash
curl -X GET http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## 📖 API Usage Examples

### 1. Create Product

```bash
curl -X POST http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Laptop",
    "description": "High-performance laptop",
    "price": 999.99,
    "stock": 50,
    "is_active": true
  }'
```

### 2. List Products with Filters

```bash
# With pagination
GET /api/products?per_page=10&page=1

# With filtering
GET /api/products?is_active=1&min_price=100&max_price=1000

# With sorting
GET /api/products?sort_by=price&sort_order=desc

# Combined
GET /api/products?is_active=1&min_price=100&sort_by=price&sort_order=asc&per_page=20
```

### 3. Create Order

```bash
curl -X POST http://localhost:8000/api/orders \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "items": [
      {
        "product_id": 1,
        "quantity": 2
      },
      {
        "product_id": 2,
        "quantity": 1
      }
    ],
    "discount_amount": 10.00
  }'
```

### 4. Create Transaction (Payment)

```bash
curl -X POST http://localhost:8000/api/transactions \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "order_id": 1,
    "amount": 150.00,
    "type": "payment",
    "payment_method": "credit_card",
    "payment_gateway": "stripe"
  }'
```

### 5. Process Transaction

```bash
curl -X POST http://localhost:8000/api/transactions/1/process \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "gateway_transaction_id": "ch_3NqzW2LkdIwHu7ix0B5v0q9C",
    "gateway_response": "Payment successful"
  }'
```

### 6. Get Analytics Dashboard

```bash
# Default (last 30 days)
GET /api/analytics/dashboard

# Custom date range
GET /api/analytics/dashboard?start_date=2024-01-01&end_date=2024-12-31
```

**Response:**
```json
{
  "total_sales": 15750.50,
  "monthly_chart": [
    {
      "month": "2024-01",
      "total_sales": 5250.00,
      "order_count": 15,
      "avg_order_value": 350.00
    }
  ],
  "daily_breakdown": [
    {
      "date": "2024-01-15",
      "total_sales": 1250.00,
      "order_count": 5,
      "total_tax": 62.50,
      "total_discount": 125.00
    }
  ],
  "top_products": [
    {
      "product_id": 1,
      "product_name": "Laptop",
      "total_quantity": 25,
      "total_revenue": 7500.00,
      "order_count": 15
    }
  ],
  "summary": {
    "total_orders": 45,
    "avg_order_value": 350.00,
    "total_revenue": 15750.00,
    "total_tax_collected": 787.50,
    "total_discounts_given": 1575.00
  },
  "transaction_summary": {
    "total_transactions": 50,
    "completed_transactions": 42,
    "failed_transactions": 3,
    "total_payments": 16000.00,
    "total_refunds": 250.00,
    "success_rate": 84.00
  }
}
```

---

## 🧪 Testing

### Run All Tests

```bash
php artisan test
```

### Run Specific Test

```bash
php artisan test --filter OrderApiTest
```

### With Coverage

```bash
php artisan test --coverage
```

### Test Data

Use the seeded test user:
- **Email:** test@example.com
- **Password:** password

---

## ⚡ Performance Optimization

### 1. N+1 Problem Prevention

All controllers use **eager loading**:

```php
// OrderController
Order::with(['user', 'items.product'])->get();

// TransactionController
Transaction::with(['order', 'user'])->get();
```


### 2. Caching

Analytics data cached for 1 hour:

```php
Cache::remember('analytics_dashboard', 3600, function () {
    // Expensive queries
});
```

Clear cache manually:

```bash
# Via API
POST /api/analytics/clear-cache

# Via Artisan
php artisan cache:clear
```

### 3. Query Optimization

Using Query Builder with joins and groupBy:

```php
Order::select(
    DB::raw('DATE(created_at) as date'),
    DB::raw('SUM(total_amount) as total_sales'),
    DB::raw('COUNT(*) as order_count')
)
->groupBy('date')
->get();
```

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       ├── AuthController.php
│   │       ├── OrderController.php
│   │       ├── ProductController.php
│   │       ├── TransactionController.php
│   │       └── AnalyticsController.php
│   ├── Requests/
│   │   ├── StoreOrderRequest.php
│   │   ├── UpdateOrderRequest.php
│   │   ├── StoreProductRequest.php
│   │   ├── UpdateProductRequest.php
│   │   ├── StoreTransactionRequest.php
│   │   └── UpdateTransactionRequest.php
│   └── Resources/
│       ├── OrderResource.php
│       ├── ProductResource.php
│       └── TransactionResource.php
├── Models/
│   ├── User.php
│   ├── Product.php
│   ├── Order.php
│   ├── OrderItem.php
│   └── Transaction.php
└── Exceptions/
    └── Handler.php

database/
├── migrations/
│   ├── create_products_table.php
│   ├── create_orders_table.php
│   ├── create_order_items_table.php
│   └── create_transactions_table.php
├── seeders/
│   ├── DatabaseSeeder.php
│   ├── UserSeeder.php
│   ├── ProductSeeder.php
│   ├── OrderSeeder.php
│   └── TransactionSeeder.php
└── factories/
    ├── UserFactory.php
    ├── ProductFactory.php
    ├── OrderFactory.php
    └── TransactionFactory.php

routes/
└── api.php

tests/
└── Feature/
    ├── OrderApiTest.php
    └── AnalyticsApiTest.php
```

---

## 🔧 Configuration

### Cache Configuration

Edit `config/cache.php` or use `.env`:

```env
CACHE_DRIVER=redis  # or file, database, memcached
```

### Database Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_api
DB_USERNAME=root
DB_PASSWORD=
```

### Sanctum Configuration

```env
SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1
```

---

## 🐛 Error Handling

### Consistent Error Responses

All API errors return consistent JSON format:

```json
{
  "error": "Error type",
  "message": "Human-readable message",
  "errors": {
    "field": ["validation error"]
  }
}
```

### HTTP Status Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 201 | Created |
| 401 | Unauthorized |
| 404 | Not Found |
| 422 | Validation Error |
| 500 | Server Error |

---

## 📊 Key Features Demonstrated

### 1. RESTful API Design
✅ Resource-based URLs
✅ HTTP method semantics
✅ Consistent response format

### 2. Database Optimization
✅ Efficient queries with joins
✅ N+1 problem prevention
✅ Database indexes
✅ Query caching

### 3. Security
✅ Token-based authentication
✅ Request validation
✅ SQL injection prevention
✅ XSS protection

### 4. Code Quality
✅ PSR-12 coding standards
✅ Single Responsibility Principle
✅ DRY (Don't Repeat Yourself)
✅ Comprehensive error handling

---

## 🎯 Coding Test Completion Checklist

### Challenge 1: API Development ✅
- [x] RESTful API for Orders, Transactions, Products
- [x] Full CRUD operations
- [x] Validation rules (Form Requests)
- [x] Pagination + Filtering + Sorting
- [x] API Resources (transformers)
- [x] Error handling (Exception Handler)
- [x] Sanctum authentication

### Challenge 2: Database + Eloquent Performance ✅
- [x] 4 related tables with relationships
- [x] Sales by date range queries
- [x] Top selling products queries
- [x] Lazy vs eager loading examples
- [x] N+1 fixes implemented

### Challenge 3: Mini Reporting Dashboard ✅
- [x] Analytics endpoint
- [x] Total sales calculation
- [x] Monthly chart data
- [x] Daily breakdown
- [x] Query Builder + groupBy
- [x] Caching (Redis/File)

---

## 🚀 Running the Application

### Development Server

```bash
php artisan serve
```

Access at: `http://localhost:8000`



---

## 📝 License

This project is for demonstration purposes as part of a coding test.

---

## 👤 Author

Saw Htut naing - Coding Test Submission

---

## 🙏 Acknowledgments

- Laravel Framework
- Laravel Sanctum
- PHPUnit Testing Framework

---
