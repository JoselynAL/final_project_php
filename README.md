# Car Listing API

This is a RESTful API for managing users and car listings. The API includes endpoints for user registration, login, logout, session verification, and car management (CRUD). It's built with PHP and MySQL and designed to run in an AMPPS environment.

## Authors

- Joselyn Yajaira Arias Lopez
- Changgwon Cho
- Ayumu Miyamoto

---

## Requirements

- AMPPS (Apache, MySQL, PHP environment)
- phpMyAdmin (included with AMPPS)
- PHP 7.4+
- MySQL

---

## Setup Instructions

1. **Clone or download** this project into the `www` directory in AMPPS.

2. **Create a MySQL database**:

   - Open `http://localhost/phpmyadmin`
   - Create a new database (e.g., `car_cms`)
   - Import any provided SQL schema if available

3. **Configure database settings** in `config/Database.php`:
   ```php
   private $host = "localhost";
   private $db_name = "car_cms";
   private $username = "root";
   private $password = "mysql"; // Default password in AMPPS
   ```

## API Endpoints

http://localhost/your_project/public/ +

### Authentication

#### `POST /api/register`

Register a new user.

**Request Body**:

```json
{
  "username": "exampleuser",
  "email": "user@example.com",
  "password": "securepassword",
  "role": "'admin' | 'seller' | 'customer'"
}
```

#### `POST /api/login`

Authenticate a user and start a session.

**Request Body**:

```json
{
  "username": "exampleuser",
  "password": "securepassword"
}
```

#### `POST /api/logout`

Logout and destroy session.

#### `GET /api/checkSession`

Check the current user session.

### Car Management

#### `GET /api/cars`

Get all car listings.

#### `GET /api/cars/{id}`

Role required: Public

Get a single car by ID.

#### `POST /api/cars`

Role required: `admin` or `seller`

Create a new car.

**Request Body**:

```json
{
  "brand": "Toyota",
  "model": "Corolla",
  "year": 2022,
  "price": 24000.5,
  "color": "White",
  "description": "Reliable sedan",
  "image": "image.jpg",
  "status": "in_stock"
}
```

#### `POST /api/cars/{id}`

Role required: `admin` or `seller`

Update an existing car.

**Request Body**:

```json
{
  "brand": "Toyota",
  "model": "Corolla",
  "year": 2022,
  "price": 24000.5,
  "color": "White",
  "description": "Reliable sedan",
  "image": "image.jpg",
  "status": "in_stock"
}
```

#### `DELETE /api/cars/{id}`

Role required: `admin`.

Delete a car by ID.

## Audit Log

Each create, update, and delete operation on cars is recorded in the `audit_logs` table for traceability.

## Project Directory Structure

```bash
.
├── README.md
├── car_images
├── config
├── controllers
│   ├── AuthController.php
│   ├── BaseController.php
│   ├── CarController.php
│   └── UserController.php
├── middlewares
│   ├── AuthMiddleware.php
│   └── RoleMiddleware.php
├── models
│   ├── Car.php
│   └── User.php
├── public
│   └── index.php
└── routes
    └── api.php
```
