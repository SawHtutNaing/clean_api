# Laravel Senior Developer Coding Test - Complete Solution

## Overview
This solution implements a production-ready RESTful API with authentication, CRUD operations, database optimization, and a reporting dashboard.

## Features Implemented

### 1. API Development (Challenge 1) ✅
- ✅ RESTful API for Products and Orders
- ✅ Full CRUD operations
- ✅ Form Request validation with custom rules
- ✅ Pagination, Filtering, and Sorting
- ✅ API Resources (transformers)
- ✅ Custom Exception Handler
- ✅ Laravel Sanctum authentication

### 2. Database & Eloquent Performance (Challenge 2) ✅
- ✅ 4 related tables: Users, Orders, OrderItems, Products
- ✅ Efficient queries for sales by date range
- ✅ Top selling products query
- ✅ N+1 problem fixes with eager loading
- ✅ Lazy vs Eager loading examples

### 3. Mini Reporting Dashboard (Challenge 3) ✅
- ✅ Analytics endpoint with comprehensive data
- ✅ Total sales calculation
- ✅ Monthly chart data with groupBy
- ✅ Daily breakdown
- ✅ Redis/File caching implementation

---

## Installation & Setup

```bash
# Install dependencies
composer install

# Configure environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Install Sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Cache configuration
php artisan config:cache
```

---

## API Endpoints

### Authentication
```
POST   /api/register
POST   /api/login
POST   /api/logout
GET    /api/user
POST   /api/refresh
```

### Products
```
GET    /api/products              # List with pagination/filtering
GET    /api/products/{id}         # Show single product
POST   /api/products              # Create product
PUT    /api/products/{id}         # Update product
DELETE /api/products/{id}         # Delete product
```

### Orders
```
GET    /api/orders                # List with pagination/filtering
GET    /api/orders/{id}           # Show single order
POST   /api/orders                # Create order
PUT    /api/orders/{id}           # Update order
DELETE /api/orders/{id}           # Delete order
```

### Analytics
```
GET    /api/analytics/dashboard   # Get comprehensive analytics
POST   /api/analytics/clear-cache # Clear analytics cache
```

---

## API Usage Examples

### 1. Register & Login

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
    "email": "john@example.com",
    "password": "password123"
  }'
```

### 2. Create Product

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

### 3. List Products with Filtering & Sorting

```bash
# With pagination
curl "http://localhost:8000/api/products?per_page=10&page=1" \
  -H "Authorization: Bearer YOUR_TOKEN"

# With filtering
curl "http://localhost:8000/api/products?is_active=1&min_price=100&max_price=1000" \
  -H "Authorization: Bearer YOUR_TOKEN"

# With sorting
curl "http://localhost:8000/api/products?sort_by=price&sort_order=desc" \
  -H "Authorization: Bearer YOUR_TOKEN"

# Combined
curl "http://localhost:8000/api/products?is_active=1&min_price=100&sort_by=price&sort_order=asc&per_page=20" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### 4. Create Order

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

### 5. Get Analytics Dashboard

```bash
# Get dashboard data
curl "http://localhost:8000/api/analytics/dashboard" \
  -H "Authorization: Bearer YOUR_TOKEN"

# With date range
curl "http://localhost:8000/api/analytics/dashboard?start_date=2024-01-01&end_date=2024-12-31" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## Query Optimization Examples

### N+1 Problem Fix

```php
// ❌ BAD - N+1 Problem (1 + N + N*M queries)
$orders = Order::all();
foreach ($orders as $order) {
    foreach ($order->items as $item) {
        echo $item->product->name;
    }
}

// ✅ GOOD - Eager Loading (3 queries total)
$orders = Order::with(['items.product'])->get();
foreach ($orders as $order) {
    foreach ($order->items as $item) {
        echo $item->product->name; // No additional query
    }
}
```

### Efficient Date Range Queries

```php
// Sales by date range with groupBy
$sales = Order::completed()
    ->whereBetween('created_at', [$startDate, $endDate])
    ->select(
        DB::raw('DATE(created_at) as date'),
        DB::raw('SUM(total_amount) as total_sales'),
        DB::raw('COUNT(*) as order_count')
    )
    ->groupBy('date')
    ->get();
```

---

## Validation Rules

### Product Validation
- `name`: required, string, max 255 characters
- `description`: optional, string
- `price`: required, numeric, min 0
- `stock`: required, integer, min 0
- `is_active`: boolean

### Order Validation
- `items`: required, array, min 1 item
- `items.*.product_id`: required, must exist in products table
- `items.*.quantity`: required, integer, min 1
- `discount_amount`: optional, numeric, min 0

---

## Performance Features

1. **Eager Loading**: Prevents N+1 queries
2. **Database Indexes**: On frequently queried columns
3. **Query Caching**: Analytics data cached for 1 hour
4. **Efficient Queries**: Uses Query Builder with joins and groupBy
5. **Pagination**: All list endpoints support pagination
6. **Soft Deletes**: Data preservation with soft deletes

---

## Error Handling

All API responses follow consistent format:

```json
{
  "error": "Error type",
  "message": "Human-readable message",
  "errors": {} // For validation errors
}
```

HTTP Status Codes:
- `200`: Success
- `201`: Created
- `401`: Unauthorized
- `404`: Not Found
- `422`: Validation Error
- `500`: Server Error

---

## Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter OrderApiTest

# With coverage
php artisan test --coverage
```

---

## Cache Management

```bash
# Clear all cache
php artisan cache:clear

# Clear analytics cache via API
curl -X POST http://localhost:8000/api/analytics/clear-cache \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## Database Schema

```
users
├── id
├── name
├── email
├── password
└── timestamps

products
├── id
├── name
├── description
├── price
├── stock
├── is_active
└── timestamps

orders
├── id
├── user_id (FK)
├── order_number
├── total_amount
├── tax_amount
├── discount_amount
├── status
├── completed_at
└── timestamps

order_items
├── id
├── order_id (FK)
├── product_id (FK)
├── quantity
├── unit_price
├── subtotal
└── timestamps
```

---

## Key Design Decisions

1. **Sanctum over JWT**: Simpler, Laravel-native, secure
2. **API Resources**: Clean separation of data transformation
3. **Form Requests**: Centralized validation logic
4. **Repository Pattern**: Not used to keep code simple (can be added if needed)
5. **Service Layer**: Query optimization service for complex queries
6. **Caching Strategy**: 1-hour cache with manual clear option

---

## Production Checklist

- [ ] Set `APP_DEBUG=false` in production
- [ ] Configure Redis for caching
- [ ] Set up queue workers for background jobs
- [ ] Enable API rate limiting
- [ ] Configure CORS properly
- [ ] Set up monitoring and logging
- [ ] Add API versioning
- [ ] Implement comprehensive tests
- [ ] Set up CI/CD pipeline
- [ ] Document all endpoints with OpenAPI/Swagger

---

## License
This is a coding test solution for Solution Hub Myanmar ;
# clean_api
