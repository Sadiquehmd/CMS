# Laravel CMS API

A powerful and flexible Content Management System (CMS) backend built with Laravel. It supports role-based access control (Admin & Author), JWT authentication via Sanctum, AI-powered slug & summary generation, and full CRUD operations for articles and categories.

---

##  Features

- User registration & login with Laravel Sanctum
- Role-based authorization (Admin / Author)
- CRUD for articles
- CRUD for categories (Admin only)
- AI-powered slug & summary generation (via Groq)
- RESTful API structure
- Request validation and error handling

---

##  Requirements

- PHP >= 8.2
- Composer
- MySQL or any supported DB
- Laravel >= 10
- Node.js & npm (for frontend if needed)
- Postman (optional for testing)

---

##  Installation

1. **Clone the repo:**

```bash
git clone https://github.com/your-username/laravel-cms-api.git
cd laravel-cms-api
```
2. Install dependencies:
```bash
composer install
```
3.Create .env file:
```bash
cp .env.example .env
```
4.Generate app key:
```bash
php artisan key:generate
```
5.Configure .env with your DB and Groq API key:
```bash
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

GROQ_KEY=given in .env.example
```
6.Run migrations and seeders:
```bash
php artisan migrate --seed
```
7.Start the server:
```bash
php artisan serve
```
8. Export `CMS API.postman_collection.json` for postman collection.

 ## API Endpoints
   ## Auth
Method	Endpoint	Description
POST	/api/register	Register a user (user is been created from seeder but have created a route to register also)
POST	/api/login	Login and get token
POST	/api/logout	Logout (requires token)

## Articles (Authenticated)
Method	Endpoint	Description
GET	/api/articles	List all articles
POST	/api/articles	Create new article
GET	/api/articles/{id}	View single article
PUT	/api/articles/{id}	Update article
PATCH	/api/articles/{id}	Partially update
DELETE	/api/articles/{id}	Delete article

## Categories (Admin Only)
Method	Endpoint	Description
GET	/api/categories	List all categories
POST	/api/categories	Create new category
GET	/api/categories/{id}	View category
PUT	/api/categories/{id}	Update category
DELETE	/api/categories/{id}	Delete category

 ## Auth Usage
All protected routes require the token returned by /api/login.

In Postman add this header:
Authorization: Bearer {token}

## AI Integration
This project uses Groq (LLaMA3) to automatically:

Generate SEO-friendly slugs

Summarize article content

Make sure to set your GROQ_KEY in .env.

## License
This project is open-sourced under the MIT license.
