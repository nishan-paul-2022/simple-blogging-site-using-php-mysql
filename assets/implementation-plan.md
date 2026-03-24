# Implementation Plan: Modernizing Blog Platform

This plan outlines the migration of the existing Simple Blogging Site (PHP/MySQL) to a modern, professional, and highly responsive platform using **Laravel** for the backend, **Next.js** for the frontend, and **Docker** for containerization.

## 🏗️ Architecture Overview

- **Backend**: Laravel REST API.
  - **Auth**: Laravel Sanctum for SPA authentication.
  - **Database**: MySQL (migrated from existing schema).
  - **Storage**: AWS S3 or Local storage for images/assets.
- **Frontend**: Next.js (App Router).
  - **UI Library**: Shadcn UI + Tailwind CSS.
  - **Animations**: Framer Motion & Three.js (for 3D effects).
  - **PWA**: `next-pwa` for Progressive Web App capabilities.
- **Infrastructure**: Dockerized environment with:
  - `app-backend` (Laravel + PHP-FPM)
  - `app-frontend` (Next.js)
  - `web-server` (Nginx)
  - `database` (MySQL)
  - `cache` (Redis)

---

## 🛠️ Technology Stack

| Component | Technology |
| :--- | :--- |
| **Backend Framework** | Laravel 11.x |
| **Frontend Framework** | Next.js 14.x (App Router) |
| **Styling** | Tailwind CSS |
| **UI Components** | Shadcn UI |
| **State Management** | React Query / TanStack Query |
| **Animations** | Framer Motion, GSAP, Three.js |
| **Containerization** | Docker, Docker Compose |
| **Deployment** | PWA Support, Responsive Design |

---

## 📅 Roadmap & Task Prompts

### Phase 1: Infrastructure & Project Initialization
**Prompt 1: Project Setup & Dockerization**
> Initialize a Laravel backend (`app-backend`) and a Next.js frontend (`app-frontend`) in separate directories. Create a `docker-compose.yml` file to orchestrate these services along with MySQL and Nginx. Ensure both services can communicate. Set up a basic README with setup instructions.

### Phase 2: Database & Backend Core
**Prompt 2: Backend Migration & Authentication**
> Migrate the existing MySQL schema to Laravel Migrations. Implement models for Users, Posts, Categories, Tags, and Comments. Set up Laravel Sanctum for API authentication. Create seeders for initial data based on the current site.

**Prompt 3: REST API Development**
> Implement RESTful API endpoints for:
> - CRUD operations for Blog Posts (with image uploads).
> - Category and Tag management.
> - User Profile & Bio management (migrating from `updateBio.php`).
> - Comment system with moderation.
> - Search and Filtering (SearchBox logic).

### Phase 3: Frontend Foundation & UI System
**Prompt 4: Frontend Foundation & Design System**
> Set up Next.js with Tailwind CSS and Shadcn UI. Implement a "Modern, Unique, 3D-like" global design system with a specific primary theme color used moderately. Configure Framer Motion for page transitions and micro-interactions.

**Prompt 5: Core UI Components**
> Build reusable Shadcn-based components:
> - Interactive Navigation & Layout.
> - Advanced Blog Card with motion effects.
> - 3D-effect Sidebar (Search, Bio, Popular Posts).
> - Responsive Footer.

### Phase 4: Frontend Implementation & Integration
**Prompt 6: Blog Feed & Discovery**
> Implement the Home page with "Latest" and "Popular" tabs. Integrate the backend API using TanStack Query for data fetching, infinite scrolling, and real-time search filtering.

**Prompt 7: Single Post View & Comments**
> Create a dynamic `[slug]` page for single posts. Include a rich-text renderer for content, a related posts section, and an interactive comment system with deep-link support.

**Prompt 8: Admin Dashboard & PWA**
> Port the `adminPanel.php` functionality to a modern Next.js dashboard. Implement post creation/editing with a modern editor (e.g., Tiptap). Finalize PWA configuration (manifest, icons, service workers).

### Phase 5: Polish & Deployment
**Prompt 9: Final Polish & UX Enhancements**
> Add 3D-like elements (e.g., Spline or custom GLSL shaders). Fine-tune responsiveness across all devices. Optimize performance (Lighthouse score 90+). Update the README with final setup and run instructions.

---

## 🎨 Creative Direction
- **Theme Color**: Deep Indigo/Violet (`#6366f1`) with Neon Emerald (`#10b981`) accents.
- **UI Feel**: Glassmorphism, soft shadows (neumorphism-lite), ultra-smooth transitions.
- **3D Elements**: Floating cards, mouse-parallax effects on hero sections.
