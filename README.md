# CodeVault - Personal Code Snippet Manager

A simple, elegant PHP-based web application for storing, organizing, and managing your code snippets. Built with PHP, MySQL, Bootstrap, and jQuery.

## Features

- **User Authentication**: Secure user registration and login system
- **Code Snippet Management**: Create, edit, delete, and view code snippets
- **Tagging System**: Organize snippets with tags for easy categorization
- **User Dashboard**: Personal dashboard to manage all your snippets
- **Responsive Design**: Works seamlessly on desktop and mobile devices
- **Clean UI**: Modern, Bootstrap-based interface

## Screenshots

![CodeVault Homepage](screenshots/homepage.png)
![Dashboard](screenshots/dashboard.png)

## Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework**: Bootstrap 4
- **Library**: jQuery

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Local Development Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/codevault.git
   cd codevault
   ```

2. **Database Setup**
   - Create a MySQL database
   - Import the `database.sql` file:
   ```bash
   mysql -u your_username -p your_database_name < database.sql
   ```

3. **Configure Database Connection**
   - Edit `includes/db.php` with your database credentials:
   ```php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'your_username');
   define('DB_PASSWORD', 'your_password');
   define('DB_NAME', 'your_database_name');
   ```

4. **Start Local Server**
   ```bash
   php -S localhost:8000
   ```

5. **Visit** `http://localhost:8000` in your browser

### Web Hosting Deployment

#### For InfinityFree Hosting:

1. **Prepare Files**
   - Download all project files
   - Update `includes/db.php` with your hosting database credentials

2. **Upload Files**
   - Upload all files to your hosting's `htdocs` or `public_html` directory
   - Ensure proper file permissions (644 for files, 755 for directories)

3. **Database Setup**
   - Create a MySQL database in your hosting control panel
   - Import the `database.sql` file via phpMyAdmin
   - Update the database credentials in `includes/db.php`

## Usage

1. **Register**: Create a new account on the homepage
2. **Login**: Access your personal dashboard
3. **Create Snippets**: Add new code snippets with titles, descriptions, and tags
4. **Organize**: Use tags to categorize your snippets
5. **Search**: Find snippets quickly using the search functionality
6. **Manage**: Edit or delete snippets as needed

## File Structure

```
codevault/
├── index.php              # Homepage
├── login.php              # User login
├── register.php           # User registration
├── logout.php             # Logout functionality
├── dashboard.php          # User dashboard
├── create_snippet.php     # Create new snippet
├── edit_snippet.php       # Edit existing snippet
├── view_snippet.php       # View snippet details
├── delete_snippet.php     # Delete snippet
├── error.php              # Error page
├── database.sql           # Database schema
├── css/
│   └── style.css          # Custom styles
├── js/
│   └── script.js          # Custom JavaScript
└── includes/
    ├── db.php             # Database connection
    ├── header.php         # Header template
    └── footer.php         # Footer template
```

## Security Features

- Password hashing using PHP's `password_hash()`
- SQL injection prevention with prepared statements
- Session management for user authentication
- Input validation and sanitization

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

If you encounter any issues or have questions, please:
1. Check the existing issues on GitHub
2. Create a new issue with detailed information
3. Contact the maintainer

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for a detailed history of changes.

## Acknowledgments

- Bootstrap for the responsive CSS framework
- jQuery for DOM manipulation
- Font Awesome for icons
- All contributors who have helped improve this project

---

**Made with ❤️ for developers who love organized code**
