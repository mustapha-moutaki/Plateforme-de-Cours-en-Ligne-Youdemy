# Youdemy - Online Course Platform

## Project Context
The Youdemy online course platform aims to revolutionize learning by providing an interactive and personalized system for students and teachers.

## Required Features

### Front Office

#### Visitor
- Access to the course catalog with pagination.
- Course search by keywords.
- Account creation with role selection (Student or Teacher).

#### Student
- View the course catalog.
- Search and view course details (description, content, teacher, etc.).
- Enroll in a course after authentication.
- Access a "My Courses" section that groups joined courses.

#### Teacher
- Add new courses with details such as:
  - Title
  - Description
  - Content (video or document)
  - Tags
  - Category
- Course management:
  - Modification, deletion, and consultation of enrollments.
- Access to a "Statistics" section on courses:
  - Number of enrolled students
  - Number of courses, etc.

### Back Office

#### Administrator
- Validate teacher accounts.
- User management:
  - Activation, suspension, or deletion.
- Content management:
  - Courses, categories, and tags.
- Bulk insertion of tags for efficiency.
- Access to global statistics:
  - Total number of courses
  - Distribution by category
  - Course with the most students
  - Top 3 teachers.

## Cross-Functional Features
- A course can contain multiple tags (many-to-many relationship).
- Application of polymorphism in the following methods:
  - Add course
  - Display course
- Authentication and authorization system to protect sensitive routes.
- Access control: each user can only access features corresponding to their role.

## Technical Requirements
- Adherence to OOP principles (encapsulation, inheritance, polymorphism).
- Relational database with relationship management (one-to-many, many-to-many).
- Use of PHP sessions for managing logged-in users.
- User data validation system to ensure security.

## Bonus Features
- Advanced search with filters (category, tags, author).
- Advanced statistics:
  - Engagement rate by course
  - Most popular categories.
- Implementation of a notification system:
  - For example, teacher account validation or course enrollment confirmation.
- Implementation of a commenting or evaluation system for courses.
- Generation of PDF completion certificates for students.

## Installation
Instructions to clone the repository and set up the environment.

```bash
git clone https://github.com/mustapha-moutaki/Plateforme-de-Cours-en-Ligne-Youdemy.git
cd youdemy

