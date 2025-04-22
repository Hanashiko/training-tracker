# 📦 Symfony Training Tracker — Документація з розгортання

Цей проєкт — трекер тренувань, створений на Symfony. Використовує Docker для бази даних та phpMyAdmin, а також npm для frontend-білду з Webpack Encore.

## ⚙️ Вимоги

- Docker + Docker Compose
- Node.js + npm
- Symfony CLI (опційно, але бажано)

---

## 🚀 Розгортання

### 1. Клонування репозиторію

```bash
git clone https://github.com/Hanashiko/training-tracker.git
cd training-tracker
```

### 2. Запуск Docker-контейнерів

```bash
docker-compose up -d
```

- База даних MariaDB буде доступна на порту `3307`
- phpMyAdmin — на порту `981` (логін: `php`, пароль: `dqLK129d`)

### 3. Встановлення залежностей PHP

```bash
composer install
```

> За потреби згенеруй `.env.local` з налаштуваннями, або переконайся, що `DATABASE_URL` у `.env` вказує на порт `3307`.

### 4. Встановлення JS-залежностей

```bash
npm install
```

### 5. Запуск у dev-режимі

```bash
npm run dev
```

Ця команда одночасно:
- запускає `symfony server:start`
- запускає `webpack` у watch-режимі

---

## 🧪 Додаткові команди

- Побудова frontend для продакшну:

```bash
npm run build
```

- Перегляд phpMyAdmin: [http://localhost:981](http://localhost:981)

---

## 🗃️ База даних

- **Хост:** `127.0.0.1`
- **Порт:** `3307`
- **Користувач:** `php`
- **Пароль:** `dqLK129d`
- **База:** `training`

---

### 6. Завантаження тестових даних (Fixtures)

```bash
php bin/console doctrine:fixtures:load
```

> Після цього база буде наповнена демонстраційними тренуваннями та іншими даними.

## 🛠️ Нотатки

- Для міграцій: `php bin/console doctrine:migrations:migrate`
- Для оновлення схем: `php bin/console doctrine:schema:update --force`
