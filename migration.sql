-- Create 'users' table
CREATE TABLE `users` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create 'bottles' table
CREATE TABLE `bottles` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    name VARCHAR(255),
    level INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create 'temperatures' table
CREATE TABLE `temperatures` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bottle_id INT NOT NULL,
    value FLOAT NOT NULL,
    measured_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bottle_id) REFERENCES bottles(id) ON DELETE CASCADE
);

-- Create 'bottle_level' table
CREATE TABLE `bottle_level` (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bottle_id INT NOT NULL,
    level_percentage FLOAT NOT NULL,
    measured_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bottle_id) REFERENCES bottles(id) ON DELETE CASCADE
);

-- Sample data
insert into users (email, password) values ('janedoe@example.com', 'password');
insert into bottles (user_id, name, level) values (1, 'Jane Doe''s Bottle', 0);
insert into bottles (user_id, name, level) values (1, 'Jane Doe''s Bottle', 100);
insert into bottles (name, level) values ('Unnamed Bottle', 0);
insert into temperatures (bottle_id, value) values (1, 25.5);
insert into temperatures (bottle_id, value) values (2, 26.5);
insert into bottle_level (bottle_id, level_percentage) values (1, 50);