CREATE TABLE `user` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE `target` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    target_value FLOAT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES `user`(id) ON DELETE CASCADE
);

CREATE TABLE `bottle` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES `user`(id) ON DELETE CASCADE
);

CREATE TABLE `temperature` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bottle_id INT NOT NULL,
    temperature_value FLOAT NOT NULL,
    measured_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bottle_id) REFERENCES `bottle`(id) ON DELETE CASCADE
);

CREATE TABLE `bottle_status` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bottle_id INT NOT NULL,
    status_id INT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bottle_id) REFERENCES `bottle`(id) ON DELETE CASCADE
);

CREATE TABLE `status` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status_description VARCHAR(100) NOT NULL
);

ALTER TABLE `bottle_status`
ADD FOREIGN KEY (status_id) REFERENCES `status`(id) ON DELETE SET NULL;