-- Eliminar la base de datos si ya existe (para empezar desde cero)
DROP DATABASE IF EXISTS EscuelaDB;

-- Crear la base de datos
CREATE DATABASE EscuelaDB;

-- Usar la base de datos recién creada
USE EscuelaDB;

-- Tabla para los departamentos
CREATE TABLE Departamentos (
    DepartamentoID INT PRIMARY KEY AUTO_INCREMENT,
    NombreDepartamento VARCHAR(100) NOT NULL UNIQUE,
    Descripcion VARCHAR(255)
);

-- Tabla para los miembros del departamento
CREATE TABLE MiembrosDepartamento (
    MiembroID INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(100) NOT NULL,
    Apellido VARCHAR(100) NOT NULL,
    Email VARCHAR(100) UNIQUE,
    Telefono VARCHAR(20),
    DepartamentoID INT,
    FechaIngreso DATE,
    FOREIGN KEY (DepartamentoID) REFERENCES Departamentos(DepartamentoID)
);

-- Insertar algunos datos de ejemplo en la tabla Departamentos
INSERT INTO Departamentos (NombreDepartamento, Descripcion) VALUES
('Matemáticas', 'Departamento dedicado al estudio de las matemáticas y estadística.'),
('Ciencias', 'Departamento que abarca biología, química y física.'),
('Literatura', 'Departamento enfocado en el estudio de la literatura y el lenguaje.'),
('Informática', 'Departamento de ciencias de la computación e ingeniería de software.'),
('Historia', 'Departamento dedicado al estudio del pasado y las ciencias sociales.');

-- Insertar algunos datos de ejemplo en la tabla MiembrosDepartamento
INSERT INTO MiembrosDepartamento (Nombre, Apellido, Email, Telefono, DepartamentoID, FechaIngreso) VALUES
('Ana', 'García', 'ana.garcia@escuela.com', '968 12 34 56', 1, '2020-08-15'),
('Luis', 'Martínez', 'luis.martinez@escuela.com', '654 98 76 54', 1, '2018-05-20'),
('Sofía', 'Pérez', 'sofia.perez@escuela.com', '968 55 44 33', 2, '2022-01-10'),
('Javier', 'López', 'javier.lopez@escuela.com', '677 22 33 44', 2, '2021-09-01'),
('Carmen', 'Ruiz', 'carmen.ruiz@escuela.com', '968 77 88 99', 3, '2019-11-25'),
('Pedro', 'Sánchez', 'pedro.sanchez@escuela.com', '611 22 33 44', 4, '2023-03-01'),
('Isabel', 'Díaz', 'isabel.diaz@escuela.com', '968 44 55 66', 4, '2020-06-01'),
('Miguel', 'Fernández', 'miguel.fernandez@escuela.com', '633 44 55 66', 5, '2024-02-15');

-- Consultas básicas para verificar los datos
SELECT * FROM Departamentos;
SELECT * FROM MiembrosDepartamento;

-- Consulta para obtener los miembros de un departamento específico
SELECT m.Nombre, m.Apellido, d.NombreDepartamento
FROM MiembrosDepartamento m
JOIN Departamentos d ON m.DepartamentoID = d.DepartamentoID
WHERE d.NombreDepartamento = 'Matemáticas';