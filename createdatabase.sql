CREATE DATABASE canvas;

USE canvas;

CREATE TABLE course  
(
  cnumber VARCHAR(10) NOT NULL,
  c_name VARCHAR(40) NOT NULL,
  CONSTRAINT course PRIMARY KEY (cnumber)
);           

CREATE TABLE person
(
  pid VARCHAR(10) NOT NULL,
  log_id VARCHAR(15) NOT NULL,   
  fname VARCHAR(15) NOT NULL,
  lname VARCHAR(15) NOT NULL,
  CONSTRAINT person PRIMARY KEY (pid)
);
                                    
CREATE TABLE class 
(
  cid CHAR(10) NOT NULL,
  cnumber VARCHAR(10) NOT NULL,
  semester VARCHAR(6) NOT NULL,
  instructor_pid VARCHAR(10) NOT NULL,
  year INT NOT NULL,
  CONSTRAINT class PRIMARY KEY (cid),
  CONSTRAINT cnum_fk FOREIGN KEY (cnumber) REFERENCES course(cnumber),
  CONSTRAINT ins_fk FOREIGN KEY (instructor_pid) REFERENCES person(pid)
);

CREATE TABLE ta
(
  ta_pid VARCHAR(10) NOT NULL,
  cid CHAR(10) NOT NULL,
  CONSTRAINT ta PRIMARY KEY (cid, ta_pid),
  CONSTRAINT two FOREIGN KEY (cid) REFERENCES class(cid),
  CONSTRAINT three FOREIGN KEY (ta_pid) REFERENCES person(pid)
);   

CREATE TABLE take  
(
  take_pid VARCHAR(10) NOT NULL,
  c_grade VARCHAR(2),
  cid CHAR(10) NOT NULL,
  CONSTRAINT take PRIMARY KEY (take_pid, cid),
  CONSTRAINT six FOREIGN KEY (cid) REFERENCES class(cid),
  CONSTRAINT sii FOREIGN KEY (take_pid) REFERENCES person(pid)
);   

CREATE TABLE assignment  
(
  cid CHAR(10) NOT NULL,
  a_name VARCHAR(20) NOT NULL,
  duedate DATE,
  text TEXT,
  total_p INT,
  CONSTRAINT assign PRIMARY KEY (cid, a_name),
  CONSTRAINT one_fk FOREIGN KEY (cid) REFERENCES class(cid)
);           

CREATE TABLE grade
(
  a_name VARCHAR(20) NOT NULL,
  stu_pid VARCHAR(10),
  a_grade INT,
  cid CHAR(10) NOT NULL,
  CONSTRAINT grade PRIMARY KEY (cid,a_name,stu_pid),
  CONSTRAINT seven FOREIGN KEY (cid,a_name) REFERENCES assignment(cid,a_name),
  CONSTRAINT nine FOREIGN KEY (stu_pid) REFERENCES person(pid)
);   

CREATE TABLE question
( date TIMESTAMP,
  title VARCHAR(200) NOT NULL,
  qtext TEXT,
  ask_pid VARCHAR(10),
  cid CHAR(10) NOT NULL,
  CONSTRAINT question PRIMARY KEY (cid, title),
  CONSTRAINT twelfe FOREIGN KEY (ask_pid) REFERENCES person(pid),
  CONSTRAINT n FOREIGN KEY (cid) REFERENCES class(cid)
);

CREATE TABLE reply
(
  rnum INT NOT NULL,
  rtext TEXT,
  time TIMESTAMP,
  answer_pid VARCHAR(10) NOT NULL,
  title VARCHAR(200) NOT NULL,
  cid CHAR(10) NOT NULL,
  CONSTRAINT reply PRIMARY KEY (title,cid,rnum),
  CONSTRAINT thirteen FOREIGN KEY (cid,title) REFERENCES question(cid,title),
  CONSTRAINT fourteen FOREIGN KEY (answer_pid) REFERENCES person(pid)
);

CREATE TABLE tag
(
  t_name VARCHAR(15) NOT NULL,
  cid CHAR(10) NOT NULL,
  CONSTRAINT tag PRIMARY KEY (t_name,cid),
  CONSTRAINT fivteen  FOREIGN KEY (cid) REFERENCES class(cid)
);

CREATE TABLE hastag
(
  t_name VARCHAR(15) NOT NULL,
  title VARCHAR(200) NOT NULL,
  cid CHAR(10) NOT NULL,
  CONSTRAINT tag PRIMARY KEY (t_name,title,cid),
  CONSTRAINT seventeen  FOREIGN KEY (t_name,cid) REFERENCES tag(t_name,cid),
  CONSTRAINT sixteen  FOREIGN KEY (cid,title) REFERENCES question(cid,title)
);


