-- schema.sql

CREATE TABLE Sites (
    site_id INT PRIMARY KEY,
    site_name VARCHAR(255)
);

CREATE TABLE Grades (
    grade_id INT PRIMARY KEY,
    name VARCHAR(255),
    site_id INT,
    FOREIGN KEY (site_id) REFERENCES Sites(site_id)
);

CREATE TABLE Sections (
    section_id INT PRIMARY KEY,
    section_name VARCHAR(255),
    site_id INT,
    FOREIGN KEY (site_id) REFERENCES Sites(site_id)
);

CREATE TABLE Events (
    event_id INT PRIMARY KEY,
    name VARCHAR(255),
    start_date DATE,
    end_date DATE,
    site_id INT,
    section_id INT,
    grade_id INT,
    FOREIGN KEY (site_id) REFERENCES Sites(site_id),
    FOREIGN KEY (section_id) REFERENCES Sections(section_id),
    FOREIGN KEY (grade_id) REFERENCES Grades(grade_id)
);