
# Senior .Net/PHP Developer

## Take-Home assignments

## Context
You're developing an online course platform where users can enrol in courses, view lectures, submit
assignments, and participate in forums. To manage user interactions and data access, you need a
well-designed RESTful API.

# Task

# Design and implement a RESTful API for managing user enrolments in courses. The API should support the following functionalities:
- Create Enrolment: Create a new enrolment record for a user in a specific course.
- Get Enrolment: Retrieve details of a specific user's enrolment in a course.
- Update Enrolment: Update the status of a user's enrolment (e.g., from active to completed).
- List Enrolments: Retrieve a list of all enrolments for a specific course or all enrolments for a specific user.

# Additional Requirements:
- Use standard HTTP methods (GET, POST, PUT, DELETE) for each operation.
- Define resource paths for accessing enrolments using unique identifiers.
- Implement appropriate authentication and authorization mechanisms to restrict access to
authorized users.
- Handle errors gracefully and provide informative error messages.
- Design the API for scalability and easy integration with other platform components.
# Bonus Points:
- Implement pagination for listing enrolments to handle large datasets efficiently.
- Include rate limiting to prevent API abuse.
- Use Containerized environment.
- Create example client code (e.g., using .NET or PHP) that demonstrates how to use the API.
- Document the API using OpenAPI Specification (OAS) or another standard format.
- Use GIT source control.

# Evaluation Criteria:
- Correctness and completeness of API functionality.
- Efficiency and performance of API requests.
- Quality and adherence to RESTful design principles.
- Code cleanliness, maintainability, and best practices.
- Effective use of collaboration tools to document and manage the project.

# Instructions to run this project

## Softwares need to run this project
- PHP7 or above
- Laravel8
- MySQL8
- Composer

## Setting up environment

- git clone https://github.com/naeemkhan667/netaq.git
- Rename .env.netaq to .env
- Create a database named "netaq"
- Run "Composer install" to install the dependencies
- php artisan migrate
- php artisan db:seed
- php artisan serve

## Access the APIs on the specified 
- Project documentation link
  https://documenter.getpostman.com/view/28072428/2s9YkuaeXm

## How to access API in Postman or any Http Client

POST http://127.0.0.1:8000/api/login

Body formData

- email:  user1@gmail.com
- password: password

Response
{
    "status": true,
    "message": "User successfully logged in",
    "data": {
        "name": "User1",
        "token": "1|9BN1LABgLrK0T5CqXoTSqfPtfldJpH55E0TZvcJV"
    }
}

Utilize this token as a bearer token and include it in a subsequent API request in accordance with the provided API documentation.
