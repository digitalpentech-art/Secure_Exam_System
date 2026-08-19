# Security Documentation

## Implemented Security Controls
- **Authentication:** Password hashing using Laravel's `Hash` (bcrypt), MFA via OTP for exam sessions.
- **Access Control:** Role-Based Access Control (RBAC) enforced via `RoleMiddleware`.
- **Input Security:** Laravel Request Validation on all forms/endpoints to prevent malicious input.
- **CSRF Protection:** Laravel's built-in CSRF middleware.
- **Logging:** Comprehensive `activity_logs` tracking user events.
- **Database:** Prepared statements (via Eloquent ORM) to prevent SQL injection.
