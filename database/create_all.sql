use MYSQL_DATABASE;
CREATE TABLE Politicos (ID int, titulo varchar(255), Nome varchar(255), Partido varchar(255), Foto varchar(255), Votos int);
INSERT INTO Politicos (ID, titulo, Nome, Partido, Foto, Votos) VALUES (51222, 'vereador', 'Christianne Varão', 'PEN', 'cv1.jpg', 0);
INSERT INTO Politicos (ID, titulo, Nome, Partido, Foto, Votos) VALUES (55555, 'vereador', 'Homero do Zé Filho', 'PSL', 'cv2.jpg', 0);
INSERT INTO Politicos (ID, titulo, Nome, Partido, Foto, Votos) VALUES (43333, 'vereador', 'Dandor', 'PV', 'cv3.jpg', 0);
INSERT INTO Politicos (ID, titulo, Nome, Partido, Foto, Votos) VALUES (15123, 'vereador', 'Filho', 'MDB', 'cv4.jpg', 0);
INSERT INTO Politicos (ID, titulo, Nome, Partido, Foto, Votos) VALUES (27222, 'vereador', 'Joel Varão', 'PSDC', 'cv5.jpg', 0);
INSERT INTO Politicos (ID, titulo, Nome, Partido, Foto, Votos) VALUES (45000, 'vereador', 'Professor Clebson Almeida', 'PSDB', 'cv6.jpg', 0);
INSERT INTO Politicos (ID, titulo, Nome, Partido, Foto, Votos) VALUES (12, 'prefeito', 'Chiquinho do Adbon', 'PDT', 'cp3.jpg', 0);
INSERT INTO Politicos (ID, titulo, Nome, Partido, Foto, Votos) VALUES (15, 'prefeito', 'Malrinete Gralhada', 'MDB', 'cp2.jpg', 0);
INSERT INTO Politicos (ID, titulo, Nome, Partido, Foto, Votos) VALUES (45, 'prefeito', 'Dr. Francisco', 'PSC', 'cp1.jpg', 0);
INSERT INTO Politicos (ID, titulo, Nome, Partido, Foto, Votos) VALUES (54, 'prefeito', 'Zé Lopes', 'PPL', 'cp4.jpg', 0);
INSERT INTO Politicos (ID, titulo, Nome, Partido, Foto, Votos) VALUES (65, 'prefeito', 'Lindomar Pescador', 'PC do B', 'cp5.jpg', 0);
alter user 'MYSQL_USER'@'%' identified with mysql_native_password by 'MYSQL_PASSWORD';
-- mysql -uroot -pMYSQL_ROOT_PASSWORD -e "alter user 'MYSQL_USER'@'%' identified with mysql_native_password by 'MYSQL_PASSWORD';"