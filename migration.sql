-- Create 'users' table
CREATE TABLE `users` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create 'status' table
CREATE TABLE `status` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    status_description VARCHAR(255) NOT NULL
);

-- Insert default statuses into 'status' table
INSERT INTO `status` (status_description) VALUES 
('Empty'),
('Low'),
('Good'),
('Full');

-- Create 'bottles' table
CREATE TABLE `bottles` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create 'bottle_status' table
CREATE TABLE `bottle_status` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bottle_id INT NOT NULL,
    status_id INT NOT NULL,
    measured_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bottle_id) REFERENCES bottles(id),
    FOREIGN KEY (status_id) REFERENCES status(id)
);

-- Create 'temperature' table
CREATE TABLE `temperature` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bottle_id INT NOT NULL,
    value FLOAT NOT NULL,
    measured_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bottle_id) REFERENCES bottles(id)
);

-- Create 'bottle_level' table
CREATE TABLE `bottle_level` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bottle_id INT NOT NULL,
    level_percentage FLOAT NOT NULL,
    measured_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bottle_id) REFERENCES bottles(id)
);