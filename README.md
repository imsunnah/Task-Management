# Task Planner & Calendar with Role-Based Access Control

A Laravel application with **Admin** and **Employee** roles implementing secure Role-Based Access Control (RBAC) using **Laravel Gates**, **Policies**, and **Spatie Laravel Permission** package. Includes a full **Task Planner** (CRUD) and **Calendar Event Management** with FullCalendar.js, with strict permission-based visibility and actions.

## Features

- **Authentication** — Single `web` guard with role-based logic (no multi-guard complexity)
- **Roles** — Admin (full access) · Employee (restricted by permissions)
- **Granular Permissions** (via Spatie/laravel-permission)
  - Tasks: `view`, `view_any`, `create`, `update`, `delete`
  - Events: `view`, `view_any`, `create`, `update`, `delete`
  - Admin-only: `user.manage`
- **Default Permissions for New Employees** — Only `task.view` and `event.view` (own items only)
- **Admin User Management** — Create users
- **Task Planner**
  - Title, Description, Assigned Employee, Status, Priority, Due Date & Time
  - Admin assigns tasks · Employees see/manage only their own (if permitted)
- **Calendar & Events**
  - FullCalendar.js (month/week/day views)
  - Event name, date, start/end time, optional related task
  - Admin sees all events · Employees see only their assigned events
- **UI** — Clean Bootstrap + Blade templates, permission-aware buttons (hide edit/delete when not allowed)
- **Security** — Authorization via Policies + ownership checks for employees

## Tech Stack

- **Framework**: Laravel 12.x
- **Authentication**: Manual Authentication
- **Authorization**: Laravel Gates & Policies
- **Frontend**: Bootstrap 5, FullCalendar v6 (CDN)
- **Database**: MySQL / SQLite (configurable)

## Installation

1. Clone the repository

```bash
git clone <repository-url>
cd task-planner
```bash
2.Install dependencies

```bash
composer install****

3.Copy environment file and configure

```bash
cp .env.example .env

4.Run migrations & seed initial data
```bash
php artisan migrate --seed

5.Start development server
```bash
php artisan serve

