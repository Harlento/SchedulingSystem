CREATE TABLE USER_TYPE
(
	TYPE_CODE char(1) NOT NULL,
	TYPE_NAME varchar(15) NOT NULL,
	PRIMARY KEY (TYPE_CODE)
);

CREATE TABLE C_S_STATUS
(
	C_S_STATUS_CODE char(1) NOT NULL,
	C_S_STATUS_NAME varchar(15) NOT NULL,
	PRIMARY KEY (C_S_STATUS_CODE)
);

CREATE TABLE SHIFT_STATUS
(
	STATUS_CODE char(1) NOT NULL,
	STATUS_NAME varchar(15) NOT NULL,
	PRIMARY KEY (STATUS_CODE)
);

CREATE TABLE STAFF
(
	STAFF_ID int NOT NULL AUTO_INCREMENT,
	TYPE_CODE char(1) NOT NULL,
	STAFF_STATUS char(1) NOT NULL,
	USER_NAME varchar(20) NOT NULL,
	USER_PASS varchar(50) NOT NULL,
	STAFF_FNAME varchar(20) NOT NULL,
	STAFF_LNAME varchar(20) NOT NULL,
	STAFF_PHONE varchar(15),
	STAFF_ADDRESS varchar(50),
	STAFF_CITY varchar(20),
	CAN_CHILD tinyint,
	CAN_PC tinyint,
	CAN_DRIVE tinyint,
	STAFF_AVAIL text,
	STAFF_NOTES text,
	PRIMARY KEY (STAFF_ID),
	FOREIGN KEY (TYPE_CODE) REFERENCES USER_TYPE(TYPE_CODE),
	FOREIGN KEY (STAFF_STATUS) REFERENCES C_S_STATUS(C_S_STATUS_CODE)
);

CREATE TABLE GROUP_HOME
(
	GH_ID int NOT NULL AUTO_INCREMENT,
	STAFF_ID int NOT NULL,
	GH_NAME varchar(20) NOT NULL,
	GH_PHONE varchar(15),
	GH_ADDRESS varchar(50),
	PRIMARY KEY (GH_ID),
	FOREIGN KEY (STAFF_ID) REFERENCES STAFF(STAFF_ID)
);

CREATE TABLE CLIENT
(
	CLIENT_ID int NOT NULL AUTO_INCREMENT,
	GH_ID int NOT NULL,
	CLIENT_STATUS char(1) NOT NULL,
	CLIENT_FNAME varchar(20) NOT NULL,
	CLIENT_LNAME varchar(20) NOT NULL,
	CLIENT_PHONE varchar(15),
	CLIENT_ADDRESS varchar(50),
	CLIENT_CITY varchar(20),
	CLIENT_MAX_HOURS int(3),
	CLIENT_KM int(3),
	CLIENT_NOTES text,
	PRIMARY KEY (CLIENT_ID),
	FOREIGN KEY (GH_ID) REFERENCES GROUP_HOME(GH_ID),
	FOREIGN KEY (CLIENT_STATUS) REFERENCES C_S_STATUS(C_S_STATUS_CODE)
);

CREATE TABLE DEPARTMENT
(
	DEP_CODE varchar(3) NOT NULL,
	GH_ID int NOT NULL,
	DEP_NAME varchar(30),
	DEP_DESC varchar(150),
	PRIMARY KEY (DEP_CODE),
	FOREIGN KEY (GH_ID) REFERENCES GROUP_HOME(GH_ID)
);

CREATE TABLE REC_SHIFT
(
	REC_ID int NOT NULL AUTO_INCREMENT,
	DEP_CODE varchar(3) NOT NULL,
	CLIENT_ID int NOT NULL,
	STAFF_ID int NOT NULL,
	REC_DAY char(3) NOT NULL,
	REC_START time,
	REC_END time,
	REC_NOTES text,
	PRIMARY KEY (REC_ID),
	FOREIGN KEY (DEP_CODE) REFERENCES DEPARTMENT(DEP_CODE),
	FOREIGN KEY (CLIENT_ID) REFERENCES CLIENT(CLIENT_ID),
	FOREIGN KEY (STAFF_ID) REFERENCES STAFF(STAFF_ID)
);

CREATE TABLE SHIFT
(
	SHIFT_ID int NOT NULL AUTO_INCREMENT,
	REC_ID int,
	STATUS_CODE char NOT NULL,
	DEP_CODE varchar(3) NOT NULL,
	CLIENT_ID int NOT NULL,
	STAFF_ID int NOT NULL,
	SHIFT_DATE date NOT NULL,
	SCHEDULED_START time,
	SCHEDULED_END time,
	CLAIMED_START time,
	CLAIMED_END time,
	APPROVED_START time,
	APPROVED_END time,
	SHIFT_NOTES text,
	PRIMARY KEY (SHIFT_ID),
	FOREIGN KEY (REC_ID) REFERENCES REC_SHIFT(REC_ID),
	FOREIGN KEY (STATUS_CODE) REFERENCES SHIFT_STATUS(STATUS_CODE),
	FOREIGN KEY (DEP_CODE) REFERENCES DEPARTMENT(DEP_CODE),
	FOREIGN KEY (CLIENT_ID) REFERENCES CLIENT(CLIENT_ID),
	FOREIGN KEY (STAFF_ID) REFERENCES STAFF(STAFF_ID)
);

INSERT INTO USER_TYPE VALUES ('C', 'Coordinator');
INSERT INTO USER_TYPE VALUES ('W', 'Worker');
INSERT INTO USER_TYPE VALUES ('S', 'Supervisor');
INSERT INTO USER_TYPE VALUES ('B', 'Bookkeeper');

INSERT INTO SHIFT_STATUS VALUES ('S', 'Scheduled');
INSERT INTO SHIFT_STATUS VALUES ('W', 'Worked');
INSERT INTO SHIFT_STATUS VALUES ('C', 'Claimed');
INSERT INTO SHIFT_STATUS VALUES ('A', 'Approved');
INSERT INTO SHIFT_STATUS VALUES ('X', 'Cancelled');

INSERT INTO C_S_STATUS VALUES ('A', 'Active');
INSERT INTO C_S_STATUS VALUES ('I', 'Inactive');
INSERT INTO C_S_STATUS VALUES ('H', 'On Hold');

