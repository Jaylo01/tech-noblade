# 📑 Tech Noblade - Technical Documentation

> [!NOTE]
> Optimized for both **Light** and **Dark** modes. For a better experience, use the VS Code Markdown Preview.

---

## 🏗️ 1. System Architecture
Comprehensive view of our **Three-Tier Architecture**.

```mermaid
graph TD
    %% Classes for Dark Mode Visibility
    classDef frontend fill:#0984e3,stroke:#fff,stroke-width:2px,color:#fff;
    classDef logic fill:#6c5ce7,stroke:#fff,stroke-width:2px,color:#fff;
    classDef data fill:#2d3436,stroke:#fff,stroke-width:2px,color:#fff;
    classDef actor fill:#fdcb6e,stroke:#333,stroke-width:2px,color:#333;

    %% Elements
    Customer([👤 Customer User]):::actor
    Admin([🔑 Admin/Owner]):::actor

    subgraph "Frontend Layer (Web UI)"
        Index[index.php / Home]:::frontend
        Dash[Dynamic Dashboards]:::frontend
    end

    subgraph "Application Logic (PHP API)"
        Security[Auth Guard]:::logic
        CRUD[Order & Inventory Logic]:::logic
    end

    subgraph "Data Storage (SQL)"
        DB[Database Connection]:::data
        MySQL[(MySQL Server)]:::data
    end

    %% Flow
    Customer --> Index
    Admin --> Index
    Index --> Dash
    Dash --> CRUD
    CRUD --> Security
    Security --> DB
    DB --> MySQL

    %% Links styling
    linkStyle default stroke:#00b894,stroke-width:2px;
```

---

## 🔄 2. System Process Flows

### 2.1 The "Grab/Lazada" Flow (Simplified)
How an order travels from a click to a completed transaction.

```mermaid
graph LR
    %% Classes
    classDef step fill:#2d3436,stroke:#00b894,stroke-width:2px,color:#fff;
    classDef highlight fill:#00b894,stroke:#fff,stroke-width:2px,color:#fff;

    A[🛒 CUSTOMER: Select & Pay]:::step
    B[💾 SYSTEM: Log Pending]:::step
    C[🕵️ ADMIN: Verify Payment]:::step
    D[✅ DONE: Confirm & Send]:::highlight

    A --> B
    B --> C
    C --> D
    
    D -.-> E((Tracker 100%)):::highlight

    linkStyle default stroke:#0984e3,stroke-width:2px;
```

---

## 🗄️ 3. Database Architecture (ERD)
The relational relationships between tables.

```mermaid
erDiagram
    %% Entities with high contrast
    USERS ||--o{ ORDERS : "manages"
    USERS ||--o{ SERVICE_REQUESTS : "logs"
    PRODUCTS ||--|{ PRODUCT_SKUS : "has"
    
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

    PRODUCTS {
        int id PK
        string name UK
        string status
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

    FEEDBACK {
        int id PK
        string name
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
