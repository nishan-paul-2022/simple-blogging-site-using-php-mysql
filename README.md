# Expresso - Modern Blog Platform 🚀

A comprehensive, full-featured blogging platform built with modern web technologies. This project demonstrates scalable architecture, RESTful API design, and responsive frontend development.

## 🎯 Project Overview

Expresso is a migration of a legacy PHP/MySQL blog into a production-ready application using:
- **Backend**: Laravel 11 REST API with PostgreSQL/MySQL
- **Frontend**: Next.js 14 with React 18 and TypeScript
- **Infrastructure**: Docker containerization with Nginx reverse proxy
- **Styling**: Tailwind CSS with custom design system

**Live Demo**: [coming soon]  
**Documentation**: See sections below for comprehensive guides

---

## 📋 Table of Contents

1. [Architecture](#-architecture)
2. [Tech Stack](#-tech-stack)
3. [Quick Start](#-quick-start)
4. [Development Setup](#-development-setup)
5. [Project Structure](#-project-structure)
6. [API Reference](#-api-reference)
7. [Frontend Features](#-frontend-features)
8. [Database Schema](#-database-schema)
9. [Deployment](#-deployment)
10. [Common Tasks](#-common-tasks)
11. [Security](#-security)
12. [Contributing](#-contributing)

---

## 🏗️ Architecture

### Microservices Design

```
┌─────────────────────────────────────────────────────────┐
│                  Docker Compose Network                  │
├─────────────────────────────────────────────────────────┤
│                                                           │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐  │
│  │   Next.js    │  │   Laravel    │  │   Nginx      │  │
│  │  Frontend    │  │   Backend    │  │  Reverse     │  │
│  │  :3000       │  │  :8000       │  │  Proxy       │  │
│  │              │  │              │  │  :80/:443    │  │
│  └──────────────┘  └──────────────┘  └──────────────┘  │
│         │                  │                  │          │
│  ┌──────────────┐  ┌──────────────┐                     │
│  │    MySQL     │  │    Redis     │                     │
│  │   Database   │  │    Cache     │                     │
│  │   :3306      │  │   :6379      │                     │
│  └──────────────┘  └──────────────┘                     │
│                                                           │
└─────────────────────────────────────────────────────────┘
```

### Data Flow

1. **Frontend (SPA)**: Browser → Next.js at `localhost:3000`
2. **API Communication**: Frontend ↔ Backend via REST API at `/api/*`
3. **Authentication**: Bearer token via Laravel Sanctum
4. **Data Persistence**: Eloquent ORM → MySQL with Redis caching
5. **Reverse Proxy**: Nginx routes traffic to appropriate services

### Authentication Flow

```
1. User registers/logs in via API
2. Laravel Sanctum generates bearer token
3. Token stored in localStorage (frontend)
4. All API requests include: Authorization: Bearer {token}
5. Laravel middleware validates token
6. Policies authorize resource actions
```

---

## 🛠️ Tech Stack

### Backend (api/)

| Technology | Version | Purpose |
|-----------|---------|---------|
| **Laravel** | 11.x | Web framework |
| **PHP** | 8.2 | Server language |
| **MySQL** | 8.0 | Primary database |
| **Redis** | 7.x | Caching layer |
| **Composer** | Latest | Dependency manager |
| **Sanctum** | Built-in | API authentication |

**Key Packages**:
- `laravel/framework`: Core framework
- `laravel/sanctum`: Token-based authentication
- `laravel/tinker`: Interactive shell
- Built-in migrations, seeders, factories

### Frontend (frontend/)

| Technology | Version | Purpose |
|-----------|---------|---------|
| **Next.js** | 14.x | React framework |
| **React** | 18.x | UI library |
| **TypeScript** | 5.x | Type safety |
| **Tailwind CSS** | 3.3 | Utility-first styling |
| **Framer Motion** | 10.x | Animations |
| **Node.js** | 18.x | Runtime |

**Key Packages**:
- `tailwindcss`: Styling framework
- `class-variance-authority`: Component variants
- `clsx`: Conditional class names
- `axios` (optional): HTTP client
- `zustand` (ready): State management

### Infrastructure

| Technology | Version | Purpose |
|-----------|---------|---------|
| **Docker** | 24.x | Containerization |
| **Docker Compose** | 3.8 | Orchestration |
| **Nginx** | 1.25 | Reverse proxy |
| **Git** | 2.x | Version control |

---

## 🚀 Quick Start

### Prerequisites

- **Docker** and **Docker Compose** installed
- **Git** for version control
- **Node.js 18+** (for local frontend development)
- **PHP 8.2** and **Composer** (for local backend development)

### 1. Clone Repository

```bash
git clone <repository-url>
cd simple-blogging-site-using-php-mysql
```

### 2. Start with Docker

```bash
# Start all services
docker-compose up -d

# Wait for services to be healthy (15-30 seconds)
docker-compose ps

# Run Laravel migrations and seeders
docker-compose exec app-backend php artisan migrate --seed

# Database is now populated with test data
```

### 3. Access Application

- **Frontend**: http://localhost:3000
- **API**: http://localhost:8000/api
- **API Docs**: http://localhost:8000/api/docs (when available)

### 4. View Test Data

**Default Admin Account**:
```
Email: admin@blog.test
Password: password
```

**Created During Seeding**:
- 10 users with posts, comments, and profiles
- 5 categories with related posts
- 8 tags across posts
- 50+ posts with various statuses
- 100+ comments with nested replies

### 5. Stop Services

```bash
docker-compose down

# Remove volumes (deletes database data)
docker-compose down -v
```

---

## 💻 Development Setup

### Local Backend Development

```bash
cd api

# Install dependencies
composer install

# Create environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Set up database (local MySQL/SQLite)
php artisan migrate --seed

# Start development server
php artisan serve

# API available at http://localhost:8000/api
```

### Local Frontend Development

```bash
cd frontend

# Install dependencies
npm install

# Start development server
npm run dev

# Frontend available at http://localhost:3000
```

### Database Setup

```bash
# Generate migrations
php artisan make:migration create_table_name

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Refresh (rollback + migrate)
php artisan migrate:refresh

# Seed database
php artisan db:seed

# Seed specific seeder
php artisan db:seed --class=PostSeeder
```

### Tinker (Laravel REPL)

```bash
# Interactive shell in Docker
docker-compose exec app-backend php artisan tinker

# Examples:
>>> $user = User::first();
>>> $user->posts()->count();
>>> $user->comments()->get();
```

---

## 📁 Project Structure

### Backend Structure

```
api/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php         # Authentication endpoints
│   │   │   ├── PostController.php         # Post CRUD & queries
│   │   │   ├── CategoryController.php     # Category management
│   │   │   ├── TagController.php          # Tag operations
│   │   │   └── CommentController.php      # Comment endpoints
│   │   ├── Middleware/
│   │   │   └── IsAdmin.php                # Admin authorization
│   │   └── Requests/                      # Form request validation
│   ├── Models/
│   │   ├── User.php                       # User model + relationships
│   │   ├── Post.php                       # Post model + scopes
│   │   ├── Category.php                   # Category model
│   │   ├── Tag.php                        # Tag model
│   │   └── Comment.php                    # Comment model
│   ├── Policies/
│   │   ├── PostPolicy.php                 # Post authorization
│   │   ├── CommentPolicy.php              # Comment authorization
│   │   └── CategoryPolicy.php             # Category authorization
│   └── Traits/                            # Reusable logic
├── database/
│   ├── migrations/                        # Database schema
│   ├── factories/                         # Model factories
│   └── seeders/                           # Database seeders
├── routes/
│   ├── api.php                            # API endpoints
│   └── web.php                            # Web routes
├── bootstrap/
│   └── app.php                            # Application bootstrap
├── config/
│   ├── app.php                            # App configuration
│   ├── database.php                       # Database config
│   └── sanctum.php                        # Auth configuration
├── .env.example                           # Environment template
├── artisan                                # CLI tool
├── composer.json                          # Dependencies
└── docker/
    ├── Dockerfile                         # PHP-FPM image
    └── php.ini                            # PHP configuration
```

### Frontend Structure

```
frontend/
├── app/
│   ├── layout.tsx                         # Root layout with Header/Footer
│   ├── page.tsx                           # Home page (/)
│   ├── globals.css                        # Global styles & animations
│   ├── blog/
│   │   ├── page.tsx                       # Blog listing page
│   │   └── [slug]/
│   │       └── page.tsx                   # Single post page (dynamic)
│   ├── categories/
│   │   └── page.tsx                       # Categories listing
│   ├── about/
│   │   └── page.tsx                       # About page
│   └── auth/
│       ├── login/page.tsx                 # Login (TODO)
│       └── signup/page.tsx                # Signup (TODO)
├── components/
│   ├── ui/
│   │   ├── Button.tsx                     # Button component (variants)
│   │   ├── Card.tsx                       # Card component + subcomponents
│   │   └── Badge.tsx                      # Badge component
│   ├── layout/
│   │   ├── Header.tsx                     # Navigation header
│   │   ├── Footer.tsx                     # Footer with links
│   │   └── Hero.tsx                       # Hero section
│   ├── blog/
│   │   └── BlogCard.tsx                   # Post card component
│   └── admin/                             # Admin components (TODO)
├── lib/
│   ├── api.ts                             # API client utilities
│   └── utils.ts                           # Helper functions
├── hooks/
│   └── useApi.ts                          # Custom API hooks
├── styles/
│   └── globals.css                        # Tailwind + custom CSS
├── public/
│   └── favicon.ico                        # Favicon & assets
├── next.config.js                         # Next.js configuration
├── tailwind.config.js                     # Tailwind theme
├── tsconfig.json                          # TypeScript config
├── postcss.config.js                      # PostCSS config
├── package.json                           # Dependencies
└── .env.local                             # Environment variables
```

### Infrastructure

```
├── docker-compose.yml                     # Service orchestration
├── nginx.conf                             # Reverse proxy config
├── Dockerfile (backend)                   # PHP-FPM container
├── Dockerfile (frontend)                  # Node.js container
└── .dockerignore                          # Docker ignore file
```

---

## 🔌 API Reference

### Base URL
```
http://localhost:8000/api
```

### Authentication
```
Authorization: Bearer {token}
Content-Type: application/json
```

### Endpoints

#### Posts
```
GET    /posts                              # List all posts (public)
GET    /posts/featured                     # Featured posts only
GET    /posts/popular                      # Popular posts
GET    /posts/{id}                         # Single post by ID
GET    /posts/slug/{slug}                  # Single post by slug
POST   /posts                              # Create post (auth)
PUT    /posts/{id}                         # Update post (author/admin)
DELETE /posts/{id}                         # Delete post (author/admin)
GET    /posts/{id}/related                 # Related posts
```

**Query Parameters** (GET /posts):
```
?search=keywords                           # Full-text search
?category_id=1                             # Filter by category
?tag_id=2                                  # Filter by tag
?status=published                          # Filter by status (draft/published/archived)
?page=1&per_page=15                        # Pagination
?sort=latest|popular|viewed                # Sort order
```

#### Categories
```
GET    /categories                         # List all categories
GET    /categories/{id}                    # Get category
GET    /categories/{id}/posts              # Posts in category
POST   /categories                         # Create (admin)
PUT    /categories/{id}                    # Update (admin)
DELETE /categories/{id}                    # Delete (admin)
```

#### Tags
```
GET    /tags                               # List all tags
GET    /tags/{id}                          # Get tag
GET    /tags/{id}/posts                    # Posts with tag
GET    /tags/autocomplete?q=search         # Tag autocomplete
```

#### Comments
```
GET    /posts/{id}/comments                # Post comments
POST   /posts/{id}/comments                # Create comment (auth)
DELETE /comments/{id}                      # Delete comment (author/admin)
POST   /comments/{id}/approve              # Approve comment (admin)
```

#### Authentication
```
POST   /auth/register                      # Register new user
POST   /auth/login                         # Login
POST   /auth/logout                        # Logout (auth)
GET    /auth/me                            # Current user (auth)
PUT    /auth/profile                       # Update profile (auth)
```

### Response Format

**Success** (200 OK):
```json
{
  "data": { ... },
  "message": "Success",
  "status": true
}
```

**Error** (400+ status):
```json
{
  "message": "Error description",
  "errors": { "field": "error message" },
  "status": false
}
```

---

## 🎨 Frontend Features

### Components Library

#### Button
```tsx
import { Button } from "@/components/ui/Button";

<Button variant="primary" size="lg" fullWidth>
  Click me
</Button>
```

**Props**: `variant` (primary|secondary|outline|ghost), `size` (sm|md|lg), `fullWidth`, `disabled`, `loading`

#### Card
```tsx
import { Card } from "@/components/ui/Card";

<Card>
  <Card.Header>
    <Card.Title>Title</Card.Title>
    <Card.Description>Description</Card.Description>
  </Card.Header>
  <Card.Content>Content</Card.Content>
  <Card.Footer>Footer</Card.Footer>
</Card>
```

#### Badge
```tsx
import { Badge } from "@/components/ui/Badge";

<Badge variant="primary">Label</Badge>
```

**Variants**: primary, secondary, success, warning, destructive

### Pages

#### Home Page (`/`)
- Hero section with animated gradient
- Featured posts carousel
- Feature cards
- Development roadmap
- Status dashboard
- Call-to-action section

#### Blog Listing (`/blog`)
- Search functionality
- Pagination (load more)
- Category/tag filtering
- Post cards with metadata
- Responsive grid layout
- Error handling

#### Single Post (`/blog/[slug]`)
- Featured image
- Post metadata (author, date, views)
- Tags with links
- Related posts (3-5 recommendations)
- Comment section (UI pending)
- Navigation to next/previous posts

#### Categories (`/categories`)
- Grid layout of all categories
- Post count per category
- Color-coded categories
- Links to category posts

#### About (`/about`)
- Project vision
- Technology stack details
- Key features list
- Development approach
- Team information (placeholder)

### Animations

- **Entrance**: Fade-in and slide-in animations on scroll
- **Hover**: Smooth scale and shadow transitions
- **Loading**: Skeleton screens (ready to implement)
- **Page Transitions**: Built-in Next.js app router transitions

---

## 🗄️ Database Schema

### Users Table
```sql
CREATE TABLE users (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  email VARCHAR(255) UNIQUE,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255),
  bio TEXT,
  avatar VARCHAR(255),
  is_admin BOOLEAN DEFAULT false,
  last_login_at TIMESTAMP NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Posts Table
```sql
CREATE TABLE posts (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT (FK: users.id),
  category_id BIGINT (FK: categories.id),
  title VARCHAR(255),
  slug VARCHAR(255) UNIQUE,
  excerpt TEXT,
  content LONGTEXT,
  featured_image VARCHAR(255),
  status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
  views INT DEFAULT 0,
  published_at TIMESTAMP NULL,
  featured_until TIMESTAMP NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Categories Table
```sql
CREATE TABLE categories (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  slug VARCHAR(255) UNIQUE,
  description TEXT,
  color VARCHAR(7),
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Tags Table
```sql
CREATE TABLE tags (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255),
  slug VARCHAR(255) UNIQUE,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Comments Table
```sql
CREATE TABLE comments (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  post_id BIGINT (FK: posts.id),
  user_id BIGINT (FK: users.id),
  parent_id BIGINT NULL (FK: comments.id),
  content TEXT,
  approved BOOLEAN DEFAULT false,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

### Post_Tag Pivot Table
```sql
CREATE TABLE post_tag (
  post_id BIGINT (FK: posts.id),
  tag_id BIGINT (FK: tags.id),
  PRIMARY KEY (post_id, tag_id)
);
```

### Key Indexes
- `posts.slug` - For URL slug lookups
- `posts.category_id` - For category queries
- `posts.user_id` - For author queries
- `comments.post_id` - For post comments
- `users.email` - For authentication

---

## 🚢 Deployment

### Docker Production Build

```bash
# Build images
docker-compose -f docker-compose.yml build

# Run in production
docker-compose -f docker-compose.yml up -d

# View logs
docker-compose logs -f app-backend
docker-compose logs -f app-frontend
```

### Environment Variables

**Backend** (api/.env):
```
APP_NAME=Expresso
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.domain.com

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=blog_db
DB_USERNAME=blog_user
DB_PASSWORD=secure_password

CACHE_DRIVER=redis
REDIS_HOST=cache
REDIS_PORT=6379

SANCTUM_STATEFUL_DOMAINS=domain.com,www.domain.com
SESSION_DOMAIN=.domain.com
```

**Frontend** (frontend/.env.local):
```
NEXT_PUBLIC_API_URL=https://api.domain.com/api
```

### Deployment Checklist

- [ ] Configure environment variables
- [ ] Set strong database password
- [ ] Enable HTTPS/SSL certificates
- [ ] Configure email service (optional)
- [ ] Set up backups (database, uploads)
- [ ] Configure CDN for static assets
- [ ] Enable rate limiting
- [ ] Set up monitoring/logging
- [ ] Configure backup strategy
- [ ] Test disaster recovery

### Deploy to Heroku (Example)

```bash
# Login to Heroku
heroku login

# Create app
heroku create expresso-blog

# Add database
heroku addons:create heroku-postgresql:standard-0

# Deploy
git push heroku main

# Run migrations
heroku run php artisan migrate --seed
```

---

## 🛠️ Common Tasks

### Create New Model with Migration

```bash
php artisan make:model Post -m

# Add columns in migration
php artisan migrate
```

### Create New API Controller

```bash
php artisan make:controller Api/PostController --api

# Generates: index, store, show, update, destroy
```

### Generate API Documentation

```bash
# Install Scribe
composer require knuckleswtf/scribe

# Generate docs
php artisan scribe:generate
```

### Frontend: Add New Page

```bash
# Create page in app directory
# Next.js automatically creates routes

# Example: app/blog/new-page/page.tsx
export default function NewPage() {
  return <div>Content</div>;
}

# Accessible at /blog/new-page
```

### Frontend: Create Component

```bash
# Create in components/
# components/MyComponent.tsx

'use client';

export default function MyComponent() {
  return <div>Component</div>;
}

# Import in page
import MyComponent from '@/components/MyComponent';
```

### Database: Export Data

```bash
# Backup
docker-compose exec database mysqldump -u blog_user -p blog_db > backup.sql

# Restore
docker-compose exec -T database mysql -u blog_user -p blog_db < backup.sql
```

### Debug API Endpoint

```bash
# Using curl
curl -H "Authorization: Bearer {token}" \
  http://localhost:8000/api/posts

# Using httpie
http GET http://localhost:8000/api/posts \
  Authorization:"Bearer {token}"

# Using Postman
# Desktop app with collections support
```

---

## 🔐 Security

### Best Practices Implemented

1. **Authentication**: Laravel Sanctum (token-based)
2. **Authorization**: Policy-based (PostPolicy, CommentPolicy, CategoryPolicy)
3. **Input Validation**: Request classes with rules
4. **CORS**: Configured in Laravel
5. **SQL Injection**: ORM protection via Eloquent
6. **XSS**: React auto-escaping + Tailwind sanitization
7. **CSRF**: Built-in Laravel protection

### Security Checklist

- [ ] Change all default credentials
- [ ] Enable HTTPS in production
- [ ] Set `APP_DEBUG=false` in production
- [ ] Use strong database passwords
- [ ] Enable two-factor authentication (TODO)
- [ ] Set up rate limiting on API
- [ ] Log authentication attempts
- [ ] Monitor suspicious activities
- [ ] Regular security updates
- [ ] Keep dependencies updated: `composer update`, `npm update`

### Vulnerable Dependencies

```bash
# Check for vulnerabilities
composer audit

npm audit
```

---

## 🤝 Contributing

### Development Workflow

1. **Create branch**: `git checkout -b feature/description`
2. **Make changes**: Follow code style
3. **Commit**: `git commit -m "feat: description"`
4. **Push**: `git push origin feature/description`
5. **Pull Request**: Create PR with description
6. **Code Review**: Address feedback
7. **Merge**: Squash and merge to main

### Commit Message Convention

```
feat(scope): Add new feature
fix(scope): Fix bug
docs(scope): Update documentation
style(scope): Code style changes
refactor(scope): Refactor code
perf(scope): Performance improvements
test(scope): Add/update tests
chore(scope): Dependency updates, tooling
```

### Code Style

- **Backend**: PSR-12 (Laravel conventions)
- **Frontend**: Prettier + ESLint
- **SQL**: Uppercase keywords

---

## 📈 Performance Tips

### Backend Optimization

```php
// Use eager loading to prevent N+1 queries
$posts = Post::with('user', 'category', 'tags')->paginate();

// Use caching
Cache::remember('posts.featured', now()->addHour(), fn() => 
  Post::featured()->latest()->get()
);

// Use database indexes
// Already configured on slug, category_id, user_id
```

### Frontend Optimization

```tsx
// Use Next.js Image component
import Image from 'next/image';

// Use dynamic imports for components
const HeavyComponent = dynamic(() => import('@/components/Heavy'));

// Memoize expensive components
const Post = memo(({ post }) => {
  // Component code
});
```

---

## 📞 Support & Contact

**Issues**: Create GitHub issue with detailed description  
**Email**: nishan@blog.test  
**Discord**: [Coming soon]

---

## 📄 License

MIT License - See LICENSE file for details

---

## 🙏 Acknowledgments

- Laravel community and documentation
- Next.js team for excellent framework
- Tailwind CSS for utility-first styling
- Contributors and testers

---

**Last Updated**: January 2025  
**Status**: Active Development (Phase 6/7 complete)  
**Next Priority**: Authentication UI pages, Admin dashboard
