# KobFlow API Gateway

This is a **PHP API** that serves as the communication layer between the various microservices inside the **KobFlow** application.

It uses **cURL** calls to send and receive requests between services, acting as a central point for inter-service communication.

---

### 🧩 Purpose
- Handles communication between internal services (Auth, Users, Expenses, etc.)
- Standardizes request and response formats
- Simplifies integration within the KobFlow ecosystem

---

### ⚙️ Requirements
- PHP 8.0+  
- cURL extension enabled

---

### 🚀 Quick Start
```bash
git clone https://github.com/kuaminika/KobFlowAPIGateway.git
cd KobFlowAPIGateway
php -S localhost:8080
