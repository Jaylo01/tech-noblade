 Tech Noblade & Top Up - Management System

A comprehensive, responsive, and secure web-based platform designed for gaming top-ups and technical repair services. This system integrates a customer-facing portal for seamless transactions with a robust administrative dashboard for business operations.

 Core Capabilities

 Game Top-Up Management
 Inventory Control: Real-time management of item availability and pricing for major titles including Mobile Legends, Roblox, and Valorant.
 Transaction Integrity: Secure order processing utilizing parameterized queries and server-side validation to ensure data consistency.
 Payment Processing: Facilitates manual verification of payment references across multiple providers including digital wallets and over-the-counter methods.

 Technical Repair Hub
 Service Lifecycle Tracking: Integrated progress tracking from initial request through diagnostic assessment and completion.
 Resource Scheduling: Modules for managing customer appointments and onsite pickup coordination for service requests.
 Diagnostic Reporting: Direct administrative interface for providing technical evaluations and price estimates.

 Administrative Oversight
 Operational Dashboard: High-level metrics for revenue tracking, pending requests, and inventory status.
 Dynamic Content Management**: Unified interface for updating service statuses, managing feedback, and maintaining product catalogs.

 Technical Architecture

The platform is organized into distinct functional modules:
 1. /admin: Administrative logic and dashboard interfaces.
 2. /customer: Public-facing transaction flows and customer dashboards.
 3. /api: Core logic layer handling authentication, database interactions, and service endpoints.
 4. /assets: Centralized repository for styling, scripting, and media assets.
 5. /shared: Reusable UI components and session management guards.

 Deployment and Configuration
1. Prerequisites**: PHP 7.4+, MySQL 5.7+ (configured on port 3307 for local environments).
2. Database Initialization: Initialize the system by importing the consolidated schema located at `db/schema.sql`.
3. Configuration: Database connection parameters are centralized in `api/db.php`.
4. Access Points: 
    Main Portal: `http://localhost/tech-noblade/index.php`
    Administrative Portal: `http://localhost/tech-noblade/admin/login.php`

 Security Standards
 Data Protection: Implementation of prepared statements across all API endpoints to prevent SQL injection vulnerabilities.
 Access Control: Role-Based Access Control (RBAC) enforced through server-side session management.
 Infrastructure: Hardened directory structure to prevent unauthorized access to core logic files.

---
Tech Noblade & Top Up - Smart Solutions for Phones and Gamers.
