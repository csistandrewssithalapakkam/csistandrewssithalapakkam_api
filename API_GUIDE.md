# CSI St. Andrews Sithalapakkam API

## Overview
Full-featured REST API for CSI St. Andrews Church Sithalapakkam with JWT authentication, member management, events, verses, and gallery.

## Features
- **JWT Authentication**: Secure login/register with token-based auth
- **Member Management**: Access member profiles and church community
- **Daily Verses**: Get daily/weekly Bible verses in English and Tamil
- **Events Management**: Birthdays and wedding anniversaries tracking
- **Gallery**: Image folders and gallery management

## Setup

### Prerequisites
- PHP 8.0+
- Laravel 8.75+
- MySQL/MariaDB
- Composer

### Installation

1. **Install Dependencies**
```bash
composer install
```

2. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```

3. **Database**
```bash
# Import the provided SQL file
mysql -u root -p andrews_church_db < localhost.sql
```

4. **Generate Swagger Docs**
```bash
php artisan l5-swagger:generate
```

5. **Run Server**
```bash
# Option 1: PHP Built-in Server
php artisan serve

# Option 2: XAMPP (Access via http://localhost/csistandrewssithalapakkam_api/public)
```

## API Documentation

**Access Swagger UI**: `http://localhost:8000/api/documentation`

### Authentication Endpoints

#### Register User
```http
POST /api/auth/register
Content-Type: application/json

{
  "user_name": "John Doe",
  "user_email": "john@example.com",
  "user_password": "password123"
}

Response:
{
  "message": "User registered successfully",
  "user": {
    "user_id": 2,
    "user_name": "John Doe",
    "user_email": "john@example.com",
    "user_active": 1
  },
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc..."
}
```

#### Login
```http
POST /api/auth/login
Content-Type: application/json

{
  "user_email": "csistandrewssithalapakkam@gmail.com",
  "user_password": "password@100"
}

Response:
{
  "message": "Login successful",
  "token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "user_id": 1,
    "user_name": "andrews",
    "user_email": "csistandrewssithalapakkam@gmail.com",
    "user_active": 1
  }
}
```

#### Get User Profile (Protected)
```http
GET /api/auth/me
Authorization: Bearer {token}

Response:
{
  "user": { ... }
}
```

#### Logout (Protected)
```http
POST /api/auth/logout
Authorization: Bearer {token}

Response:
{
  "message": "Logout successful"
}
```

#### Refresh Token (Protected)
```http
POST /api/auth/refresh
Authorization: Bearer {token}

Response:
{
  "token": "new_token_here"
}
```

### Verse Endpoints

#### Get Today's Verse
```http
GET /api/verses/today

Response:
{
  "verse_id": 1,
  "week_date": "2025-11-30",
  "verse_tamil": "நான் உன்னை விட்டு விலகுவதும் இல்லை உன்னை கைவிடுவதுமில்லை",
  "verse_english": "I will never leave you nor forsake you",
  "verse_status": "1"
}
```

#### Get All Verses
```http
GET /api/verses
```

#### Get Verse by ID
```http
GET /api/verses/{id}
```

### Events Endpoints

#### Get Today's Birthdays
```http
GET /api/events/birthdays/today

Response:
[
  {
    "bd_id": 1,
    "bd_member_id": 1,
    "bd_date": "1962-11-04",
    "member": {
      "member_id": 1,
      "member_name": "Abraham",
      "member_email": "abraham@testemail.com"
    }
  }
]
```

#### Get Upcoming Birthdays (30 days)
```http
GET /api/events/birthdays/upcoming
```

#### Get All Birthdays
```http
GET /api/events/birthdays
```

#### Get Today's Anniversaries
```http
GET /api/events/anniversaries/today

Response:
[
  {
    "wa_id": 2,
    "wa_member_id_1": 3,
    "wa_member_id_2": 4,
    "wa_date": "2022-05-22",
    "member1": { ... },
    "member2": { ... }
  }
]
```

#### Get Upcoming Anniversaries (30 days)
```http
GET /api/events/anniversaries/upcoming
```

#### Get All Anniversaries
```http
GET /api/events/anniversaries
```

### Gallery Endpoints

#### Get All Image Folders
```http
GET /api/gallery/folders

Response:
[
  {
    "if_id": 1,
    "if_name": "Church Events",
    "if_status": "1",
    "images": [ ... ]
  }
]
```

#### Get All Gallery Images
```http
GET /api/gallery/images

# Optional: Filter by folder
GET /api/gallery/images?folder_id=1
```

#### Get Images by Folder
```http
GET /api/gallery/folder/{folder_id}

Response:
{
  "folder": {
    "if_id": 1,
    "if_name": "Church Events",
    "if_status": "1"
  },
  "images": [ ... ]
}
```

## Usage Examples

### Using cURL
```bash
# Register
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "user_name": "John",
    "user_email": "john@test.com",
    "user_password": "pass123"
  }'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "user_email": "john@test.com",
    "user_password": "pass123"
  }'

# Get today's verse
curl http://localhost:8000/api/verses/today

# Get today's birthdays
curl http://localhost:8000/api/events/birthdays/today

# Get gallery images (with token)
curl -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  http://localhost:8000/api/gallery/images
```

### Using JavaScript (Fetch)
```javascript
// Register
const register = async () => {
  const response = await fetch('http://localhost:8000/api/auth/register', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      user_name: 'John',
      user_email: 'john@test.com',
      user_password: 'pass123'
    })
  });
  return response.json();
};

// Login
const login = async () => {
  const response = await fetch('http://localhost:8000/api/auth/login', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      user_email: 'john@test.com',
      user_password: 'pass123'
    })
  });
  const data = await response.json();
  localStorage.setItem('token', data.token);
  return data;
};

// Get today's verse
const getVerseOfDay = async () => {
  const response = await fetch('http://localhost:8000/api/verses/today');
  return response.json();
};

// Get today's birthdays
const getTodayBirthdays = async () => {
  const response = await fetch('http://localhost:8000/api/events/birthdays/today');
  return response.json();
};

// Get gallery images with authentication
const getGallery = async () => {
  const token = localStorage.getItem('token');
  const response = await fetch('http://localhost:8000/api/gallery/images', {
    headers: { 'Authorization': `Bearer ${token}` }
  });
  return response.json();
};
```

## Error Handling

All endpoints return appropriate HTTP status codes:

- `200`: Success
- `201`: Created (registration)
- `400`: Bad Request
- `401`: Unauthorized (invalid/missing token)
- `404`: Not Found
- `422`: Validation Error
- `500`: Server Error

Example error response:
```json
{
  "message": "Invalid credentials",
  "errors": { ... }
}
```

## JWT Token Usage

Include token in the `Authorization` header for protected routes:

```
Authorization: Bearer {token}
```

Tokens expire based on configuration. Use the refresh endpoint to get a new token:

```http
POST /api/auth/refresh
Authorization: Bearer {old_token}
```

## Database Schema

- `tbl_user`: User accounts
- `tbl_members`: Church members
- `tbl_family`: Family grouping
- `tbl_verse`: Daily verses (English & Tamil)
- `tbl_birthdays`: Member birthdays
- `tbl_wedding_anniversary`: Anniversary dates
- `tbl_image_folder`: Gallery folders
- `tbl_image_gallery`: Gallery images
- `tbl_user_role`: Role definitions
- `tbl_user_role_mapping`: User-role mapping

## Configuration

**JWT Configuration** (`.env`):
```
L5_SWAGGER_GENERATE_ALWAYS=true
L5_SWAGGER_CONST_HOST=http://localhost:8000
JWT_SECRET=your_jwt_secret_here
```

## Support

For issues, refer to the Swagger documentation at `/api/documentation`

## License

MIT
