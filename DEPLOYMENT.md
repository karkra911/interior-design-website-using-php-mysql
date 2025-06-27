# CodeVault Deployment Guide

## Web Hosting Deployment (InfinityFree)

### Step 1: Prepare Your Hosting Account
1. Sign up for InfinityFree hosting at https://infinityfree.net/
2. Create a new hosting account
3. Note down your database credentials from the control panel

### Step 2: Database Setup
1. Login to your hosting control panel
2. Go to MySQL Databases
3. Your database details should be:
   - Server: `sql210.infinityfree.com`
   - Username: `if0_39335616`
   - Password: `VWelUBfDrY`
   - Database: `if0_39335616_database`

4. Access phpMyAdmin
5. Import the `hosting-setup.sql` file to create tables

### Step 3: File Upload
1. Download all project files as a ZIP
2. Extract and upload to your hosting's `htdocs` folder via File Manager or FTP
3. Ensure the `includes/db.php` file has the correct database credentials

### Step 4: File Permissions
- Set folders to 755 permissions
- Set PHP files to 644 permissions

### Step 5: Testing
1. Visit your website URL
2. Register a new account
3. Test creating, editing, and deleting snippets
4. Verify all functionality works correctly

## GitHub Repository Setup

### Step 1: Create GitHub Repository
1. Go to GitHub.com and login
2. Click "New Repository"
3. Name it "codevault" or your preferred name
4. Make it public
5. Don't initialize with README (we already have one)

### Step 2: Initialize Git and Push
```bash
# Navigate to your project directory
cd "/home/dilip-singh/Desktop/Local Disk/Gam/code projects/php mysql website"

# Initialize git repository
git init

# Add all files
git add .

# Make initial commit
git commit -m "Initial commit: CodeVault - Personal Code Snippet Manager

- Complete PHP/MySQL web application
- User authentication system
- Code snippet CRUD operations
- Tagging system
- Responsive Bootstrap UI
- Prepared for hosting deployment"

# Add remote repository (replace with your GitHub repo URL)
git remote add origin https://github.com/yourusername/codevault.git

# Push to GitHub
git branch -M main
git push -u origin main
```

### Step 3: Repository Configuration
1. Add a proper repository description
2. Add topics/tags: `php`, `mysql`, `bootstrap`, `code-snippets`, `web-app`
3. Enable Issues and Wiki if desired
4. Set up branch protection rules if needed

## Post-Deployment Security

### Important Security Steps:
1. **Change Database Password**: Update your hosting database password
2. **Remove Demo Data**: Delete any test users or snippets
3. **Update Contact Info**: Change email addresses in documentation
4. **Enable HTTPS**: Configure SSL certificate in hosting control panel
5. **Regular Backups**: Set up automated database backups

### Production Configuration:
1. Disable error reporting in `includes/db.php`
2. Use strong passwords for any admin accounts
3. Regularly update the application
4. Monitor for suspicious activity

## Troubleshooting

### Common Issues:
1. **Database Connection Error**: Check credentials in `includes/db.php`
2. **Permission Denied**: Verify file permissions (644 for files, 755 for directories)
3. **500 Internal Error**: Check PHP error logs in hosting control panel
4. **Styling Issues**: Ensure CSS and JS files are uploaded correctly

### Support:
- Check hosting provider documentation
- Review application logs
- Test locally first before deploying
- Consult the SECURITY.md file for security best practices

## Maintenance

### Regular Tasks:
- Backup database weekly
- Monitor disk space usage
- Update dependencies when available
- Review user activity logs
- Check for security updates

### Performance Optimization:
- Enable compression in hosting control panel
- Optimize database queries if needed
- Use CDN for static assets if traffic grows
- Monitor page load times

---

**Your CodeVault application is now ready for deployment! 🚀**
