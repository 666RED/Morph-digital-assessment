# Morph Digital Assessment
This is a Laravel + Vue3 + Inertia project for Morph Digital assessment.

## Prerequisites
Before running the project, make sure you have the following installed:

- **PHP >= 8.1**
  [Installation Guide](https://www.php.net/manual/en/install.php)
- **Composer** (PHP dependency manager) 
  [Installation Guide](https://getcomposer.org/download/)
- **Node.js & npm/yarn/pnpm** (for frontend assets)
  [Node.js Installation](https://nodejs.org/)
  [Yarn](https://classic.yarnpkg.com/en/docs/install) | [pnpm](https://pnpm.io/installation)
- **Docker & Docker Compose** (for database)
  [Docker Installation](https://docs.docker.com/get-docker/)
> ⚠️ If you don’t have Docker, you can also run MySQL locally and update the `.env` accordingly.

---

## Setup
1. Clone the repository:
```bash
git clone https://github.com/666RED/Morph-digital-assessment.git
cd Morph-digital-assessment
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install frontend dependencies (choose one):
```bash
npm install 
# or
yarn install
# or
pnpm install
```

4. Copy .env example
```bash
cp .env.example .env
```

5. Generate application key
```bash
php artisan key:generate
```

6. Start Docker container (for mysql server)
```bash
docker-compose up -d
```
> run ```docker ps``` to see if the container is running

7. Run migrations
```bash
php artisan migrate
```

8. Seed the database
```bash
php artisan db:seed
```

9. Run the application
```bash
composer run dev
```

## Login credentials
- Email: test@gmail.com
- Password: 12341234
