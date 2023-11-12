# OpenSecTracker

OpenSecTracker is an open-source web application designed to track issues in chosen open-source language repositories, with a focus on enhancing code review activities and improving overall security.

## Features
- User Registration and Authentication
- Repository Tracking
- Issue Management
- Code Review Integration
- Automated Alerts

## Technologies Used
- PHP
- HTML
- CSS
- JavaScript
- MySQL (or your preferred database)
- AJAX

## Getting Started
1. Clone the repository.
2. Set up a web server (e.g., Apache) and configure it to run PHP.
3. Create a MySQL database and update the database configuration in `config.php`.
4. Import the database schema from `securitydb.sql`.
5. Open the application in a web browser.
6. 

**Folder structure**
```bash
OpenSecTracker/
|-- assets/
|   |-- css/
|   |   |-- styles.css
|   |-- js/
|       |-- script.js
|-- config/
|   |-- config.php
|-- database/
|   |-- database.sql
|-- includes/
|   |-- functions.php
|-- templates/
|   |-- header.php
|   |-- footer.php
|   |-- home.php
|   |-- login.php
|   |-- register.php
|   |-- dashboard.php
|   |-- report_issue.php
|-- .gitignore
|-- CONTRIBUTING.md
|-- LICENSE
|-- README.md
|-- index.php
|-- login.php
|-- register.php

```