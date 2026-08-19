# API Documentation (Key Endpoints)

## Authentication
- `POST /register`: Register a new user.
- `POST /login`: Login and generate OTP.
- `POST /verify-otp`: Verify OTP.

## Management (Admin/Lecturer)
- `GET/POST/PUT/DELETE /courses`: Manage courses.
- `GET/POST/PUT/DELETE /examinations`: Manage examinations.
- `GET/POST/PUT/DELETE /questions`: Manage questions.

## Examination Engine (Student)
- `POST /exams/{id}/start`: Start examination.
- `GET /sessions/{id}/questions`: Get randomized questions.
- `POST /sessions/{id}/submit`: Submit answers.

## Anti-Cheating
- `POST /security/log`: Log suspicious browser events.

## Dashboard
- `GET /dashboard`: Get role-specific dashboard data.
