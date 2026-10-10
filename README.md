# Prestigee Events — Live Event Management Website

[![Live Website](https://img.shields.io/badge/Website-Live-gold)](https://prestigeeevents.com/)

A production website for Prestigee Events, an event management business offering corporate events, luxury weddings, private celebrations, and event staffing services.

🌐 **Live Website:** https://prestigeeevents.com/  
💻 **Repository:** https://github.com/vinayreddy758/prestigee-events-website

## Overview

Prestigee Events provides a professional online presence for an event management business. The website allows visitors to explore services, view the company's portfolio, learn about the business, and contact the team or submit event quote requests.

The design combines a dark visual theme, gold accents, interactive elements, and dedicated service pages to present the brand consistently.

## Features

- **Homepage:** Introduces the brand and highlights its services.
- **Services Page:** Organizes event management services into categories.
- **Portfolio:** Provides a dedicated page for showcasing event work.
- **About Page:** Presents company information.
- **Contact Form:** Collects visitor enquiries and stores accepted submissions in the database.
- **Event Quote Requests:** Collects event type, date, location, budget, company, and contact details.
- **Admin Area:** Provides a login flow for authorized administration.
- **Responsive Layout:** Includes layouts designed for different screen sizes.
- **Interactive UI:** Uses animated elements, hover effects, scroll-based presentation, and visual transitions.
- **SEO Foundations:** Includes page metadata, canonical URLs, crawler directives, structured data, and a sitemap.

## Technology Stack

| Technology | Purpose |
|---|---|
| PHP | Server-side rendering and form handling |
| MySQL | Persistent storage for website data and enquiries |
| PDO | Database connectivity and prepared statements |
| HTML5 | Page structure |
| CSS | Custom styling and animations |
| JavaScript | Interactive website behaviour |
| Tailwind CSS | Utility-based styling, loaded through CDN |
| Git & GitHub | Version control and source code management |

## Project Structure

```text
prestigee-events-website/
├── admin/           # Admin login and management pages
├── assets/          # Images, icons, and static resources
├── database/        # Database-related files
├── includes/        # Shared layouts and database helpers
├── index.php        # Homepage
├── about.php        # About page
├── services.php     # Services listing
├── portfolio.php    # Portfolio page
├── contact.php      # Contact form
├── quote.php        # Event quote request form
├── robots.txt       # Crawler instructions
├── sitemap.xml      # Sitemap
└── README.md
```

## Local Development

### Prerequisites

- PHP with PDO MySQL support
- MySQL server
- Git

### Installation

**1. Clone the repository**

```bash
git clone https://github.com/vinayreddy758/prestigee-events-website.git
cd prestigee-events-website
```

**2. Create the database**

Create a MySQL database named `prestigee_events`, or configure a different name using the environment variables below.

**3. Configure database access**

The database helper reads these environment variables:

| Variable | Description |
|---|---|
| `DB_HOST` | Database host |
| `DB_PORT` | Database port |
| `DB_NAME` | Database name |
| `DB_USER` | Database username |
| `DB_PASS` | Database password |

The default database name is `prestigee_events`, and the default host and port are `localhost` and `3306`.

Configure credentials for your local environment. Do not commit passwords or production secrets.

**4. Start the development server**

From the project root, run:

```bash
php -S localhost:8000
```

**5. Open the website**

Visit [http://localhost:8000](http://localhost:8000).

Database-backed pages and forms require a correctly configured MySQL database. Production hosting settings are separate from this local setup.

## Database and Forms

The application uses PHP and MySQL to process contact messages and event quote requests.

Submitted data is validated on the server before accepted requests are stored. PDO is used for database interactions.

The admin area includes an authentication flow intended for authorized administration. Never expose admin credentials or sensitive customer information in public documentation.

## SEO and Website Quality

The repository includes several search-engine optimization foundations:

- Page titles and meta descriptions
- Canonical URLs
- Robots directives
- XML sitemap
- Structured data
- Image and page presentation optimizations

These features provide a foundation for search visibility; actual indexing, rankings, and performance depend on configuration and ongoing optimization.

## Live Project

Visit the production website:

**https://prestigeeevents.com/**

This repository documents a website used by a real business, rather than a purely illustrative landing-page concept.

## Developer

**Vinay Reddy AD**

GitHub: https://github.com/vinayreddy758

When presenting this project in a portfolio, describe the development, deployment, or maintenance responsibilities you personally performed.

---

**Project Type:** Business Website  
**Industry:** Event Management  
**Status:** Live in Production
