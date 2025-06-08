# Job Board API

A RESTful API for managing job listings, companies, and user applications, built with Laravel. This API is designed to serve as the backend for a job board application, providing endpoints to manage jobs, companies, users, and their applications.

## Features

- **Authentication & Roles**:
  - User and Company login/logout
  - Role-based API access using Laravel Sanctum
- **Job Listings**: CRUD operations for job postings
- **Applications**: Users can apply to jobs and view their applications
- **Users**: Register, login, set industry, add preferred positions
- **Companies**: Register, login, manage company profile
- **Industries & Types**: Categorize jobs and companies by industry and contract type
- **Positions**: Manage job position titles
- **Company Discovery**:
  - Search by industry
  - Lookup by name

## Technologies Used

- PHP 8+
- Laravel Framework
- MySQL or any supported relational database
- Laravel Sanctum for authentication
- Postman (for API testing)

---


>⚙️ To run this project locally, set up a Laravel environment, run migrations.
> Postman was used for testing the API endpoints.


### Sample Endpoints

#### 🔐 Authentication
- `POST /user/login` – User login
- `POST /company/login` – Company login
- `POST /addCompany` – Register a new company
- `POST /user/logout` – Logout user (auth required)

#### 👤 User Management
- `GET /user/applications` – View user's job applications
- `GET /user/industry` – Get user’s industry
- `GET /user/positions` – View preferred positions
- `GET /user/role` – Get user role
- `POST /user/addPosition` – Add a preferred position
- `GET /user/setIndustry` – Set user industry

#### 🏢 Company Routes
- `GET /allCompanies` – List all companies
- `GET /showCompany` – Show company info (auth)
- `GET /showCompanyByName` – Find company by name

#### 🏭 Industry Features
- `GET /industry/{industry_id}/companies` – Companies by industry

Note:
This README includes a selection of the core endpoints. The project contains additional routes and features not listed here. Explore the controllers and route files for the full implementation.


#### 📄 RESTful Resources (CRUD)
- `users` → UserController
- `jobs` → JobController
- `applications` → ApplicationController
- `industries` → IndustryController
- `types` → TypeController
- `positions` → PositionController
- `companies` → CompanyController

---

## Author

**Dimitri Khnaisser**

This project is part of my journey into backend development using Laravel. It demonstrates my understanding of RESTful principles, database relationships, authentication, role-based access control, and clean code architecture.

---

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
