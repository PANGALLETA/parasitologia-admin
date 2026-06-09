# Sistema de Parasitología Animal

Sistema web desarrollado en Laravel 13 para la gestión de información sobre parasitología animal.

## Tecnologías Utilizadas

* Laravel 13
* PHP 8.2+
* MySQL 8+
* Laravel Breeze
* Tailwind CSS
* Vite
* Spatie Laravel Permission
* SweetAlert2
* Gmail SMTP

---

# Requisitos

Antes de instalar el proyecto asegúrese de tener:

* PHP 8.2 o superior
* Composer
* Node.js 20 o superior
* MySQL 8 o superior
* Git

Verificar versiones:

```bash
php -v
composer -V
node -v
npm -v
mysql --version
```

---

# Clonar el Proyecto

```bash
git clone https://github.com/PANGALLETA/parasitologia-admin.git
cd parasitologia-admin
```

---

# Instalar Dependencias

## Dependencias PHP

```bash
composer install
```

## Dependencias Frontend

```bash
npm install
```

---

# Configurar Variables de Entorno

Copiar el archivo de ejemplo:

### Windows

```bash
copy .env.example .env
```

### Linux

```bash
cp .env.example .env
```

---

# Generar Clave de Aplicación

```bash
php artisan key:generate
```

---

# Configuración Base de Datos

Crear una base de datos llamada:

```sql
CREATE DATABASE parasitologia
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Configurar el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=parasitologia
DB_USERNAME=root
DB_PASSWORD=
```

---

# Configuración de Correo

Configurar en `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="Sistema de Parasitología"
```

Después ejecutar:

```bash
php artisan config:clear
```

---

# Ejecutar Migraciones

```bash
php artisan migrate
```

---

# Crear Roles Iniciales

Si existe un seeder:

```bash
php artisan db:seed
```

o

```bash
php artisan migrate:fresh --seed
```

Los roles del sistema son:

* Administrador
* Profesor
* Estudiante

---

# Compilar Recursos Frontend

## Desarrollo

```bash
npm run dev
```

## Producción

```bash
npm run build
```

---

# Ejecutar el Sistema

```bash
php artisan serve
```

Abrir:

```text
http://127.0.0.1:8000
```

---

# Verificaciones Después de la Instalación

## Usuarios

Verificar que:

* Se puedan crear usuarios.
* Se puedan editar usuarios.
* Se puedan activar/desactivar usuarios.
* Se pueda filtrar por nombre.
* Se pueda filtrar por rol.
* Se pueda filtrar por estado.

---

## Roles

Verificar:

### Administrador

* Acceso completo.

### Profesor

* Acceso a usuarios.
* Acceso a parásitos.
* Sin acceso a roles.

### Estudiante

* Crear parásitos.
* Editar parásitos.
* Sin eliminar registros.

---

## Autenticación

Verificar:

### Login

```text
/login
```

### Logout

Cerrar sesión correctamente.

### Mi Perfil

* Actualizar nombre.
* Actualizar correo.

### Cambio de Contraseña

Desde:

```text
/profile
```

### Recuperación de Contraseña

Desde:

```text
/forgot-password
```

Verificar:

* Recepción del correo.
* Apertura del enlace.
* Cambio de contraseña.
* Inicio de sesión con la nueva contraseña.

---

# Comandos Útiles

## Limpiar Caché

```bash
php artisan optimize:clear
```

---

## Limpiar Configuración

```bash
php artisan config:clear
```

---

## Ver Rutas

```bash
php artisan route:list
```

---

## Ver Estado de Migraciones

```bash
php artisan migrate:status
```

---

## Reiniciar Base de Datos

```bash
php artisan migrate:fresh
```

---

## Reiniciar Base de Datos con Seeders

```bash
php artisan migrate:fresh --seed
```

---

## Regenerar Autoload

```bash
composer dump-autoload
```

---

# Dependencias del Proyecto

## Laravel Breeze

Sistema de autenticación.

## Spatie Laravel Permission

Gestión de roles y permisos.

## Tailwind CSS

Interfaz de usuario.

## SweetAlert2

Alertas y confirmaciones visuales.

## Gmail SMTP

Recuperación de contraseña por correo electrónico.

---

# Módulos Implementados

* Autenticación
* Recuperación de contraseña
* Cambio de contraseña
* Gestión de usuarios
* Gestión de roles
* Perfil de usuario
* Activación e inactivación de usuarios
* Filtros de usuarios

---

# Universidad Tecnológica de Pereira

Proyecto de Grado

Sistema Web para Gestión de Información sobre Parasitología Animal.
