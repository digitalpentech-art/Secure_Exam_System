# Database Documentation

The system uses a normalized MySQL database structure.

## Core Entities
- **Users**: Authentication, roles, profile.
- **Courses**: Academic courses.
- **Examinations**: Exam metadata (timing, status).
- **Questions**: Objective questions linked to examinations.
- **ExaminationSessions**: Active student examination sessions.
- **Answers**: Student responses linked to sessions.
- **Results**: Final scores, grades, and percentage.
- **ActivityLogs**: Audit trails for all critical user actions.
- **OtpRecords**: Temporary OTP storage.
