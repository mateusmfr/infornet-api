# Task Management API

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.4-blue?style=flat&logo=php)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=flat&logo=docker)
![Tests](https://img.shields.io/badge/Tests-14%20passed-success?style=flat)

A RESTful API built with Laravel 12 and PHP 8.4, featuring a complete Task CRUD with Repository and Service patterns, Docker environment, and comprehensive test coverage.

## 📋 Table of Contents

- [Features](#-features)
- [Architecture](#-architecture)
- [Technologies](#-technologies)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Available Commands](#-available-commands)
- [API Endpoints](#-api-endpoints)
- [Testing](#-testing)
- [Project Structure](#-project-structure)

## ✨ Features

- ✅ Complete Task CRUD (Create, Read, Update, Delete)
- ✅ Repository and Service pattern architecture
- ✅ Request validation with Form Requests
- ✅ API Resources for standardized JSON responses
- ✅ Pagination support (10 items per page)
- ✅ Docker environment with MySQL 8.0
- ✅ One-command setup with Makefile
- ✅ Comprehensive feature tests (14 tests, 99 assertions)
- ✅ ISO8601 timestamp formatting

## 🏗 Architecture

This project follows **clean architecture** principles with separation of concerns:

```
┌─────────────┐
│  Controller │  ← HTTP Layer (validation, responses)
└──────┬──────┘
       │
┌──────▼──────┐
│   Service   │  ← Business Logic Layer
└──────┬──────┘
       │
┌──────▼──────┐
│ Repository  │  ← Data Access Layer
└──────┬──────┘
       │
┌──────▼──────┐
│    Model    │  ← Eloquent ORM
└─────────────┘
```

**Key Components:**

- **BaseRepositoryInterface**: Generic CRUD operations for any model
- **TaskRepositoryInterface**: Extends base with pagination
- **TaskRepository**: Eloquent implementation
- **TaskService**: Business logic with error handling
- **TaskController**: RESTful endpoints
- **ApiResponse Trait**: Standardized JSON responses

## 🛠 Technologies

- **Framework**: Laravel 12.47.0
- **PHP**: 8.4-cli
- **Database**: MySQL 8.0
- **Containerization**: Docker & Docker Compose
- **Web Server**: PHP built-in server
- **Testing**: PHPUnit
- **Automation**: Makefile

## 📦 Requirements

- Docker and Docker Compose
- Make (optional, for convenience commands)
- Git

## 🚀 Installation

### Quick Start (Recommended)

```bash
# Clone the repository
git clone https://github.com/mateusmfr/infornet-api.git
cd infornet-api

# One-command setup (creates .env, installs dependencies, runs migrations)
make setup

# (Optional) Seed database with 20 sample tasks
make seed
```

The API will be available at `http://localhost:8000`

### Manual Setup

```bash
# Copy environment file
cp .env.example .env

# Start Docker containers
docker-compose up -d

# Install dependencies
docker-compose exec app composer install

# Generate application key
docker-compose exec app php artisan key:generate

# Run migrations
docker-compose exec app php artisan migrate

# (Optional) Seed database
docker-compose exec app php artisan db:seed
```

## 🎯 Available Commands

```bash
make setup        # Complete environment setup
make up           # Start containers
make down         # Stop containers
make restart      # Restart containers
make logs         # View container logs
make migrate      # Run migrations
make seed         # Populate database with sample data
make test         # Run test suite
make clean        # Clean environment (removes volumes and cache)
```

## 📡 API Endpoints

**Base URL**: `http://localhost:8000/api`

### List Tasks (Paginated)

```bash
GET /tasks
```

**Response:**
```json
{
  "success": true,
  "message": "Tasks retrieved successfully",
  "data": {
    "data": [
      {
        "id": 1,
        "title": "Setup Laravel project",
        "description": "Initialize Laravel with Docker",
        "completed": true,
        "created_at": "2026-01-17T12:00:00.000Z",
        "updated_at": "2026-01-17T12:00:00.000Z"
      }
    ],
    "links": { ... },
    "meta": {
      "current_page": 1,
      "last_page": 2,
      "per_page": 10,
      "total": 20
    }
  }
}
```

### Create Task

```bash
POST /tasks
Content-Type: application/json

{
  "title": "New task",
  "description": "Task description",
  "completed": false
}
```

**Validation Rules:**
- `title`: required, string, max 255 characters
- `description`: optional, string
- `completed`: optional, boolean

**Response (201):**
```json
{
  "success": true,
  "message": "Task created successfully",
  "data": {
    "id": 21,
    "title": "New task",
    "description": "Task description",
    "completed": false,
    "created_at": "2026-01-17T12:00:00.000Z",
    "updated_at": "2026-01-17T12:00:00.000Z"
  }
}
```

### Get Task by ID

```bash
GET /tasks/{id}
```

**Response (200):**
```json
{
  "success": true,
  "message": "Task retrieved successfully",
  "data": {
    "id": 1,
    "title": "Setup Laravel project",
    "description": "Initialize Laravel with Docker",
    "completed": true,
    "created_at": "2026-01-17T12:00:00.000Z",
    "updated_at": "2026-01-17T12:00:00.000Z"
  }
}
```

**Response (404):**
```json
{
  "message": "No query results for model [App\\Models\\Task] 1"
}
```

### Update Task

```bash
PUT /tasks/{id}
Content-Type: application/json

{
  "title": "Updated title",
  "description": "Updated description",
  "completed": true
}
```

**Note:** All fields are optional (partial update supported)

**Response (200):**
```json
{
  "success": true,
  "message": "Task updated successfully",
  "data": {
    "id": 1,
    "title": "Updated title",
    "description": "Updated description",
    "completed": true,
    "created_at": "2026-01-17T12:00:00.000Z",
    "updated_at": "2026-01-17T12:30:00.000Z"
  }
}
```

### Delete Task

```bash
DELETE /tasks/{id}
```

**Response (204):** No Content

### cURL Examples

```bash
# List all tasks
curl http://localhost:8000/api/tasks

# Create a task
curl -X POST http://localhost:8000/api/tasks \
  -H "Content-Type: application/json" \
  -d '{"title":"Test Task","description":"Testing API","completed":false}'

# Get task by ID
curl http://localhost:8000/api/tasks/1

# Update task
curl -X PUT http://localhost:8000/api/tasks/1 \
  -H "Content-Type: application/json" \
  -d '{"completed":true}'

# Delete task
curl -X DELETE http://localhost:8000/api/tasks/1
```

## 🧪 Testing

Run the complete test suite:

```bash
make test
```

**Test Coverage:**
- ✅ List tasks with pagination
- ✅ Create task with valid data
- ✅ Validation errors (title required, max length, boolean type)
- ✅ Show task by ID
- ✅ 404 responses for non-existent tasks
- ✅ Update task (full and partial)
- ✅ Delete task
- **Total:** 14 tests, 99 assertions

## 📁 Project Structure

```
infornet-api/
├── app/
│   ├── Contracts/
│   │   ├── BaseRepositoryInterface.php
│   │   └── TaskRepositoryInterface.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── TaskController.php
│   │   ├── Requests/
│   │   │   ├── StoreTaskRequest.php
│   │   │   └── UpdateTaskRequest.php
│   │   ├── Resources/
│   │   │   └── TaskResource.php
│   │   └── Traits/
│   │       └── ApiResponse.php
│   ├── Models/
│   │   └── Task.php
│   ├── Repositories/
│   │   └── TaskRepository.php
│   └── Services/
│       └── TaskService.php
├── database/
│   ├── migrations/
│   │   └── 2026_01_16_233153_create_tasks_table.php
│   └── seeders/
│       └── TaskSeeder.php
├── routes/
│   └── api.php
├── tests/
│   └── Feature/
│       └── TaskControllerTest.php
├── docker-compose.yml
├── Dockerfile
├── Makefile
└── Procfile
```
