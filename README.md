<div align="center">

# 🏡 Prime Estates

**A production-ready, white-label real estate website & CMS**

Built with PHP, MySQL, and vanilla JavaScript — no frameworks, no lock-in.

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)](#)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)](#)
[![License](https://img.shields.io/badge/license-Proprietary-black?style=flat-square)](#)
[![No Framework](https://img.shields.io/badge/frameworks-none-2E7D46?style=flat-square)](#)

</div>

<br>

## Overview

Prime Estates is a self-contained CMS for real estate agencies — every piece of branding, content, and business data is managed from the admin panel and stored in MySQL. Clone the codebase, point it at a fresh database, and re-skin it for a new client without touching a line of code.

The repo ships with a full demo: a fictional Pakistani agency with 18 properties, 5 agents, 3 projects, and a working blog across Islamabad, Rawalpindi, Lahore, and Karachi.

<br>

## Features

<table>
<tr>
<td width="50%" valign="top">

**Frontend**
- Floating pill navbar, scroll-aware
- Server-side property search, filters, sort, pagination
- Property, project, and agent detail pages
- Blog, testimonials, services, contact form
- WhatsApp deep links, image lightbox
- Fully responsive, semantic HTML

</td>
<td width="50%" valign="top">

**Admin panel**
- Properties, projects, agents, blog, pages
- Drag-and-drop image galleries & section reordering
- Centralized settings — branding, colors, SEO, contact
- Media library, menus, inquiries, contact messages
- Role-aware auth, CSRF, throttled login

</td>
</tr>
</table>

<br>

## Tech stack

| Layer     | Choice                                  |
|-----------|------------------------------------------|
| Backend   | PHP 8+, PDO, custom lightweight router   |
| Database  | MySQL 8 / MariaDB, 25 normalized tables  |
| Frontend  | Vanilla HTML5, CSS3, JavaScript (no build step) |
| Auth      | Sessions + `password_hash()`, CSRF tokens |

<br>

## Quick start

```bash
# 1. Import the database
mysql -u root --default-character-set=utf8mb4 < database/schema.sql
mysql -u root --default-character-set=utf8mb4 < database/seed.sql

# 2. Configure environment
cp .env.example .env

# 3. Serve the app
php -S localhost:8000 -t public public/router.php
```

Visit `http://localhost:8000` for the site, or `/admin/login` for the dashboard.

| | |
|---|---|
| **Admin email** | `admin@primeestates.pk` |
| **Admin password** | `Admin@12345` |

<br>

## Project structure

```
config/     env loading, DB connection, route tables
core/       router, auth, CSRF, settings, uploads, mailer
models/     one class per entity, PDO-backed
admin/      admin controllers (business logic)
site/       public-site controllers
views/      PHP templates — layouts, partials, pages, admin
public/     web root — assets, uploads, front controllers
database/   schema.sql, seed.sql
```

<br>

## Reselling to a new client

1. Import `schema.sql` into a fresh database
2. Copy `.env.example` → `.env` and set DB credentials
3. Log in to `/admin` and update Settings → branding, contact, colors
4. Replace demo properties, agents, and content
5. Publish

No code changes required.

<br>

---

<div align="center">
<sub>Built as a reusable template for real estate agencies in Pakistan and beyond.</sub>
</div>
