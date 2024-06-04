CREATE DATABASE IF NOT EXISTS schoox;
USE schoox;
DROP TABLE IF EXISTS Courses;
CREATE TABLE IF NOT EXISTS Courses (
    id INT(255) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(1023) NOT NULL,
    status VARCHAR(12) NOT NULL,
    is_premium BOOLEAN NOT NULL,
    created_at VARCHAR(255) NOT NULL,
    deleted_at VARCHAR(255) NOT NULL
);
-- TRUNCATE TABLE Courses;
INSERT INTO Courses (
        title,
        description,
        status,
        is_premium,
        created_at,
        deleted_at
    )
VALUES (
        "Course 1",
        "This is the description of Course number 1.",
        "Pending",
        1,
        CURRENT_TIMESTAMP(),
        CURRENT_TIMESTAMP()
    );
INSERT INTO Courses (
        title,
        description,
        status,
        is_premium,
        created_at,
        deleted_at
    )
VALUES (
        "Course 2",
        "This is the description of Course number 2.",
        "Pending",
        1,
        CURRENT_TIMESTAMP(),
        CURRENT_TIMESTAMP()
    );
INSERT INTO Courses (
        title,
        description,
        status,
        is_premium,
        created_at,
        deleted_at
    )
VALUES (
        "Course 3",
        "This is the description of Course number 3.",
        "Pending",
        0,
        CURRENT_TIMESTAMP(),
        CURRENT_TIMESTAMP()
    );
INSERT INTO Courses (
        title,
        description,
        status,
        is_premium,
        created_at,
        deleted_at
    )
VALUES (
        "Course 4",
        "This is the description of Course number 4.",
        "Pending",
        0,
        CURRENT_TIMESTAMP(),
        CURRENT_TIMESTAMP()
    );
INSERT INTO Courses (
        title,
        description,
        status,
        is_premium,
        created_at,
        deleted_at
    )
VALUES (
        "Course 5",
        "This is the description of Course number 5.",
        "Pending",
        1,
        CURRENT_TIMESTAMP(),
        CURRENT_TIMESTAMP()
    );
INSERT INTO Courses (
        title,
        description,
        status,
        is_premium,
        created_at,
        deleted_at
    )
VALUES (
        "Course 6",
        "This is the description of Course number 6.",
        "Published",
        0,
        CURRENT_TIMESTAMP(),
        CURRENT_TIMESTAMP()
    );