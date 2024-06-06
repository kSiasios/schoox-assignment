# RESTful CRUD API for Courses

This project is a simple RESTful API for managing courses. It is built using plain PHP and MySQL, 
as well as Next.js and MongoDB. The API supports all CRUD operations (Create, Read, Update, Delete) for the Course resource.

I took the liberty of introducing *"Deleted"* as a value of status.
This decision was made because it felt right to implement a 'soft delete' for the core entity,
and even though the use of the property `deleted_at` was not clearly specified, it made sense to use it that way.
The property `deleted_at` is originaly undefined and gets a value when a `PUT` is sent its value set to *"Deleted"*.

## Table of Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [API Endpoints](#api-endpoints)
- [Input Validation](#input-validation)

## Requirements

### For the PHP & MySQL Implementation 
*XAMPP was used during this*
- PHP 7.0 or higher
- MySQL 5.6 or higher
- Apache server

### For the Next.js & MongoDB Implementation 
- Next.js 14 or higher
- MongoDB & Mongoose

## Installation for PHP & MySQL Implementation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/kSiasios/schoox-assignment.git
   cd schoox-assignment
   ```
2. **Set up the database:**

   Execute the provided script to create the migrations table:
   ```bash
   cd Implementations/php
   php migrations/create_migrations_table.php
   ```
   
   Execute the provided script to run the migrations:
   ```bash
   php migrations/migrate.php
   ```
3. **Configure database connection:**

   Update the database configuration in `includes/dbh.inc.php`:
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "schoox";
   ```
4. **Start the server:**

   Place the php folder your web server's root directory and navigate to it via your browser or use tools like Postman to interact with the API.

## Installation for Next.js & MongoDB Implementation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/kSiasios/schoox-assignment.git
   cd schoox-assignment
   ```
2. **Set up the database:**

   Install dependencies:
   ```bash
   cd Implementations/nextjs
   npm install # or yarn install
   ```

3. **Configure database connection:**

   Create a '.env' file in the root of the Next.js project:
   ```bash
   MONGODB_URI=YOUR_MONGO_DB_URI
   ```
4. **Start the server:**

   Run
   ```bash
   npm run dev
   ```
   to start the server and navigate to it via your browser or use tools like Postman to interact with the API.

## API Endpoints

The following endpoints are available:

- GET /courses - Retrieve all courses
- GET /courses/{id} - Retrieve a specific course by ID
- POST /courses - Create a new course
- PUT /courses/{id} - Update an existing course by ID
- DELETE /courses/{id} - Delete a course by ID

### Example Requests 

*In case you are testing the Next.js implementation, replace `http://localhost/schoox/` with `http://localhost:3000/api/`*

- GET /courses
```bash
curl -X GET http://localhost/schoox/courses
```
- POST /courses 
```bash 
curl -X PUT http://localhost/schoox/courses/1 -d '{
  "title": "Updated Course",
  "description": "Updated Description",
  "status": "Pending",
  "is_premium": false
}'
``` 
- PUT /courses/{id}
```bash
curl -X PUT http://localhost/schoox/courses/1 -d '{
  "title": "Updated Course",
  "description": "Updated Description",
  "status": "Pending",
  "is_premium": false
}'
```
- DELETE /courses/{id}
```bash
  curl -X DELETE http://localhost/schoox/courses/1
```

## Input Validation

External inputs are validated to ensure data integrity. The following rules are applied:

- 'title' - Required, must be a string
- 'description' - Required, must be a string
- 'status' - Required, must be Published, Pending or Deleted
- 'is_premium' - Required, must be a boolean
