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

-- bunch of fake data
INSERT INTO `users` (email, password) VALUES ('jane@doe.com', 'password');
INSERT INTO `users` (email, password) VALUES ('joe@doe.com', 'password');
INSERT INTO `users` (email, password) VALUES ('example@example.com', 'password');
INSERT INTO `users` (email, password) VALUES ('admin@fake.com', 'password');
INSERT INTO `users` (email, password) VALUES ('user@example.com', 'password');
INSERT INTO `bottles` (user_id, name) VALUES (1, 'Janes Bottle');
INSERT INTO `bottles` (user_id, name) VALUES (2, 'Joes Bottle');
INSERT INTO `bottles` (user_id, name) VALUES (3, 'Example Bottle');
INSERT INTO `bottles` (user_id, name) VALUES (4, 'Admins Bottle');
INSERT INTO `bottles` (user_id, name) VALUES (5, 'Users Bottle');
INSERT INTO `temperatures` (bottle_id, value) VALUES (1, 20.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (1, 21.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (1, 22.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (1, 23.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (1, 24.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (2, 20.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (2, 21.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (2, 22.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (2, 23.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (2, 24.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (3, 20.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (3, 21.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (3, 22.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (3, 23.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (3, 24.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (4, 20.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (4, 21.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (4, 22.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (4, 23.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (4, 24.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (5, 20.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (5, 21.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (5, 22.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (5, 23.5);
INSERT INTO `temperatures` (bottle_id, value) VALUES (5, 24.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (1, 20.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (1, 21.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (1, 22.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (1, 23.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (1, 24.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (2, 20.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (2, 21.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (2, 22.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (2, 23.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (2, 24.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (3, 20.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (3, 21.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (3, 22.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (3, 23.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (3, 24.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (4, 20.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (4, 21.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (4, 22.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (4, 23.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (4, 24.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (5, 20.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (5, 21.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (5, 22.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (5, 23.5);
INSERT INTO `bottle_level` (bottle_id, level_percentage) VALUES (5, 24.5);
INSERT INTO `bottles` (id, name) VALUES (5555, 'Unnamed Bottle');
INSERT INTO `bottles` (id, name) VALUES (5556, 'Unnamed Bottle');
INSERT INTO `bottles` (id, name) VALUES (5557, 'Unnamed Bottle');
INSERT INTO `bottles` (id, name) VALUES (5558, 'Unnamed Bottle');
INSERT INTO `bottles` (id, name) VALUES (5559, 'Unnamed Bottle');
INSERT INTO `bottles` (id, name) VALUES (5560, 'Unnamed Bottle');
INSERT INTO `bottles` (id, name) VALUES (5561, 'Unnamed Bottle');
INSERT INTO `bottles` (id, name) VALUES (5562, 'Unnamed Bottle');
INSERT INTO `bottles` (id, name) VALUES (5563, 'Unnamed Bottle');
INSERT INTO `bottles` (id, name) VALUES (5564, 'Unnamed Bottle');