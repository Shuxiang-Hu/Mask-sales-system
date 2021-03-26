USE shysh1;

DROP TABLE  IF EXISTS customer;
CREATE TABLE customer(
        username VARCHAR(10) PRIMARY KEY NOT NULL,
    realname VARCHAR(255) NOT NULL,
    pwd VARCHAR(25) NOT NULL,
    passportID VARCHAR(255) UNIQUE NOT NULL,
    tel VARCHAR(30) UNIQUE NOT NULL,
    region VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL
);

DROP TABLE IF EXISTS representative;
CREATE TABLE representative(
        employeeID INT(25) PRIMARY KEY NOT NULL AUTO_INCREMENT, 
        username VARCHAR(10) UNIQUE NOT NULL,
    realname VARCHAR(255) NOT NULL,
        pwd VARCHAR(25) NOT NULL,
        tel VARCHAR(30) UNIQUE NOT NULL,
        region VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
    quota Int(10) NOT NULL
);

DROP TABLE IF EXISTS ordering;
CREATE TABLE ordering(
        orderingID Int(10) PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    Masktype VARCHAR(25) NOT NULL,
    quantity INT(10) NOT NULL,
    amount FLOAT(25) NOT NULL,
    customer VARCHAR(10) NOT NULL,
    employeeID INT(25) NOT NULL,
    orderStatus VARCHAR(25) NOT NULL,
    orderedTime DATETIME NOT NULL,    
    FOREIGN KEY (customer) REFERENCES customer(username),
    FOREIGN KEY (employeeID) REFERENCES representative(employeeID)
);

DROP TABLE IF EXISTS request;
CREATE TABLE request(
    requestID Int(10) PRIMARY KEY NOT NULL AUTO_INCREMENT, 
    quantity INT(10) NOT NULL,
    employeeID INT(25) NOT NULL,
    requestStatus VARCHAR(255)NOT NULL,   
    FOREIGN KEY (employeeID) REFERENCES representative(employeeID)
);


DROP TABLE IF EXISTS manager;
CREATE TABLE manager(
    username VARCHAR(10) PRIMARY KEY NOT NULL,
    pwd VARCHAR(25) NOT NULL
);

INSERT INTO manager (username, pwd) VALUES ("John","john12345");
INSERT INTO representative (employeeID, username, realname, pwd, tel, region, email, quota) VALUES ("5", "cat", "Qian Bai", "defaultpassword", "15672886176", "British", "jk563@qq.com", "0");
INSERT INTO representative (employeeID, username, realname, pwd, tel, region, email, quota) VALUES ("6", "dog", "Gerald Arthur", "defaultpassword", "14472966176", "Japan", "th753@qq.com", "50");
INSERT INTO representative (employeeID, username, realname, pwd, tel, region, email, quota) VALUES ("7", "aplle", "Baldwin Juliet", "defaultpassword", "13977486906", "China", "apple@qq.com", "23");
INSERT INTO representative (employeeID, username, realname, pwd, tel, region, email, quota) VALUES ("8", "banana", "Viola Hosea", "defaultpassword", "13672576110", "China", "banana@qq.com", "77");
INSERT INTO representative (employeeID, username, realname, pwd, tel, region, email, quota) VALUES ("9", "pear", "Rodney Doris", "defaultpassword", "15582876746", "Korean", "pear@qq.com", "10");
INSERT INTO representative (employeeID, username, realname, pwd, tel, region, email, quota) VALUES ("10", "jack", "Quincy Burns", "defaultpassword", "14742716536", "America", "jack@qq.com", "50");
INSERT INTO representative (employeeID, username, realname, pwd, tel, region, email, quota) VALUES ("11", "queen", "Ron Buckle", "defaultpassword", "13986485306", "China", "queen@qq.com", "100");
INSERT INTO representative (employeeID, username, realname, pwd, tel, region, email, quota) VALUES ("12", "king", "Hazel Jeames", "defaultpassword", "13466896110", "China", "king@qq.com", "47");

INSERT INTO customer (username, realname, pwd, passportID, tel, region, email) VALUES ("grape", "Rebecca Wilde", "defaultpassword", "RF5633", "15078246432", "China", "grape@qq.com");
INSERT INTO customer (username, realname, pwd, passportID, tel, region, email) VALUES ("juice", "Morton Philemon", "defaultpassword", "GH5581", "1406656462", "China", "juice@qq.com");
INSERT INTO customer (username, realname, pwd, passportID, tel, region, email) VALUES ("pig", "Elmer Boswell", "defaultpassword", "JD4523", "1527426853", "China", "pig@qq.com");
INSERT INTO customer (username, realname, pwd, passportID, tel, region, email) VALUES ("deer", "Martha Sophy", "defaultpassword", "EC5835", "15323546743", "China", "deer@qq.com");
INSERT INTO customer (username, realname, pwd, passportID, tel, region, email) VALUES ("uzi", "Jodie Birrell", "defaultpassword", "UJ5230", "12374546443", "China", "uzi@qq.com");
INSERT INTO customer (username, realname, pwd, passportID, tel, region, email) VALUES ("12345", "Otis Rosa", "defaultpassword", "LK5734", "15730246632", "China", "12345@qq.com");
INSERT INTO customer (username, realname, pwd, passportID, tel, region, email) VALUES ("321", "Boyd Austin", "defaultpassword", "QW2663", "17246249063", "China", "321@qq.com");
INSERT INTO customer (username, realname, pwd, passportID, tel, region, email) VALUES ("5555", "Suzanne Salome", "defaultpassword", "CV1648", "14578249732", "China", "5555@qq.com");
INSERT INTO customer (username, realname, pwd, passportID, tel, region, email) VALUES ("gran", "Ralap Scott", "defaultpassword", "HB4583", "1208904563", "China", "gran@qq.com");