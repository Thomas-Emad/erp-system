
This project is a comprehensive **Enterprise Resource Planning (ERP) System** API developed by [Belal Elattar](https://github.com/BelalElattar1) and myself. The system focuses on core business operations including HR management, inventory control, manufacturing, sales, purchasing, installment management, and maintenance. It was built purely as an API to ensure flexibility and easy integration with other systems.

Our goal was to create a functional ERP system that handles multiple departments in a business while ensuring a secure and scalable architecture. This was designed as a training project, so while it covers key features of an ERP system, some aspects might differ from typical real-world implementations.

### Key Features:

#### 1. Human Resources (HR) Management:

-   **Attendance and Leave Tracking**: Records employee attendance and manages absences, with automatic deductions or bonuses based on lateness or early departures.
-   **Payroll**: Automates salary payments, attaching proof of payment and deducting amounts from company accounts.
-   **Leave Requests**: Employees can submit leave requests which management can approve or reject.
-   **Task Management**: Managers can assign tasks, and bonuses or deductions are automatically applied based on timely task completion.

#### 2. Inventory Management:

-   **Stock Control**: Monitors product stock levels, including alerts for products nearing expiration.

#### 3. Manufacturing:

-   **Machine Monitoring**: Tracks the operational status of machines, noting when they require maintenance.
-   **Raw Material Management**: Manages the stock of raw materials in the factories.

#### 4. Production Request Management:

-   **Production Scheduling**: Assigns factories and warehouses for product manufacturing, ensuring raw materials are available before production begins.

#### 5. Sales Management:

-   **Order Management**: Tracks product orders, quantities, and shipping costs, while handling inventory and stock levels.

#### 6. Supplier and Purchase Management:

-   **Purchase Orders**: Manages raw material orders, storing them in the designated factory while factoring in shipping costs.

#### 7. Installment Management:

-   **Installment Registration**: Supports the registration of weekly, monthly, or yearly installments for clients, allowing flexible payment options.
-   **Payment Due Reminders**: Sends automatic reminders to clients for upcoming installment payments.
-   **Supplier Installments**: Tracks installment payments with suppliers for purchase orders.
-   **Sales Installments**: Allows installment-based sales for clients, enhancing payment flexibility.
-   **Custom Payment Portfolios**: Each installment has a dedicated portfolio to accommodate extra payments beyond the regular amount.
-   **Detailed Reports**: Provides reports on remaining and paid installments for each client, assisting in tracking financial collections.

#### 8. Maintenance:

-   **Machine Repairs**: Logs machine repair details, including associated costs and schedules for maintenance.

#### 9. Transfers:

-   **Product Transfers**: Facilitates the movement of products between warehouses.
-   **Raw Material Transfers**: Handles the transfer of raw materials between factories.

#### 10. Reporting:

-   The system includes **20 detailed reports** covering various operational aspects of the ERP system.

### Security:

We took several measures to ensure the security of the API:

-   **Secret Key Authentication**: Each request to the API is authenticated using a secret key.
-   **Brute Force Attack Protection**: Implemented rate limiting to guard against brute force attacks by capping the number of requests allowed within a certain time frame.
-   **CORS**: Enabled CORS to control which domains can access the API, providing an extra layer of security.

----------

### Technology Stack:

-   **Laravel**: Backend framework for API development.
-   **MySQL**: Database for managing ERP data.
-   **JWT Authentication**: For secure API access and user authentication.

----------

### Contribution and Feedback:

This project was a hands-on learning experience for us, and we’re continuously looking for ways to improve it. Feel free to check out the code and suggest any improvements or optimizations. If you're interested in contributing, pull requests are welcome.
