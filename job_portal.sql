DROP DATABASE IF EXISTS job_portal;
CREATE DATABASE job_portal;
USE job_portal;

-- 1. Users
CREATE TABLE users (
    user_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('applicant', 'recruiter') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id)
) ENGINE=InnoDB;

-- 2. Companies
CREATE TABLE companies (
    company_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    company_name VARCHAR(100),
    location VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (company_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB;

-- 3. Categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    icon VARCHAR(100) NOT NULL
);


-- 4. Jobs
CREATE TABLE jobs (
    job_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    company_id INT UNSIGNED NOT NULL,
    title VARCHAR(100),
    description TEXT,
    location VARCHAR(100),
    category VARCHAR(100),
    salary_range VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (job_id),
    FOREIGN KEY (company_id) REFERENCES companies(company_id)
) ENGINE=InnoDB;

-- 5. Applications Updates
CREATE TABLE applications (
    application_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    job_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('applied', 'accepted', 'rejected') DEFAULT 'applied',
    PRIMARY KEY (application_id),
    FOREIGN KEY (job_id) REFERENCES jobs(job_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB; 

-- Step 6: Create the table
CREATE TABLE application_updates (
  update_id INT AUTO_INCREMENT PRIMARY KEY,
  application_id INT NOT NULL,
  status VARCHAR(50) NOT NULL,
  interview_date DATE,
  interview_time TIME,
  message VARCHAR(255),
  address VARCHAR(255), -- New Address column added here
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 7. Saved Jobs
CREATE TABLE saved_jobs (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    job_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (job_id) REFERENCES jobs(job_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB;

-- 8. User Profiles
CREATE TABLE user_profiles (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    full_name VARCHAR(100),
    resume VARCHAR(255),
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB;

-- 9. Admin
CREATE TABLE admin (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    PRIMARY KEY (id)
) ENGINE=InnoDB;




-- Dummy Admin
INSERT INTO admin (email, password) VALUES ('admin@example.com', MD5('admin123'));

-- Dummy Categories
INSERT INTO categories (name, icon) VALUES
('IT', 'fa-laptop-code'),
('Finance', 'fa-chart-line'),
('Healthcare', 'fa-user-nurse'),
('Education', 'fa-chalkboard-teacher'),
('Engineering', 'fa-tools');


-- Insert a test recruiter
INSERT INTO users (user_id, name, email, password, role)
VALUES (101, 'Recruiter Test', 'recruiter@test.com', MD5('recruit123'), 'recruiter');

INSERT INTO companies (company_id, user_id, company_name, location, email, password)
VALUES (1, 101, 'TechSolutions Ltd', 'Pune', 'company@test.com', MD5('company123'));


INSERT INTO jobs (company_id, title, description, location, category, salary_range)
VALUES 
(1, 'Frontend Developer', 'HTML, CSS, JS knowledge required', 'Pune', 'IT', '3-5 LPA'),
(1, 'PHP Backend Developer', 'Experience in PHP & MySQL', 'Bangalore', 'IT', '4-6 LPA');

-- Insert sample data
INSERT INTO `application_updates` 
(`update_id`, `application_id`, `status`, `interview_date`, `interview_time`, `message`, `address`, `updated_at`) 
VALUES
(3, 13, 'applied', '2025-07-14', '12:00:00', 'All The Best', 'Pune Office, ABC Road', '2025-07-13 11:11:13'),
(4, 14, 'applied', '2025-07-15', '13:00:00', 'all the best', 'Mumbai Office, XYZ Street', '2025-07-14 11:46:44');

