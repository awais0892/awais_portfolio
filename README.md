# Awais Portfolio - Modern Laravel Web Application

A premium, dynamic portfolio website built with Laravel 11, featuring a modern glassmorphism design, GSAP animations, and a powerful administrative backend.

## 🚀 Features

- **Dynamic Modules**: Fully manageable Skills, Experience, and Blog sections via the Admin Panel.
- **Modern UI/UX**: Premium design aesthetics using Tailwind CSS and GSAP (GreenSock Animation Platform) for smooth micro-animations.
- **Admin Dashboard**: Comprehensive CRUD operations for all site content.
- **Cloudinary Integration**: Automatic image and document uploads with optimized delivery.
- **Interactive Components**: 
  - Dynamic Comment System with nested replies.
  - Interactive Rating System with real-time feedback.
  - Advanced search and filtering for skills and experience.
- **SEO Optimized**: Built-in meta tag management and semantic HTML structure.

## 🛠️ Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Tailwind CSS, GSAP, Alpine.js
- **Database**: MySQL / PostgreSQL
- **Media**: Cloudinary API
- **Icons**: Font Awesome 6

## 📦 Installation & Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/awaisahmad624/awais_portfolio.git
   cd awais_portfolio
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Migration & Seeding**:
   ```bash
   php artisan migrate --seed
   ```

5. **Cloudinary Configuration**:
   Add your `CLOUDINARY_URL` to the `.env` file.

6. **Compile Assets & Run**:
   ```bash
   npm run dev
   php artisan serve
   ```

## 🔒 Security & Performance

- **CSRF Protection**: All forms are protected against Cross-Site Request Forgery.
- **Rate Limiting**: API endpoints (Comments/Ratings) are protected by Laravel's RateLimiter.
- **SSL Ready**: Optimized for secure HTTPS deployments (e.g., Fly.io, Railway).

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

