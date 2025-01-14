CREATE DATABASE IF NOT EXISTS youdemy_db;

USE youdemy_db;
--users table
CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    bio TEXT,
    profile_picture_url VARCHAR(255),
    status enum('active', 'suspended', 'panding') DEFAULT('panding'),
    role ENUM('admin', 'teacher', 'student') NOT NULL,
    
    PRIMARY KEY (id)
);
                                                                                                                                                                                                                                                            
-- tags table
CREATE TABLE tags (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50),
    PRIMARY KEY (id)
);

--categories table
CREATE TABLE categories (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50),
    PRIMARY KEY (id)
);

--courses table
CREATE TABLE courses (
    id INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(200),
    teacher_id INT NOT NULL,
    meta_description TEXT,
    content enum('video', 'document'),
    category_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE course_tag (
    course_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY(course_id, tag_id),
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
    FOREIGN KEY (tag_id) REFERENCES tags(id)
);


CREATE INDEX idx_course_title ON courses(title);
CREATE INDEX idx_tag_name ON tags(name);
CREATE INDEX idx_category_name ON categories(name);



CREATE TABLE course_reviews (
    id INT NOT NULL AUTO_INCREMENT,
    course_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK(rating >= 1 AND rating <= 5),
    review TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,--to delete the rating of the user when he is deleted
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
