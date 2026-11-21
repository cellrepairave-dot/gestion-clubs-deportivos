CREATE DATABASE IF NOT EXISTS clubs_deportivos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE clubs_deportivos;

CREATE TABLE Clubes (
    club_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    deporte VARCHAR(50) NOT NULL,
    ubicacion VARCHAR(150) NOT NULL,
    fecha_fundacion DATE NOT NULL
);

CREATE TABLE Miembros (
    miembro_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    apellido VARCHAR(80) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    club_id INT NOT NULL,
    FOREIGN KEY (club_id) REFERENCES Clubes(club_id) ON DELETE CASCADE
);
