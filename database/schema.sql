
USE invitation_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255),
    invite_token VARCHAR(255),
    otp VARCHAR(10),
    otp_expiry DATETIME,
    is_verified TINYINT(1) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 0,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    inviter VARCHAR(255),
    inviter_email VARCHAR(150),
    invite_accepted ENUM('yes', 'no') NOT NULL DEFAULT 'no',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
