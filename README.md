# Tech Noblade & Top Up - Management System

A comprehensive, responsive, and secure web-based platform designed for gaming top-ups and technical repair services. This system integrates a customer-facing portal for seamless transactions with a robust administrative dashboard for business operations.

## 🚀 Core Capabilities

### Game Top-Up Management
- **Inventory Control**: Real-time management of item availability and pricing for major titles including Mobile Legends, Roblox, and Valorant.
- **Transaction Integrity**: Secure order processing utilizing parameterized queries and server-side validation.
- **Payment Processing**: Manual verification of payment references across digital wallets and OTC methods.

### Technical Repair Hub
- **Service Lifecycle Tracking**: Integrated progress tracking from initial request through assessment and completion.
- **Resource Scheduling**: Modules for managing customer appointments and onsite pickup coordination.
- **Diagnostic Reporting**: Direct administrative interface for technical evaluations and pricing estimates.

### Administrative Oversight
- **Operational Dashboard**: High-level metrics for revenue tracking, pending requests, and inventory status.
- **Dynamic Content Management**: Unified interface for updating service statuses and maintaining product catalogs.

## 🎨 UI/UX & Design Philosophy

The system features a modern, premium aesthetic focused on responsiveness and user interaction:
- **Fluid Navigation**: A full-width, fluid top navbar designed for high-resolution displays.
- **Responsive Branding**: A standardized, centered side-navigation branding system (Logo-only) that adapts perfectly to all viewports.
- **Real-Time Tracker**: A synchronized status tracker utilizing a 3-step logic (0%, 50%, 100%) for precise visual feedback.
- **Premium Aesthetics**: Use of CSS variables, glassmorphism, and smooth micro-animations for an interactive feel.

## 🛠 Technical Architecture

The platform is organized into distinct functional modules:
- `/admin`: Administrative logic and dashboard interfaces.
- `/customer`: Public-facing transaction flows and dashboards.
- `/api`: Core logic layer (Auth, DB, Endpoints).
- `/assets`: Centralized styling (CSS variables), logic (JS), and media.
- `/shared`: Reusable UI components and session guards.

## ⚙️ Deployment and Configuration

1. **Prerequisites**: PHP 7.4+, MySQL 5.7+ (Port 3307 recommended).
2. **Database Initialization**: Import the consolidated schema from `db/schema.sql`.
3. **Configuration**: Database connection parameters are centralized in `api/db.php`.
4. **Access Points**:
   - Main Portal: `http://localhost/tech-noblade/index.php`
   - Admin Portal: `http://localhost/tech-noblade/admin/login.php`

## 🔒 Security Standards

- **Data Protection**: Prepared statements across all endpoints to prevent SQL injection.
- **Access Control**: Role-Based Access Control (RBAC) via server-side session management.
- **Infrastructure**: Hardened directory structure to prevent unauthorized access to core logic.

---
**Tech Noblade & Top Up** - *Smart Solutions for Phones and Gamers.*
