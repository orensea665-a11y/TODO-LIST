-- Create database
CREATE DATABASE IF NOT EXISTS todo_app;
USE todo_app;

-- Users table (simple, for demo purposes)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

-- Categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tasks table (related to categories and users)
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'completed') DEFAULT 'pending',
    due_date DATE,
    category_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insert sample data
INSERT INTO users (name, email) VALUES ('Demo User', 'demo@example.com');
INSERT INTO categories (name, description, user_id) VALUES 
('Work', 'Work-related tasks', 1),
('Personal', 'Personal tasks', 1);
INSERT INTO tasks (title, description, status, due_date, category_id, user_id) VALUES 
('Finish project', 'Complete the college project', 'pending', '2023-12-31', 1, 1),
('Buy groceries', 'Weekly shopping', 'completed', '2023-10-01', 2, 1);
