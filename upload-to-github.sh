#!/bin/bash

# CodeVault GitHub Upload Script
# This script will help you upload your CodeVault project to GitHub

echo "🚀 CodeVault GitHub Upload Script"
echo "=================================="
echo ""

# Check if git is initialized
if [ ! -d ".git" ]; then
    echo "❌ Error: This directory is not a git repository."
    echo "Please run this script from the CodeVault project directory."
    exit 1
fi

echo "📋 Current project status:"
echo "Directory: $(pwd)"
echo "Files ready for upload:"
git ls-files | head -10
echo "... and $(git ls-files | wc -l) total files"
echo ""

echo "📝 Next Steps to Upload to GitHub:"
echo ""
echo "1. Go to GitHub.com and create a new repository:"
echo "   - Repository name: 'codevault' (or your preferred name)"
echo "   - Make it public"
echo "   - Don't initialize with README (we already have one)"
echo ""
echo "2. Copy your new repository URL (example: https://github.com/yourusername/codevault.git)"
echo ""
echo "3. Run these commands in your terminal:"
echo ""
echo "   # Add your GitHub repository as remote"
echo "   git remote add origin https://github.com/YOURUSERNAME/YOURREPONAME.git"
echo ""
echo "   # Push to GitHub"
echo "   git branch -M main"
echo "   git push -u origin main"
echo ""
echo "4. After upload, configure your repository:"
echo "   - Add description: 'Personal code snippet manager built with PHP & MySQL'"
echo "   - Add topics: php, mysql, bootstrap, code-snippets, web-app"
echo "   - Enable Issues and Wiki if desired"
echo ""

echo "🌐 For Web Hosting Deployment:"
echo ""
echo "1. Create a ZIP file of all project files:"
echo "   zip -r codevault-deployment.zip . -x '*.git*' 'upload-to-github.sh'"
echo ""
echo "2. Upload the ZIP to your hosting provider's htdocs folder"
echo ""
echo "3. Import hosting-setup.sql via phpMyAdmin"
echo ""
echo "4. Your database credentials are already configured in includes/db.php"
echo ""

echo "✅ Your CodeVault project is ready for deployment!"
echo "📚 See DEPLOYMENT.md for detailed instructions"
echo ""

# Optional: Create deployment ZIP
read -p "Would you like me to create a deployment ZIP file now? (y/n): " create_zip
if [[ $create_zip =~ ^[Yy]$ ]]; then
    echo "Creating deployment ZIP..."
    zip -r codevault-deployment.zip . -x '*.git*' 'upload-to-github.sh' '*.zip'
    echo "✅ Created: codevault-deployment.zip"
    echo "📁 This file is ready for web hosting upload!"
fi

echo ""
echo "🎉 Thank you for using CodeVault!"
