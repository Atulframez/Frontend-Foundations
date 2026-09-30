-- ============================================================================
-- Experiment 22: MySQL Commands Implementation Schema
-- Course: Advanced Web Technology (CSIT248) - Amity University Noida
-- Table: employees
-- Implements: a) DELETE  b) ORDER BY  c) UPDATE
-- ============================================================================

CREATE DATABASE IF NOT EXISTS company_db;
USE company_db;

CREATE TABLE IF NOT EXISTS employees (
    emp_id INT AUTO_INCREMENT PRIMARY KEY,
    emp_name VARCHAR(100) NOT NULL,
    department VARCHAR(60) NOT NULL,
    designation VARCHAR(80) NOT NULL,
    salary DECIMAL(10, 2) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    joined_date DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Sample Records
INSERT INTO employees (emp_name, department, designation, salary, email, joined_date) VALUES
('Atul Anand', 'Information Tech', 'Full Stack Engineer', 95000.00, 'atul@company.com', '2023-06-15'),
('Priya Sharma', 'Product & Design', 'UI/UX Lead', 88000.00, 'priya@company.com', '2023-08-01'),
('Rohan Verma', 'DevOps & Cloud', 'Cloud Architect', 115000.00, 'rohan@company.com', '2022-11-20'),
('Ananya Sengupta', 'Data & AI', 'Machine Learning Eng', 105000.00, 'ananya@company.com', '2023-01-10'),
('Vikramaditya Rao', 'Cybersecurity', 'Security Analyst', 82000.00, 'vikram@company.com', '2024-02-18'),
('Sneha Kulkarni', 'Quality Assurance', 'Lead QA Specialist', 76000.00, 'sneha@company.com', '2023-09-05');
