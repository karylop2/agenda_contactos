# AGENDA DE CONTACTOS

## DESCRIPCIÓN
Desarrollo en PHP y MySQL que permite logearse a los usuarios y ver el listado
de sus contactos registrados. El usuario registrado puede consultar, crear, 
editar y eliminar sus contactos.

**Asignatura:** Desarrollo Web — UTPL
**Autora:** Karina López

## FUNCIONALIDADES

- Registro de usuarios con validación de correo único.
- Inicio y cierre de sesión.
- Panel privado con el nombre, el correo y la lista de contactos del usuario.
- Crear, editar y eliminar contactos (con confirmación antes de eliminar).

## SEGURIDAD IMPLEMENTADA 

- Contraseñas almacenadas con `password_hash()` y verificadas con `password_verify()`.
- Consultas preparadas (`prepare` + `bind_param`) para evitar inyección SQL.
- Verificación de sesión activa en todas las páginas privadas.
- Filtro por `id_usuario` en todas las consultas de contactos: un usuario no puede
  acceder a contactos de otro usuario modificando la URL.
- Escape de datos al mostrarlos (`htmlspecialchars`) para prevenir XSS.
- Token CSRF en los formularios que crean, modifican o eliminan contactos.
- Mensajes de error que no revelan información sensible.

## TECNOLOGÍAS

- PHP 8.0
- MySQL / MariaDB
- HTML5
- Bootstrap 5.3.3
- XAMPP (Apache + MariaDB)

## REQUISITOS

- XAMPP (o similar) con Apache y MySQL activos.
- PHP 8.0 o superior.
- Navegador web.

## INSTALACIÓN

1. Descargar o clonar este repositorio.
2. Copiar la carpeta `agenda_contactos` dentro de `C:\xampp\htdocs\`.
3. Iniciar **Apache** y **MySQL** desde el panel de XAMPP.
4. Abrir `http://localhost/phpmyadmin`, ir a la pestaña Importar y seleccionar
   el archivo `database/agenda_db.sql` para crear la base.
5. Si el usuario o la contraseña de MySQL son distintos, modificarlos en `conexion.php`.
6. Abrir en el navegador: `http://localhost/agenda_contactos/`

## ESTRUCTURA DEL PROYECTO

agenda_contactos/
├── css/
│   └── estilos.css            # Bootstrap 5.3.3
├── database/
│   └── agenda_db.sql          # Script de la base de datos
├── index.php                  # Punto de entrada
├── conexion.php               # Conexión a MySQL
├── funciones.php              # Sesión, escape de datos y token CSRF
├── registrar.html             # Formulario de registro
├── guardar.php                # Procesa el registro
├── login.php                  # Formulario de inicio de sesión
├── validar_login.php          # Verifica credenciales y crea la sesión
├── logout.php                 # Cierra la sesión
├── panel.php                  # Panel principal con la lista de contactos
├── nuevo_contacto.php         # Formulario para crear un contacto
├── guardar_contacto.php       # Guarda el contacto
├── editar_contacto.php        # Formulario para editar un contacto
├── actualizar_contacto.php    # Actualiza el contacto
└── borrar_contacto.php        # Elimina el contacto