# 🚀 DevBoard — Developer SaaS Dashboard

A full-stack SaaS-style developer dashboard that combines **task management, real-time collaboration, and GitHub analytics** into one unified workspace.

Built with modern web technologies and designed as a **portfolio-grade production system**.

---

## ✨ Features

### 🔐 Authentication
- GitHub OAuth login (Laravel Socialite)
- Secure session handling

### 📊 GitHub Analytics Dashboard
- Repository listing
- Commit activity overview
- Pull request tracking via GitHub API

### 🧩 Kanban Task System
- Drag & drop task management
- Column-based workflow (To Do / In Progress / Done)
- Persistent database storage

### ⚡ Real-Time Collaboration
- Laravel Reverb WebSockets
- Live task updates across users
- Activity feed synchronization

### 🧠 Activity Tracking
- Task movement history
- Real-time activity feed
- Event-driven architecture

### 🎨 UI/UX
- Dark mode (user persistent)
- Responsive design (mobile + desktop)
- Loading states + empty states

---

## 🏗️ Architecture
Frontend (Vue 3 + Inertia)
↓
Laravel API (Backend)
↓
PostgreSQL (Database)
↓
Redis (Caching + Queues)
↓
Reverb (WebSockets)


---

## 🛠️ Tech Stack

- Laravel 13
- Vue 3 (Composition API)
- Inertia.js
- Tailwind CSS
- PostgreSQL
- Redis
- Laravel Echo + Reverb
- Docker
- Vite

---

## ⚙️ Installation

```bash
git clone https://github.com/your-username/devboard.git
cd devboard/backend

composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate
npm run dev
