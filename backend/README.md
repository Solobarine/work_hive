# Work Hive - Task Management Platform

**Work Hive** is a robust task management platform designed to simplify project and team collaboration. It offers essential tools for managing tasks, projects, and teams, with real-time updates and notifications to keep everyone in sync.

## Features

1. **User Authentication**

    - Register, Login, Logout functionality to manage user access securely.

2. **Task Management**

    - Create, Read, Update, Delete (CRUD) tasks to ensure smooth task handling and monitoring.

3. **Project Management**

    - Full CRUD operations for managing projects, allowing users to organize tasks by project.

4. **Team Management**

    - Assign users to projects for easy team collaboration and responsibility sharing.

5. **Real-time Updates**

    - WebSocket integration for instant task status updates, ensuring that all team members are on the same page.

6. **Notifications**

    - Email notifications to inform users of any updates on their tasks, improving overall communication.

## Technologies

-   **PHP**: Backend programming language.
-   **Laravel**: PHP framework used to build the application.
-   **MySQL**: Relational database management system for data storage.
-   **Pest**: Testing framework for ensuring code quality and reliability.

## Getting Started

### Prerequisites

-   PHP >= 8.1
-   Composer
-   MySQL

### Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/solobarine/work_hive.git
    ```
2. Navigate into the project directory:

    ```bash
    cd work_hive
    ```

3. Install PHP dependencies:

    ```bash
    composer install
    ```

4. Create a copy of the `.env` file:

    ```bash
    cp .env.example .env
    ```

5. Generate the application key:

    ```bash
    php artisan key:generate
    ```

6. Generate JWT Secret

    ```bash
    php artisan jwt:secret
    ```

7. Set up your database in the `.env` file and run migrations:

    ```bash
    php artisan migrate
    ```

8. Run the application:
    ```bash
    php artisan serve
    ```

### Running Tests

To run the tests using Pest, execute:

```bash
php artisan test
```

## Contributing

Contributions are welcome! Please submit a pull request for any changes you would like to see.

## License

Work Hive is open-source and available under the [MIT License](LICENSE).

---

Let's streamline task management and team collaboration with Work Hive!
