# dynamic-form

A Laravel 11-based dynamic form builder project that allows administrators to create forms with customizable fields and users to submit form responses.

##  Features

- Create and manage dynamic forms
- Add different field types (text, textarea, select, checkbox, etc.)
- Form submission by end-users

##  Requirements

- PHP >= 8.2
- Composer
- Laravel 11
- MySQL or compatible database

##  Installation Guide

### 1. Clone the Repository

```bash
git clone git@github.com:Manojk-1989/dynamic-form.git
cd dynamic-form

### 2. Install PHP Dependencies

```bash
composer install

### 3. Copy and Configure Environment File

```bash
cp .env.example .env

### 4. Update the following variables in .env according to your local setup

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

### 5. Update the following variables in .env according for mail configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

### 6.Generate Application Key
```bash
php artisan key:generate

### 7.Run Migrations
```bash
php artisan migrate

### 8. To run the project
```bash
php artisan serve

### 9. Start Queue Worker (for handling emails and background jobs)
```bash
php artisan queue:work
