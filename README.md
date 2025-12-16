# 🛡️ Login MVC — Sistema de Autenticación Seguro en PHP

Este proyecto implementa un sistema de autenticación en **PHP** siguiendo el patrón **MVC (Modelo‑Vista‑Controlador)**, incorporando múltiples medidas de seguridad tanto en el cliente como en el servidor.  
El objetivo es demostrar cómo construir un login robusto, mantenible y protegido frente a ataques comunes como SQL Injection, XSS, session hijacking o fuerza bruta.

---

## ✨ Características principales

### 🔐 Autenticación segura
- Contraseñas almacenadas con `password_hash()`
- Verificación con `password_verify()`
- Consultas SQL preparadas (PDO)
- Sanitización de entradas del usuario
- Escapado de salida para evitar XSS

### 🛡️ Sesiones y cookies seguras
- Cookie de sesión configurada con:
  - `httponly`
  - `secure` (si hay HTTPS)
  - `samesite=Strict`
- Regeneración del ID de sesión tras login
- Token interno de sesión
- Verificación de User‑Agent e IP
- Expiración automática por inactividad
- Destrucción segura de sesión al cerrar sesión

### 🚫 Control de intentos fallidos
- Registro de intentos por usuario
- Bloqueo temporal tras varios intentos incorrectos
- Cálculo del tiempo restante de bloqueo
- Limpieza automática tras login exitoso

### 🧼 Validación y sanitización
- Validación en cliente mediante JavaScript
- Sanitización en servidor con `filter_var()` y `trim()`
- Escapado de salida con `htmlspecialchars()`

### 🧩 Arquitectura MVC
- **Modelos**: lógica de datos y consultas SQL  
- **Controladores**: flujo de autenticación y seguridad  
- **Vistas**: HTML limpio sin lógica de negocio  
- El archivo **index.php está en la raíz**, actuando como *Front Controller*  
- La carpeta `public/` contiene únicamente recursos estáticos (JS, CSS, imágenes)

---