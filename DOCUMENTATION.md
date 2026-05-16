# 📑 Tech Noblade & Top Up - Technical Documentation

This document provides a comprehensive technical overview of the Tech Noblade & Top Up management system, detailing its architecture, data flows, and security implementations.

---

## 🏗️ 1. System Architecture
The platform follows a **Three-Tier Architecture**, designed for high maintainability and security.

```mermaid
graph TD
    %% Users
    Customer((Customer))
    Admin((Admin))

    subgraph "Frontend Layer (UI)"
        Index[index.php / Landing]
        CustDash[customer/dashboard.php]
        AdminDash[admin/dashboard.php]
        StatusTrack[receipt.php / Tracker]
    end

    subgraph "Logic & Security (Middleware)"
        AuthGuard[api/auth_admin_guard.php]
        DB_Conn[api/db.php]
        NavShared[shared/nav.php]
    end

    subgraph "API Layer (JSON Endpoints)"
        AuthAPI[api/auth_login.php]
        OrderAPI[api/crud/api_orders.php]
        InventoryAPI[api/crud/api_inventory.php]
        ReportAPI[api/api_reports.php]
    end

    subgraph "Data Layer"
        MySQL[(MySQL / Port 3307)]
    end

    %% Connections
    Customer --> Index
    Admin --> AdminDash
    
    Index --> AuthAPI
    CustDash -- "Fetch" --> OrderAPI
    StatusTrack -- "Polling" --> OrderAPI
    
    AdminDash -- "Admin Guard" --> AuthGuard
    AdminDash -- "Fetch" --> InventoryAPI
    
    OrderAPI & InventoryAPI & AuthAPI --> DB_Conn
    DB_Conn --> MySQL
```

---

## 🔄 2. System Process Flows

### 2.1 Order & Top-Up Lifecycle
Simplified flow of a gaming top-up transaction from request to fulfillment.

```mermaid
sequenceDiagram
    participant C as Customer
    participant F as Frontend (UI)
    participant A as API (PHP)
    participant D as Database (MySQL)
    participant AD as Admin Dashboard

    C->>F: Selects Game & Product
    C->>F: Enters UserID & ZoneID
    F->>A: Checks Stock Availability
    A->>D: Query Inventory
    D-->>A: Stock OK
    A-->>F: Proceed to Payment
    C->>F: Submits Payment Reference
    F->>A: POST Create Order
    A->>D: Save Order (Status: Pending)
    D-->>A: Order Saved
    A-->>F: Show Receipt / Start Tracker
    AD->>A: Admin Verifies Payment
    A->>D: Update Status (Confirmed)
    D-->>A: Updated
    A-->>F: Tracker UI Updates (0% -> 50% -> 100%)
```

---

## 🗄️ 3. Database Architecture (ERD)
The system utilizes a relational schema optimized for transaction integrity.

```mermaid
erDiagram
    USERS ||--o{ ORDERS : "places"
    USERS ||--o{ SERVICE_REQUESTS : "requests"
    PRODUCTS ||--|{ PRODUCT_SKUS : "contains"
    
    USERS {
        int id PK
        string full_name
        string email UK
        string password_hash
        string role
    }

    ORDERS {
        int id PK
        string order_id UK
        string game
        string item
        decimal total
        string status
        int customer_id FK
    }

    PRODUCTS {
        int id PK
        string name UK
        string status
    }

    PRODUCT_SKUS {
        int id PK
        string game FK
        string item_name
        decimal price
        int stock
    }

    SERVICE_REQUESTS {
        int id PK
        string reference_id UK
        string device
        string status
        int customer_id FK
    }

    FEEDBACK {
        int id PK
        string name
        string email
        string topic
        string message
    }
```

---

## 🔒 4. Security Implementation Details

### 4.1 SQL Injection Mitigation
All database interactions are performed using **Prepared Statements**.
*   **Implementation:** `PDO::prepare()` or `mysqli::prepare()`.

### 4.2 Role-Based Access Control (RBAC)
Server-side session validation is enforced on all administrative endpoints via `api/auth_admin_guard.php`.

### 4.3 Data Encryption
Passwords are encrypted using **Bcrypt Hashing** via `password_hash()`.

---

## 🛠️ 5. Deployment Guide
1.  **Prerequisites:** PHP 7.4+, MySQL (Port 3307).
2.  **Database Connection:** Centralized in `api/db.php`.
3.  **Initialization:** Execute `db/schema.sql`.
