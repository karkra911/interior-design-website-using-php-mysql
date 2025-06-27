-- CodeVault Database Setup for InfinityFree Hosting
-- This file should be imported via phpMyAdmin after creating your database

-- Note: Database name is already created by hosting provider
-- We only need to create tables and sample data

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create snippets table
CREATE TABLE IF NOT EXISTS snippets (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    code TEXT NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create tags table
CREATE TABLE IF NOT EXISTS tags (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Create snippet_tags junction table
CREATE TABLE IF NOT EXISTS snippet_tags (
    snippet_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (snippet_id, tag_id),
    FOREIGN KEY (snippet_id) REFERENCES snippets(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

-- Insert sample tags (optional)
INSERT IGNORE INTO tags (name) VALUES 
('JavaScript'),
('PHP'),
('Python'),
('CSS'),
('HTML'),
('SQL'),
('React'),
('Node.js'),
('Bootstrap'),
('jQuery');

-- Insert sample user (password is 'demo123' - change after testing)
-- Password hash for 'demo123'
INSERT IGNORE INTO users (username, password) VALUES 
('demo', '$2y$10$YourHashedPasswordHere');

-- Note: Remember to change the demo password or remove this user in production!
