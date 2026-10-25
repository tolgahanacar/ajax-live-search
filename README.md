# PHP Ajax Live Search

A modern, secure, and blazing-fast live search application powered by **PHP 8+**, **MySQL PDO**, and asynchronous **AJAX** with a glassmorphism dark-themed user interface.

---

## 🌟 Key Features

- **Instant Live Search:** Real-time query execution with a 300ms debounce to prevent redundant server load.
- **Race Condition Prevention:** In-flight AJAX requests are automatically aborted (`activeRequest.abort()`) when new input is entered.
- **Dynamic Term Highlighting:** Matching search queries are dynamically highlighted within results using safe DOM escaping.
- **Command Palette & Keyboard Navigation:**
  - Press `/` anywhere on the page to focus the search bar.
  - Navigate results using the `↑` and `↓` arrow keys.
  - Press `Enter` to open the highlighted result.
  - Press `Esc` or click outside to dismiss results.
- **One-Click Clear Button:** Instant search input reset with an integrated clear button.
- **Skeleton Screen Loader:** Smooth pulse animations while fetching data for a seamless user experience.
- **Enterprise-Grade Security:**
  - PDO Prepared Statements preventing SQL Injection.
  - SQL `LIKE` wildcard escaping (`%` and `_`).
  - Strict Content-Security-Policy (CSP) headers.
  - Contextual XSS sanitization (`htmlspecialchars` and text-node escaping).
  - Masked database error disclosures in client responses.
- **Accessible (A11y):** Full ARIA support (`role="combobox"`, `role="listbox"`, `aria-expanded`, `aria-activedescendant`, screen-reader announcements).
- **Rich Detail Views:** Detail cards featuring metadata chips, related technology suggestions, and breadcrumb navigation.
- **Flexible Environment Configuration:** Supports `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, and `DB_PASS` via environment variables with safe local defaults.

---

## 🚀 Installation & Setup

### 1. Database Setup
Import the provided SQL schema into your MySQL server:
```sql
mysql -u root -p < results.sql
```
*(Or use phpMyAdmin / Sequel Ace / DBeaver to import `results.sql`)*

### 2. Configuration
By default, [connect.php](file:///c:/MAMP/htdocs/ajax-live-search/connect.php) connects to `localhost:3306` with database `livesearch`.
You can customize connection parameters either directly in [connect.php](file:///c:/MAMP/htdocs/ajax-live-search/connect.php) or via environment variables:
```bash
export DB_HOST="localhost"
export DB_PORT="3306"
export DB_NAME="livesearch"
export DB_USER="tolga"
export DB_PASS="123456"
```

### 3. Running Locally
Place the project in your web server directory (e.g. `C:\MAMP\htdocs\ajax-live-search` or `/var/www/html/ajax-live-search`) and visit:
```
http://localhost/ajax-live-search/
```

---

## 📁 Project Architecture

```
ajax-live-search/
├── assets/
│   ├── css/
│   │   └── style.css       # Design tokens, glassmorphism, animations, responsive layout
│   └── js/
│       └── search.js       # Live search engine, debounce, keyboard navigation, highlighter
├── ajax.php                # High-performance JSON search endpoint with wildcard sanitization
├── connect.php             # PDO database connection with graceful error masking
├── get.php                 # Rich item detail view with related technology recommendations
├── index.php               # Main search application UI & CSP configuration
├── results.sql             # Database schema with indexed description & seed datasets
└── README.md               # Documentation
```
