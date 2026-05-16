# 📑 Tech Noblade & Top Up - Technical Documentation

This document provides a comprehensive technical overview of the Tech Noblade & Top Up management system, detailing its architecture, data flows, and security implementations.

---

## 🏗️ 1. System Architecture
The platform follows a **Three-Tier Architecture**, designed for high maintainability and security.

```mermaid
graph TD
    %% Users
    Customer([Customer User])
    Admin([Admin/Owner])

    subgraph "Frontend Layer"
        Index[index.php / Landing]
        Dashboards[Customer & Admin Dashboards]
        Tracker[receipt.php / Order Tracker]
    end

    subgraph "Logic & API Layer (Middleware)"
        Security[api/auth_admin_guard.php]
        CRUD_API[api/crud/api_orders.php<br/>api/crud/api_inventory.php]
    end

    subgraph "Data Persistence"
        DB_Conn[api/db.php]
        MySQL[(MySQL Database)]
    end

    %% Flow of Connection
    Customer --> Index
    Admin --> Index
    Index --> Dashboards
    Dashboards --> Tracker
    
    Tracker -. "AJAX Data" .-> CRUD_API
    Dashboards -. "Fetch Requests" .-> CRUD_API
    
    CRUD_API --> Security
    Security --> DB_Conn
    DB_Conn --> MySQL

    %% Styling
    style MySQL fill:#f9f,stroke:#333,stroke-width:2px
    style CRUD_API fill:#bbf,stroke:#333,stroke-width:1px
```

---

## 🔄 2. System Process Flows

### 2.1 Order & Top-Up Lifecycle
Simplified flow of a gaming top-up transaction from request to fulfillment.

```mermaid
graph LR
    A[Customer Order] --> B{Stock Check}
    B -- Yes --> C[Payment Reference Submission]
    B -- No --> D[Disabled Button]
    
    C --> E[Admin Verification]
    E --> F[Status: Processing]
    F --> G[Status: Confirmed]
    
    G --> H((Order Delivered))

    %% Connection to Code
    style A fill:#dfd
    style E fill:#fff4dd
    style H fill:#d4edda
```

---

## 🗄️ 3. Database Architecture (ERD)
The system utilizes a relational schema optimized for transaction integrity.

```mermaid
erDiagram
    USERS ||--o{ ORDERS : "manages"
    USERS ||--o{ SERVICE_REQUESTS : "logs"
    PRODUCTS ||--|{ PRODUCT_SKUS : "has_inventory"
    
    USERS {
        int id PK
        string full_name
        string role
    }

    ORDERS {
        string order_id PK
        decimal total
        string status
        int customer_id FK
    }

    PRODUCT_SKUS {
        int id PK
        string item_name
        int stock
    }

    SERVICE_REQUESTS {
        string reference_id PK
        string device
        string status
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
