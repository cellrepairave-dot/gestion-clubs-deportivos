# Sistema de Gestión de Clubs Deportivos

Sistema web desarrollado en **PHP 8** y **MySQL** para gestionar clubes deportivos y sus miembros.

## Estructura de la Base de Datos
- **Clubes**: `club_id`, `nombre`, `deporte`, `ubicacion`, `fecha_fundacion`
- **Miembros**: `miembro_id`, `nombre`, `apellido`, `email`, `telefono`, `club_id`

## Instalación
1. Importar el archivo `database.sql` en phpMyAdmin o MySQL.
2. Configurar las credenciales en `conexion.php`.
3. Ejecutar el proyecto en un servidor local (XAMPP/Laragon) y abrir `index.php`.
