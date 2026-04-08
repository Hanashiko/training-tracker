# Training Tracker

A workout tracking application built with Symfony 7. Uses Docker for the database, phpMyAdmin for DB management, and Webpack Encore for frontend assets.

## Requirements

- Docker + Docker Compose
- Node.js + npm
- Symfony CLI (optional)

## Setup

**1. Clone the repository**

```bash
git clone https://github.com/Hanashiko/training-tracker.git
cd training-tracker
```

**2. Start Docker containers**

```bash
docker-compose up -d
```

MariaDB will be available on port `3307`, phpMyAdmin on port `981`.

**3. Install dependencies**

```bash
composer install
npm install
```

**4. Run in development mode**

```bash
npm run dev
```

This starts the Symfony dev server and Webpack in watch mode concurrently.

## Database

| Parameter | Value        |
|-----------|--------------|
| Host      | `127.0.0.1`  |
| Port      | `3307`       |
| User      | `php`        |
| Password  | `dqLK129d`   |
| Database  | `training`   |

phpMyAdmin: [http://localhost:981](http://localhost:981)

## Other commands

```bash
# Build frontend for production
npm run build

# Run database migrations
php bin/console doctrine:migrations:migrate

# Load fixtures (demo data)
php bin/console doctrine:fixtures:load
```
