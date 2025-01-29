# School Management System

This is a **School Management System** built using **PHP** and **MySQL**. It allows administrators, professors, and students to interact with the system for managing schedules, absences, and declarations.

## Features

### Roles and Functionalities
1. **Admin**:
   - Manage student schedules (add/update class schedules).
   - View and respond to professor declarations.
   - Validate or reject student absence justifications.
   - Delete records (absences, declarations).

2. **Professor**:
   - View their assigned classes.
   - Submit declarations to the admin.
   - View responses from the admin.

3. **Student**:
   - View their class schedule.
   - Submit absence justifications.
   - View the status of their absence requests (approved/rejected).

### Database
- The database (`ensem`) contains tables for:
  - **Admin**: `ad`
  - **Professors**: `prof`
  - **Students**: `eleve`
  - **Absences**: `absence`
  - **Declarations**: `chat`
  - **Schedules**: `emploi`

---

## Installation and Setup

### Prerequisites
- **PHP** (version 8.2 or higher recommended).
- **MySQL** (or MariaDB).
- **phpMyAdmin** (optional, for database management).
- A web server like **Apache** or **XAMPP**.


View assigned classes.

Submit declarations to the admin.

View admin responses.

