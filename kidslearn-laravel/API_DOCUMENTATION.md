# 📡 API Documentation - KidsLearn

Dokumentasi lengkap untuk API endpoints yang tersedia di aplikasi KidsLearn.

## Base URL

```
Development: http://localhost:8000
Production: https://kidslearn.com
```

## Authentication

Semua API endpoints yang memerlukan autentikasi menggunakan Laravel Session Authentication. Pastikan user sudah login terlebih dahulu.

### CSRF Token

Semua POST/PUT/DELETE requests memerlukan CSRF token yang dapat diambil dari meta tag:

```html
<meta name="csrf-token" content="{{ csrf_token() }}" />
```

---

## Authentication Endpoints

### 1. Login

**Endpoint:** `POST /login`

**Description:** Authenticate user dan create session

**Request Body:**

```json
{
    "name": "Budi",
    "password": "password123"
}
```

**Success Response (200):**

```json
{
    "success": true,
    "message": "🎉 Hore! Selamat datang Budi!",
    "redirect": "http://localhost:8000/dashboard"
}
```

**Error Response (401):**

```json
{
    "success": false,
    "message": "❌ Ups! Nama atau kata sandi salah"
}
```

**Validation Errors (422):**

```json
{
    "message": "The name field is required.",
    "errors": {
        "name": ["The name field is required."],
        "password": ["The password field is required."]
    }
}
```

---

### 2. Register

**Endpoint:** `POST /register`

**Description:** Create new user account

**Request Body:**

```json
{
    "name": "NewUser",
    "password": "password123",
    "password_confirmation": "password123",
    "avatar": "avatar1.png"
}
```

**Success Response (200):**

```json
{
    "success": true,
    "message": "🎉 Hore! Akun berhasil dibuat!",
    "redirect": "http://localhost:8000/login"
}
```

**Error Response (422):**

```json
{
    "message": "The name has already been taken.",
    "errors": {
        "name": ["The name has already been taken."]
    }
}
```

**Validation Rules:**

-   `name`: required, unique
-   `password`: required, min:6
-   `password_confirmation`: required, same:password
-   `avatar`: required

---

### 3. Logout

**Endpoint:** `POST /logout`

**Description:** Logout user dan destroy session

**Authentication:** Required

**Success Response:**
Redirect to login page

---

## Learning Endpoints

### 1. Get Learning Categories

**Endpoint:** `GET /learning`

**Description:** Display learning menu with all animal categories

**Authentication:** Required

**Response:** HTML page with categories:

-   Mammals
-   Birds
-   Sea Animals
-   Insects
-   Reptiles
-   Amphibians

---

### 2. Get Animals by Category

**Endpoint:** `GET /learning/{category}`

**Description:** Display animals in specific category with interactive learning interface

**Authentication:** Required

**Path Parameters:**

-   `category` (string): mammals | birds | sea | insects | reptils | amphibi

**Example:**

```
GET /learning/mammals
```

**Response:** HTML page with animal carousel

---

### 3. Get Animals Data (API)

**Endpoint:** `GET /api/animals/{category}`

**Description:** Get JSON data of animals in specific category

**Authentication:** Required

**Path Parameters:**

-   `category` (string): mammals | birds | sea | insects | reptils | amphibi

**Example Request:**

```
GET /api/animals/mammals
```

**Success Response (200):**

```json
{
    "success": true,
    "animals": [
        {
            "id": 1,
            "name": "Dog",
            "category": "mammals",
            "description": "has four legs, eats meat, vegetables, and fruits. Easy to play with, has a distinctive voice.",
            "image_path": "img/dog1.png",
            "sound_path": "sound/dog.mp3",
            "created_at": "2024-12-15T00:00:00.000000Z",
            "updated_at": "2024-12-15T00:00:00.000000Z"
        },
        {
            "id": 2,
            "name": "Elephant",
            "category": "mammals",
            "description": "has four legs, eats grass, leaves...",
            "image_path": "img/elephant.png",
            "sound_path": "sound/Elephant.mp3",
            "created_at": "2024-12-15T00:00:00.000000Z",
            "updated_at": "2024-12-15T00:00:00.000000Z"
        }
    ]
}
```

**Animal Object Properties:**
| Property | Type | Description |
|----------|------|-------------|
| id | integer | Unique animal ID |
| name | string | Animal name |
| category | string | Animal category |
| description | string | Animal description |
| image_path | string | Path to animal image |
| sound_path | string\|null | Path to animal sound (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Last update timestamp |

---

## Quiz Endpoints

### 1. Get Quiz Question

**Endpoint:** `GET /quiz`

**Description:** Get random quiz question from specific category

**Authentication:** Required

**Query Parameters:**

-   `category` (string, optional): mammals | birds | sea | insects | reptils | amphibi
    -   Default: mammals

**Example:**

```
GET /quiz?category=mammals
```

**Response:** HTML page with quiz question and options

---

### 2. Check Quiz Answer

**Endpoint:** `POST /quiz/check`

**Description:** Submit quiz answer and get result

**Authentication:** Required

**Request Body:**

```json
{
    "question_id": 1,
    "answer": "cat"
}
```

**Request Parameters:**
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| question_id | integer | Yes | ID of the quiz question |
| answer | string | Yes | User's answer |

**Success Response (Correct Answer) (200):**

```json
{
    "success": true,
    "result": "correct",
    "message": "🎉 Jawaban kamu BENAR! Ini adalah hewan mammals yaitu CAT.",
    "xp_gained": 10
}
```

**Success Response (Wrong Answer) (200):**

```json
{
    "success": true,
    "result": "wrong",
    "message": "❌ Jawaban kamu kurang tepat. Coba lagi ya! Jawaban yang benar adalah CAT."
}
```

**Validation Error (422):**

```json
{
    "message": "The question id field is required.",
    "errors": {
        "question_id": ["The question id field is required."],
        "answer": ["The answer field is required."]
    }
}
```

**Side Effects:**

-   Updates user's XP (if correct)
-   Updates user's level (if threshold reached)
-   Increments total_quizzes_completed
-   Increments correct_answers (if correct)

---

## Dashboard Endpoints

### 1. Get Dashboard

**Endpoint:** `GET /dashboard`

**Description:** Display user dashboard with progress information

**Authentication:** Required

**Response Data:**

-   User information (name, avatar)
-   Progress information (level, XP, accuracy)
-   Navigation to learning and games

---

## User Progress System

### Level & XP System

-   Initial level: 1
-   Initial XP: 0
-   XP per correct answer: 10
-   XP for level up: 100 (every 100 XP = 1 level)

### Progress Calculation

**Level Formula:**

```
Level = floor(XP / 100) + 1
```

**XP Progress in Current Level:**

```
Progress = XP % 100
```

**Accuracy Formula:**

```
Accuracy = (correct_answers / total_quizzes_completed) * 100
```

**Example:**

-   User has 250 XP
-   Level = floor(250 / 100) + 1 = 3
-   Progress in level 3 = 250 % 100 = 50 XP (50%)

---

## Error Responses

### Common Error Codes

| Code | Description                             |
| ---- | --------------------------------------- |
| 401  | Unauthorized - User not authenticated   |
| 403  | Forbidden - Access denied               |
| 404  | Not Found - Resource not found          |
| 422  | Unprocessable Entity - Validation error |
| 500  | Internal Server Error                   |

### Error Response Format

```json
{
    "message": "Error message",
    "errors": {
        "field_name": ["Error description"]
    }
}
```

---

## Rate Limiting

Currently, there is no rate limiting implemented. In production, consider implementing:

-   Login attempts: 5 per minute
-   Quiz submissions: 60 per minute
-   API calls: 120 per minute

---

## Testing with cURL

### Login Example

```bash
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -d '{
    "name": "Budi",
    "password": "password123"
  }'
```

### Get Animals Example

```bash
curl -X GET http://localhost:8000/api/animals/mammals \
  -H "Cookie: laravel_session=your-session-cookie"
```

### Check Quiz Answer Example

```bash
curl -X POST http://localhost:8000/quiz/check \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -H "Cookie: laravel_session=your-session-cookie" \
  -d '{
    "question_id": 1,
    "answer": "cat"
  }'
```

---

## Testing with Postman

### Setup

1. Import collection dari file `postman_collection.json` (jika ada)
2. Set base URL: `http://localhost:8000`
3. Get CSRF token dari HTML meta tag
4. Use session cookie from login response

### Example Workflow

1. **GET** `/login` - Get CSRF token from HTML
2. **POST** `/login` - Login with credentials
3. Save session cookie from response
4. **GET** `/api/animals/mammals` - Use session cookie
5. **POST** `/quiz/check` - Submit quiz answer

---

## WebSocket / Real-time Features

Currently not implemented. Future features may include:

-   Real-time leaderboard
-   Live quiz competitions
-   Notification system

---

## Versioning

Current API Version: **v1**

Future versions will be implemented as:

```
/api/v2/animals/{category}
```

---

## Support

For API support and questions:

-   Email: api@kidslearn.com
-   Documentation: https://docs.kidslearn.com/api
-   GitHub Issues: https://github.com/kidslearn/issues

---

**Last Updated:** December 15, 2025

**API Version:** 1.0.0
