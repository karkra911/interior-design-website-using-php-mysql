# Contributing to CodeVault

Thank you for your interest in contributing to CodeVault! We welcome contributions from developers of all skill levels.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [How to Contribute](#how-to-contribute)
- [Development Setup](#development-setup)
- [Coding Standards](#coding-standards)
- [Pull Request Process](#pull-request-process)
- [Reporting Issues](#reporting-issues)

## Code of Conduct

By participating in this project, you agree to abide by our Code of Conduct. Please be respectful, inclusive, and constructive in all interactions.

## Getting Started

1. Fork the repository on GitHub
2. Clone your fork locally
3. Set up the development environment (see Development Setup below)
4. Create a branch for your feature or bug fix
5. Make your changes
6. Test your changes thoroughly
7. Submit a pull request

## How to Contribute

### Types of Contributions

- **Bug Reports**: Help us identify and fix issues
- **Feature Requests**: Suggest new functionality
- **Code Contributions**: Fix bugs or implement new features
- **Documentation**: Improve or add documentation
- **Testing**: Add or improve test coverage

### Areas Where Help is Needed

- UI/UX improvements
- Security enhancements
- Performance optimizations
- Mobile responsiveness
- Additional features (export/import, snippet sharing, etc.)
- Code organization and refactoring
- Documentation improvements

## Development Setup

1. **Prerequisites**
   - PHP 7.4 or higher
   - MySQL 5.7 or higher
   - Web server (Apache/Nginx) or PHP built-in server

2. **Clone and Setup**
   ```bash
   git clone https://github.com/yourusername/codevault.git
   cd codevault
   ```

3. **Database Setup**
   ```bash
   mysql -u root -p
   CREATE DATABASE codevault_dev;
   USE codevault_dev;
   SOURCE database.sql;
   ```

4. **Configure Database**
   - Copy `includes/db.php` and update with your local database credentials
   - Ensure your local database is running

5. **Start Development Server**
   ```bash
   php -S localhost:8000
   ```

## Coding Standards

### PHP Standards

- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Comment complex logic
- Use prepared statements for all database queries
- Validate and sanitize all user inputs
- Handle errors gracefully

### HTML/CSS Standards

- Use semantic HTML5 elements
- Maintain Bootstrap compatibility
- Ensure responsive design
- Use consistent indentation (2 spaces)
- Optimize for accessibility

### JavaScript Standards

- Use modern JavaScript (ES6+)
- Comment complex functions
- Maintain jQuery compatibility where used
- Use consistent formatting

### Database Standards

- Use meaningful table and column names
- Include proper indexes
- Maintain referential integrity
- Include appropriate constraints

## Pull Request Process

1. **Before Starting**
   - Check existing issues and PRs to avoid duplication
   - Create an issue to discuss major changes before implementing

2. **Creating a Pull Request**
   - Use a descriptive title
   - Include a detailed description of changes
   - Reference any related issues
   - Include screenshots for UI changes
   - Ensure all tests pass

3. **PR Requirements**
   - Code follows project standards
   - Changes are tested locally
   - Documentation is updated if needed
   - No merge conflicts with main branch

4. **Review Process**
   - Maintainers will review your PR
   - Address any requested changes
   - Once approved, your PR will be merged

## Reporting Issues

### Before Reporting

- Check if the issue already exists
- Try to reproduce the issue
- Gather relevant information (PHP version, browser, error messages)

### Issue Template

```
**Bug Description**
A clear description of what the bug is.

**Steps to Reproduce**
1. Go to '...'
2. Click on '...'
3. See error

**Expected Behavior**
What you expected to happen.

**Actual Behavior**
What actually happened.

**Environment**
- PHP Version:
- MySQL Version:
- Browser:
- OS:

**Additional Context**
Any other context about the problem.
```

## Feature Requests

When suggesting new features:

- Explain the use case
- Describe the expected behavior
- Consider backward compatibility
- Think about implementation complexity

## Testing

### Manual Testing

- Test all functionality after changes
- Test on different browsers
- Test responsive design
- Test with different user roles

### Automated Testing

- Add tests for new functionality
- Ensure existing tests pass
- Test database operations
- Test security features

## Security

### Reporting Security Issues

Please report security vulnerabilities privately by emailing the maintainers. Do not create public issues for security problems.

### Security Guidelines

- Always use prepared statements
- Validate and sanitize inputs
- Use HTTPS in production
- Implement proper session management
- Follow OWASP guidelines

## Documentation

### Code Documentation

- Comment complex algorithms
- Document function parameters and return values
- Explain business logic
- Update README for new features

### User Documentation

- Update README for new features
- Include screenshots for UI changes
- Provide clear setup instructions
- Document configuration options

## Getting Help

- Create an issue for questions
- Join community discussions
- Check existing documentation
- Review similar projects

## Recognition

Contributors will be acknowledged in:
- README.md contributors section
- Release notes
- Project documentation

Thank you for contributing to CodeVault! 🚀
