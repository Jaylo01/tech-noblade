# 📑 Tech Noblade - Technical Documentation

> [!IMPORTANT]
> **Technical Overview for Project Defense**
> These diagrams are optimized for **Premium High-Contrast** viewing. For best results, use the **VS Code Markdown Preview** in Dark Mode.

---

## 🏗️ 1. System Architecture (3-Tier Model)
Our platform is engineered with a strict **Separation of Concerns**, ensuring security and scalability.

```mermaid
graph TD
    %% Global Styles
    classDef main fill:#1e272e,stroke:#00d2d3,stroke-width:3px,color:#fff;
    classDef layer fill:#2d3436,stroke:#fbc531,stroke-width:2px,color:#fff;
    classDef accent fill:#6c5ce7,stroke:#fff,stroke-width:2px,color:#fff;
    classDef dbNode fill:#2d3436,stroke:#eb4d4b,stroke-width:3px,color:#fff;

    %% Nodes
    User([👤 Customer User]):::accent
    Admin([🔑 Admin Portal]):::accent

    subgraph "I. Presentation Layer"
        UI[View: PHP & HTML5]:::layer
        JS[Driver: JavaScript / AJAX]:::layer
    end

    subgraph "II. Application Layer"
        API[Logic: CRUD API]:::layer
        Guard[Auth: Session Guard]:::layer
    end

    subgraph "III. Data Layer"
        Conn[PDO Connection]:::dbNode
        MySQL[(MySQL Server)]:::dbNode
    end

    %% Flow
    User & Admin --> UI
    UI --> JS
    JS -- "Async JSON" --> API
    API --> Guard
    Guard --> Conn
    Conn --> MySQL

    %% Link Styling
    linkStyle default stroke:#00d2d3,stroke-width:2px;
```

---

## 🔄 2. Order Lifecycle Flow
A simplified timeline of a gaming transaction from request to fulfillment.

```mermaid
graph LR
    %% Theme
    classDef nodeStyle fill:#1e272e,stroke:#00d2d3,stroke-width:2px,color:#fff;
    classDef doneStyle fill:#00b894,stroke:#fff,stroke-width:2px,color:#fff;
    classDef lineStyle stroke-width:3px;

    A[🛒 CUSTOMER: Checkout]:::nodeStyle
    B[💾 SYSTEM: Log Pending]:::nodeStyle
    C[🕵️ ADMIN: Payment Check]:::nodeStyle
    D[✅ SUCCESS: Delivery]:::doneStyle

    A --> B
    B --> C
    C --> D
    
    D -.-> E((Tracker UPDATED)):::doneStyle

    linkStyle 0,1,2 stroke:#6c5ce7,stroke-width:3px;
```

---

## 🗄️ 3. Data Architecture (Visual ERD)
High-fidelity representation of the relational database structure.

```mermaid
graph TD
    %% Table Styles
    classDef table fill:#2d3436,stroke:#fbc531,stroke-width:2px,color:#fff;
    classDef primary fill:#eb4d4b,stroke:#fff,stroke-width:1px,color:#fff;
    classDef linked fill:#0984e3,stroke:#fff,stroke-width:1px,color:#fff;

    subgraph "Core: Users & Access"
        USERS["TABLE: Users<br/>- id (PK)<br/>- full_name<br/>- email<br/>- role"]:::table
    end

    subgraph "Transactions: Orders"
        ORDERS["TABLE: Orders<br/>- order_id (PK)<br/>- customer_id (FK)<br/>- game<br/>- status"]:::table
    end

    subgraph "Inventory: Products"
        PRODUCTS["TABLE: Products<br/>- id (PK)<br/>- name (UK)<br/>- status"]:::table
        SKUS["TABLE: Product_SKUs<br/>- id (PK)<br/>- game (FK)<br/>- stock"]:::table
    end

    subgraph "Support: Service & Feedback"
        SR["TABLE: Service_Requests<br/>- reference_id (PK)<br/>- device<br/>- status"]:::table
        FB["TABLE: Feedback<br/>- id (PK)<br/>- topic<br/>- message"]:::table
    end

    %% Relationships
    USERS -- "1:M" --> ORDERS
    USERS -- "1:M" --> SR
    PRODUCTS -- "1:M" --> SKUS

    %% Style Overrides
    USERS:::primary
    ORDERS:::linked
    PRODUCTS:::primary
    SR:::linked
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
