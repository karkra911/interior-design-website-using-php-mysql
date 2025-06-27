# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Initial project documentation
- Contributing guidelines
- Security policy

### Changed
- Updated database configuration for hosting compatibility

### Security
- Improved SQL injection prevention with prepared statements

## [1.0.0] - 2024-12-27

### Added
- User registration and authentication system
- Code snippet creation, editing, and deletion
- Tagging system for snippet organization
- User dashboard for snippet management
- Responsive Bootstrap-based UI
- Session management
- Error handling and user feedback
- Basic search functionality

### Security
- Password hashing using PHP's password_hash()
- SQL injection prevention with prepared statements
- Input validation and sanitization
- Secure session handling

### Database
- Users table with secure password storage
- Snippets table with user relationships
- Tags and snippet_tags tables for categorization
- Proper foreign key constraints

### UI/UX
- Clean, modern interface
- Mobile-responsive design
- Bootstrap 4 integration
- Intuitive navigation
- User-friendly forms

## [0.1.0] - 2024-12-20

### Added
- Initial project structure
- Basic PHP files setup
- Database schema design
- Core functionality planning

---

## Types of Changes

- `Added` for new features.
- `Changed` for changes in existing functionality.
- `Deprecated` for soon-to-be removed features.
- `Removed` for now removed features.
- `Fixed` for any bug fixes.
- `Security` in case of vulnerabilities.
