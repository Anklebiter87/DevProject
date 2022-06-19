

CREATE DATABASE IF NOT EXISTS Pazaak;
DROP USER IF EXISTS 'pazaak'@'localhost';
CREATE USER 'pazaak'@'localhost' IDENTIFIED BY 'DevProjectFun2323';
GRANT ALL PRIVILEGES ON Pazaak.* TO 'pazaak'@'localhost';
