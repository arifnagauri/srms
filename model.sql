-- SQl for setting up database

-- Classes table
CREATE TABLE classes (
  id int(11) NOT NULL AUTO_INCREMENT,
  class varchar(255) NOT NULL,
  section char(1),

  UNIQUE KEY (class, section),
  PRIMARY KEY (id)
);

-- Subjects table
CREATE TABLE subjects (
  id int(11) NOT NULL AUTO_INCREMENT,
  sub_code varchar(255) NOT NULL,
  name varchar(255) NOT NULL,
  content text,

  PRIMARY KEY (id),
  KEY name (name) USING BTREE
);

-- Class-Subject combination intermediate table
-- (since class and subjects may have many-to-many relationship in college/higher education SMSs)
-- If you are developing only for schools(upto 12th) than leave it and
-- add a foreign key(to classes) in Subjects table, than modify queries in php files accordingly.
CREATE TABLE class_sub (
  class_id int(11) NOT NULL,
  subject_id int(11) NOT NULL,

  PRIMARY KEY (class_id, subject_id),
  CONSTRAINT FK_cs_class FOREIGN KEY (class_id) REFERENCES classes (id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT FK_cs_subject FOREIGN KEY (subject_id) REFERENCES subjects (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Students detail table
CREATE TABLE students (
  id int(11) NOT NULL AUTO_INCREMENT,
  firstName varchar(255) NOT NULL,
  lastName varchar(255),
  rollNo varchar(255) NOT NULL, --This is for just for test to set roll no. manually, in real scenario rollNo might be prim-key
  -- So we have to model rollNo differently for different requirements.
  dob date NOT NULL,
  class_id int(11) NOT NULL,
  mobNo varchar(255) NOT NULL,
  email varchar(255),

  PRIMARY KEY (id),
  KEY rollNo (rollNo) USING BTREE,
  CONSTRAINT FK_st_class FOREIGN KEY (class_id) REFERENCES classes (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Result table for storing result of particular student in his all subjects
CREATE TABLE results (
  student_id int(11) NOT NULL,
  subject_id int(11),
  marks int(11),
  max_marks int(11),

  UNIQUE KEY (student_id, subject_id),
  CONSTRAINT FK_res_student FOREIGN KEY (student_id) REFERENCES students (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_res_subject FOREIGN KEY (subject_id) REFERENCES subjects (id) ON DELETE SET NULL ON UPDATE CASCADE
);

-- If you want any admin user to alter classes table than leave these insert queries
-- and go to class.php and develop view and model/logic accordingly.
-- or if you want your system to alter classes only from root admin user than...
-- Add classes in database itself as these are the fundamentals to Student Management System
INSERT INTO classes (class) VALUES ('Class I');
INSERT INTO classes (class) VALUES ('Class II');
INSERT INTO classes (class) VALUES ('Class III');
INSERT INTO classes (class) VALUES ('Class IV');
INSERT INTO classes (class) VALUES ('Class V');
INSERT INTO classes (class) VALUES ('Class VI');
INSERT INTO classes (class) VALUES ('Class VII');
INSERT INTO classes (class) VALUES ('Class VIII');
INSERT INTO classes (class) VALUES ('Class IX');
INSERT INTO classes (class) VALUES ('Class X');
INSERT INTO classes (class) VALUES ('Class XI');
INSERT INTO classes (class) VALUES ('Class XII');
-- I am starting with just 12 class without section, you can add sections as well.

-- Admin staff log in credentials table
CREATE TABLE admins (
  id int(11) NOT NULL AUTO_INCREMENT,
  u_name varchar(255) NOT NULL UNIQUE,
  pwd text NOT NULL,
  f_name varchar(255),

  PRIMARY KEY (id)
);

-- After creating data model, set a base admin user by executing below query:
-- (you can set your own username and password) and remember to include md5 algorithm function.
INSERT INTO admins (u_name, pwd, f_name) VALUES (/*username*/, md5(/*password*/), /*full name*/);
-- eg.: 
-- INSERT INTO admins (u_name, pwd, f_name) VALUES ('arifnagauri', md5('arif1234'), 'Mohammed Arif');