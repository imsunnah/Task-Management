# Task Manager & Calendar System (RBAC)

This is a simple but practical **Task Planner and Calendar Management** system built with **Laravel**. The main goal of this project is to demonstrate how **role-based access control (RBAC)** can be implemented using **Laravel Gates, Policies**, and **Spatie Laravel Permission**, without relying on Laravel starter authentication packages.

The application has two roles: **Admin** and **Employee**, each with clearly defined permissions and ownership rules.

> **Important:** Authentication is handled manually using Laravel’s default `web` guard. Packages like Breeze, Jetstream, Fortify, or Sanctum are **not used** in this project.

---

## Overview

* Single-guard authentication (`web`)
* Admin and Employee roles
* Permission-based access control
* Task management with assignment
* Calendar and event management using FullCalendar
* Clean UI with permission-aware actions

This project is suitable for learning or small internal tools where strict access control is required.

---

## Roles & Access

### Admin

* Full access to the system
* Can manage users, tasks, and events
* Can assign tasks and events to employees

### Employee

* Limited access based on assigned permissions
* Can only see their **own** tasks and events
* Cannot access user management

Ownership checks are enforced through policies to prevent unauthorized access.

---

## Permissions

Permissions are managed using **Spatie Laravel Permission**.

### Task Permissions

* `task.view` – View own task
* `task.view_any` – View all tasks (Admin)
* `task.create`
* `task.update`
* `task.delete`

### Event Permissions

* `event.view` – View own events
* `event.view_any` – View all events (Admin)
* `event.create`
* `event.update`
* `event.delete`

### Admin Only

* `user.manage` – User management access

### Default Employee Permissions

New employees are assigned:

* `task.view`
* `event.view`

They can only access records assigned to them.

---

## User Management

* Only Admin users with the `user.manage` permission can create new users
* Roles and permissions are assigned during user creation

---

## Task Planner

### Task Fields

* Title
* Description
* Assigned Employee
* Status (Pending, In Progress, Completed)
* Priority (Low, Medium, High)
* Due date and time

### Access Rules

* Admin can create, view, update, and delete all tasks
* Employees can only view and manage tasks assigned to them (if permitted)

---

## Calendar & Events

The calendar is built using **FullCalendar v6**.

### Features

* Month, week, and day views
* Click-to-create events
* Optional task association

### Event Fields

* Event title
* Event date
* Start and end time
* Related task (optional)

### Access Rules

* Admin can see and manage all events
* Employees only see events assigned to them

---

## User Interface

* Built with Bootstrap 5
* Blade templates
* Buttons and actions are shown or hidden based on permissions
* Unauthorized actions are blocked at controller and policy level

---

## Security

* Authorization handled using Laravel Policies and Gates
* Ownership checks for Employee actions
* Permission checks at both route and UI level
* Prevents direct URL access without permission

---

## Tech Stack

* Laravel 12.x
* PHP 8+
* Manual authentication (custom login logic)
* Spatie Laravel Permission
* Bootstrap 5
* FullCalendar v6 (CDN)
* MySQL or SQLite

---

## Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd task-planner
```

### 2. Install dependencies

```bash
composer install
```

### 3. Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

Configure database settings in `.env`.

### 4. Run migrations and seeders

```bash
php artisan migrate --seed
```

Seeders will create:

* Roles
* Permissions
* A default Admin user

### 5. Start the server

```bash
php artisan serve
```

---

## Notes

* This project avoids Laravel authentication scaffolding on purpose
* Designed to keep authorization logic clear and understandable
* Useful as a reference for RBAC using a single guard

---

## License

This project is open for learning and personal use.
