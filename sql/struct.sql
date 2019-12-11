DROP DATABASE intern_manager;
CREATE DATABASE intern_manager;
USE intern_manager;
CREATE TABLE IF NOT EXISTS intern_organization_profile
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    organization_name TEXT NOT NULL,
    employee_count INT NOT NULL,
    gross_revenue INT NOT NULL,
    address VARCHAR(200) NOT NULL,
    home_page VARCHAR(100) NOT NULL,
    tax_number TEXT
);

CREATE TABLE IF NOT EXISTS intern_organization_requests
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    organization_id INT NOT NULL,
    subject VARCHAR(100) NOT NULL,
    short_description TEXT,
    amount INT NOT NULL,
    date_submitted DATETIME NOT NULL,
    status INT NOT NULL,
    FOREIGN KEY (organization_id) REFERENCES intern_organization_profile(id)
);

CREATE TABLE IF NOT EXISTS intern_students
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    student_code VARCHAR(20) NOT NULL,
    first_name TEXT NOT NULL,
    sur_name TEXT,
    last_name TEXT NOT NULL,
    date_of_birth DATETIME NOT NULL,
    join_date DATETIME NOT NULL,
    class_name TEXT NOT NULL
);


CREATE TABLE IF NOT EXISTS intern_ability_dictionary
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ability_name TEXT NOT NULL,
    ability_type TEXT NOT NULL,
    ability_note TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS intern_students_ability
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    ability_id INT NOT NULL,
    ability_rate INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES intern_students(id),
    FOREIGN KEY (ability_id) REFERENCES intern_ability_dictionary(id)

);

CREATE TABLE IF NOT EXISTS intern_organization_request_abilities
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    organization_request_id INT NOT NULL,
    ability_id INT NOT NULL,
    ability_required INT NOT NULL,
    note VARCHAR(100),
    FOREIGN KEY (organization_request_id) REFERENCES intern_organization_requests(id),
    FOREIGN KEY (ability_id) REFERENCES intern_ability_dictionary(id)
);

CREATE TABLE IF NOT EXISTS intern_student_register
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    organization_request_id INT NOT NULL,
    submit_date DATETIME NOT NULL,
    FOREIGN KEY (student_id) REFERENCES intern_students(id),
    FOREIGN KEY (organization_request_id) REFERENCES intern_organization_requests(id)
);

CREATE TABLE IF NOT EXISTS intern_organization_request_assignment
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    organization_request_id INT NOT NULL,
    student_id INT NOT NULL,
    create_date DATETIME NOT NULL,
    FOREIGN KEY (organization_request_id) REFERENCES intern_organization_requests(id),
    FOREIGN KEY (student_id) REFERENCES intern_students(id)
);

CREATE TABLE IF NOT EXISTS intern_teachers
(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    teacher_code VARCHAR(20) NOT NULL,
    full_name VARCHAR(50) NOT NULL,
    sex TEXT NOT NULL
);
