# Project Overview

- [Description](#description)
- [Models](#models)
- [API Endpoints](#api-endpoints)
- [Testing](#testing)
- [Usage](#usage)

## Description
This project is a Laravel-based web application designed to manage teams, projects, and users(members). It provides a RESTful API to perform CRUD (Create, Read, Update, Delete) operations on teams, projects, and users and much more like fetching members of a specific project etc.

## Models
### Team
- Attributes:
  - `name`: Name of the team.

### Project
- Attributes:
  - `name`: Name of the project.
  - `team_id`: Foreign key linking the project to a team.

### User(Member)
- Attributes:
  - `first_name`: First name of the user.
  - `last_name`: Last name of the user.
  - `city`: City where the user resides.
  - `state`: State where the user resides.
  - `country`: Country where the user resides.
  - `team_id`: Foreign key linking the user to a team.

## API Endpoints

### Teams
- **Fetch All Teams**
  - Endpoint: `GET /api/v1/teams`
  - Returns a list of all teams.

- **Create New Team**
  - Endpoint: `POST /api/v1/teams`
  - Payload: 
    ```json
      { 
        "name": "New Team"
      }
    ```
  - Creates a new team.

- **Fetch One Team**
  - Endpoint: `GET /api/v1/teams/{team_id}`
  - Returns details of a specific team.

- **Update Team**
  - Endpoint: `PATCH /api/v1/teams/{team_id}`
  - Payload: 
    ```json
      {
        "name": "Updated Team"
      }
      ```
  - Updates the details of a specific team.

- **Delete Team**
  - Endpoint: `DELETE /api/v1/teams/{team_id}`
  - Deletes a specific team.

### Projects
- **Fetch All Projects**
  - Endpoint: `GET /api/v1/projects`
  - Returns a list of all projects.

- **Create New Project**
  - Endpoint: `POST /api/v1/projects`
  - Payload: 
      ```json
          { 
            "name": "New Project", 
            "team_id": 1 
          }
      ```
  - Creates a new project.

- **Fetch One Project**
  - Endpoint: `GET /api/v1/projects/{project_id}`
  - Returns details of a specific project.

- **Update Project**
  - Endpoint: `PATCH /api/v1/projects/{project_id}`
  - Payload: 
    ```json
        { 
          "name": "Updated Project"
        }
    ```
  - Updates the details of a specific project.

- **Delete Project**
  - Endpoint: `DELETE /api/v1/projects/{project_id}`
  - Deletes a specific project.

### Users
- **Fetch All Users**
  - Endpoint: `GET /api/v1/users`
  - Returns a list of all users.

- **Create New User**
  - Endpoint: `POST /api/v1/users`
  - Payload: 
    ```json
        {
          "first_name": "John", 
          "last_name": "Doe", 
          "city": "New City", 
          "state": "New State", 
          "country": "New Country", 
          "team_id": 1 
        }
    ```
  - Creates a new user.

- **Fetch One User**
  - Endpoint: `GET /api/v1/users/{user_id}`
  - Returns details of a specific user.

- **Update User**
  - Endpoint: `PATCH /api/v1/users/{user_id}`
  - Payload: 
    ```json
        { 
          "first_name": "Updated First Name", 
          "last_name": "Updated Last Name", 
          "city": "Updated City", 
          "state": "Updated State", 
          "country": "Updated Country" 
        }
    ```


  - Updates the details of a specific user.

- **Delete User**
  - Endpoint: `DELETE /api/v1/users/{user_id}`
  - Deletes a specific user.

## Testing
The project includes PHPUnit tests for various API endpoints, ensuring proper functionality and data consistency.

## Usage
To use the API, make HTTP requests to the specified endpoints using the provided methods (GET, POST, PATCH, DELETE). Ensure proper payload formatting for creation and update operations.

