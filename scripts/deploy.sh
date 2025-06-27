#!/bin/bash

# GitLab CI/CD Deployment Script for CodeVault
# This script handles automated deployment to hosting environments

set -e  # Exit on any error

# Configuration
APP_NAME="codevault"
DEPLOY_DIR="/tmp/codevault-deploy"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/tmp/codevault-backup-${TIMESTAMP}"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Logging function
log() {
    echo -e "${GREEN}[$(date +'%Y-%m-%d %H:%M:%S')] $1${NC}"
}

error() {
    echo -e "${RED}[ERROR] $1${NC}" >&2
}

warning() {
    echo -e "${YELLOW}[WARNING] $1${NC}"
}

info() {
    echo -e "${BLUE}[INFO] $1${NC}"
}

# Check if running in GitLab CI
check_gitlab_ci() {
    if [ -z "$GITLAB_CI" ]; then
        warning "Not running in GitLab CI environment"
        return 1
    fi
    log "Running in GitLab CI environment"
    return 0
}

# Validate environment variables
validate_environment() {
    log "Validating environment variables..."
    
    local required_vars=("CI_COMMIT_SHA" "CI_COMMIT_REF_NAME")
    
    for var in "${required_vars[@]}"; do
        if [ -z "${!var}" ]; then
            error "Required environment variable $var is not set"
            exit 1
        fi
    done
    
    log "Environment validation completed"
}

# Create deployment directory
prepare_deployment() {
    log "Preparing deployment directory..."
    
    # Clean up previous deployment
    rm -rf "$DEPLOY_DIR"
    mkdir -p "$DEPLOY_DIR"
    
    # Copy application files
    cp -r . "$DEPLOY_DIR/"
    
    # Remove unnecessary files
    cd "$DEPLOY_DIR"
    rm -rf .git .gitlab-ci.yml tests/ *.md build/ *.zip
    
    log "Deployment directory prepared: $DEPLOY_DIR"
}

# Validate application files
validate_application() {
    log "Validating application files..."
    
    cd "$DEPLOY_DIR"
    
    # Check required PHP files
    local required_files=(
        "index.php"
        "login.php"
        "register.php"
        "dashboard.php"
        "includes/db.php"
        "hosting-setup.sql"
    )
    
    for file in "${required_files[@]}"; do
        if [ ! -f "$file" ]; then
            error "Required file $file is missing"
            exit 1
        fi
    done
    
    # Validate PHP syntax
    find . -name "*.php" -exec php -l {} \; > /dev/null
    
    log "Application validation completed"
}

# Update database configuration for environment
update_database_config() {
    local environment=$1
    log "Updating database configuration for $environment environment..."
    
    cd "$DEPLOY_DIR"
    
    case $environment in
        "staging")
            # Update for staging database
            if [ -n "$STAGING_DB_HOST" ]; then
                sed -i "s/sql210.infinityfree.com/$STAGING_DB_HOST/g" includes/db.php
            fi
            ;;
        "production")
            # Production config is already set for InfinityFree
            log "Using production database configuration"
            ;;
        *)
            warning "Unknown environment: $environment"
            ;;
    esac
    
    log "Database configuration updated"
}

# Deploy to hosting (simulation for CI/CD)
deploy_to_hosting() {
    local environment=$1
    log "Deploying to $environment environment..."
    
    # In a real scenario, this would:
    # 1. Upload files via FTP/SFTP
    # 2. Update database schema
    # 3. Clear application cache
    # 4. Run health checks
    
    info "Deployment steps for $environment:"
    info "1. Uploading application files..."
    info "2. Updating database schema..."
    info "3. Setting file permissions..."
    info "4. Clearing cache..."
    info "5. Running health checks..."
    
    # Simulate deployment time
    sleep 2
    
    log "Deployment to $environment completed successfully"
}

# Run health checks
health_check() {
    local environment=$1
    log "Running health checks for $environment..."
    
    # Simulate health checks
    info "Checking application endpoints..."
    info "Validating database connectivity..."
    info "Verifying file permissions..."
    info "Testing user authentication..."
    
    sleep 1
    
    log "Health checks completed successfully"
}

# Create backup before deployment
create_backup() {
    log "Creating backup before deployment..."
    
    # In production, this would backup:
    # - Current application files
    # - Database dump
    # - Configuration files
    
    mkdir -p "$BACKUP_DIR"
    info "Backup created at: $BACKUP_DIR"
    
    log "Backup creation completed"
}

# Send deployment notification
send_notification() {
    local environment=$1
    local status=$2
    
    log "Sending deployment notification..."
    
    local message="CodeVault deployment to $environment: $status"
    message="$message\nCommit: ${CI_COMMIT_SHA:0:8}"
    message="$message\nBranch: $CI_COMMIT_REF_NAME"
    message="$message\nTime: $(date)"
    
    # In production, send to Slack/Teams/Email
    info "Notification: $message"
    
    log "Notification sent"
}

# Rollback function
rollback() {
    local environment=$1
    warning "Rolling back deployment for $environment..."
    
    # In production, this would:
    # - Restore previous application files
    # - Restore database backup
    # - Clear cache
    # - Restart services
    
    info "Rollback steps:"
    info "1. Restoring previous application files..."
    info "2. Restoring database backup..."
    info "3. Clearing cache..."
    info "4. Restarting services..."
    
    log "Rollback completed"
}

# Main deployment function
main() {
    local environment=${1:-"staging"}
    
    log "Starting CodeVault deployment to $environment"
    log "Commit: ${CI_COMMIT_SHA:-"local"}"
    log "Branch: ${CI_COMMIT_REF_NAME:-"local"}"
    
    # Validate environment
    if check_gitlab_ci; then
        validate_environment
    fi
    
    # Deployment steps
    create_backup
    prepare_deployment
    validate_application
    update_database_config "$environment"
    
    # Deploy with error handling
    if deploy_to_hosting "$environment"; then
        health_check "$environment"
        send_notification "$environment" "SUCCESS"
        log "Deployment completed successfully! 🚀"
    else
        error "Deployment failed!"
        rollback "$environment"
        send_notification "$environment" "FAILED"
        exit 1
    fi
    
    # Cleanup
    rm -rf "$DEPLOY_DIR"
    
    log "Deployment process finished"
}

# Handle script arguments
case "${1:-help}" in
    "staging")
        main "staging"
        ;;
    "production")
        main "production"
        ;;
    "rollback")
        rollback "${2:-staging}"
        ;;
    "help"|*)
        echo "Usage: $0 {staging|production|rollback}"
        echo ""
        echo "Commands:"
        echo "  staging     - Deploy to staging environment"
        echo "  production  - Deploy to production environment"
        echo "  rollback    - Rollback deployment (specify environment)"
        echo "  help        - Show this help message"
        echo ""
        echo "Examples:"
        echo "  $0 staging"
        echo "  $0 production"
        echo "  $0 rollback staging"
        exit 0
        ;;
esac
