# 📑 Tech Noblade - Technical Documentation

> [!IMPORTANT]
> **Technical Overview for Project Defense**
> These diagrams are optimized for high-contrast viewing. For best results, use the **VS Code Markdown Preview** in Dark Mode.

---

## 🏗️ 1. System Architecture
Our platform follows a decoupled **Three-Tier Architecture**, ensuring clear separation between User Interaction, Business Logic, and Data Persistence.

```mermaid
graph TD
    %% Theme Definitions
    classDef main fill:#1e272e,stroke:#00d2d3,stroke-width:2px,color:#fff;
    classDef layer fill:#2f3640,stroke:#fbc531,stroke-width:2px,color:#fff;
    classDef accent fill:#6c5ce7,stroke:#fff,stroke-width:2px,color:#fff;
    classDef highlight fill:#eb4d4b,stroke:#fff,stroke-width:2px,color:#fff;

    %% Elements
    User([👤 Customer User]):::accent
    Admin([🔑 Admin Portal]):::highlight

    subgraph "I. Presentation Layer (Frontend)"
        UI[PHP/HTML5 UI Pages]:::layer
        JS[JavaScript / AJAX Drivers]:::layer
    end

    subgraph "II. Application Layer (Backend Logic)"
        API[CRUD API Endpoints]:::layer
        Guard[Authentication Guard]:::layer
    end

    subgraph "III. Data Layer (Persistence)"
        Conn[PDO Connection]:::layer
        MySQL[(MySQL Database)]:::main
    end

    %% Logic Flow
    User & Admin --> UI
    UI --> JS
    JS -- "JSON Async" --> API
    API --> Guard
    Guard --> Conn
    Conn --> MySQL

    %% Link Aesthetics
    linkStyle default stroke:#00d2d3,stroke-width:2px;
```

---

## 🔄 2. System Process Flows

### 2.1 Top-Up Lifecycle (Vertical Timeline)
The specific lifecycle of a gaming transaction, showing the interaction between the system and human actors.

```mermaid
graph TD
    %% Layout
    classDef startNode fill:#00b894,color:#fff,stroke-width:0px;
    classDef midNode fill:#2d3436,color:#fff,stroke:#dfe6e9;
    classDef endNode fill:#0984e3,color:#fff,stroke-width:0px;

    S([START: User Selects Product]):::startNode
    
    Order[1. System registers 'Pending' Order]:::midNode
    Pay[2. User submits Payment Reference]:::midNode
    Verify[3. Admin verifies Transaction]:::midNode
    Final[4. System triggers Inventory Update]:::midNode

    Finish([FINISH: Customer Tracker at 100%]):::endNode

    %% Connections
    S --> Order
    Order --> Pay
    Pay --> Verify
    Verify --> Final
    Final --> Finish

    %% Timeline Accents
    linkStyle default stroke:#6c5ce7,stroke-width:3px;
```

---

## 🗄️ 3. Data Architecture (Detailed ERD)
A high-precision map of the relational database, including primary and foreign key constraints.

```mermaid
erDiagram
    %% Relationships
    USERS ||--o{ ORDERS : "manages"
    USERS ||--o{ SERVICE_REQUESTS : "logs"
    PRODUCTS ||--|{ PRODUCT_SKUS : "defines"
    
    USERS {
        int id PK
        string full_name
        string email UK
        string role "admin|customer"
    }

    ORDERS {
        string order_id PK
        string game FK
        decimal total
        string status
        int customer_id FK
    }

    PRODUCTS {
        int id PK
        string name UK
        string status "Active|Inactive"
    }

    PRODUCT_SKUS {
        int id PK
        string game FK
        string item_name
        int stock
        decimal price
    }

    SERVICE_REQUESTS {
        string reference_id PK
        string device
        string status
        int customer_id FK
    }

    FEEDBACK {
        int id PK
        string name
        string topic
        string message
        datetime timestamp
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
