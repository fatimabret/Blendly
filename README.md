# 🛒 Sistema de Gestión de Ventas – Blendly Bebidas

![PHP](https://img.shields.io/badge/PHP-8.0-777BB4?style=for-the-badge&logo=php&logoColor=white)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.0-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)

> Aplicación web integral para la gestión de ventas online con arquitectura MVC y generación automática de comprobantes.

---

## 📖 Descripción del Proyecto

Este sistema gestiona el flujo completo de una venta electrónica, desde la selección de productos en un catálogo dinámico hasta la emisión del comprobante en PDF. 

Está desarrollado priorizando la **integridad de datos** y la **escalabilidad**, implementando patrones de diseño robustos y una base de datos relacional normalizada.

---

## 🚀 Funcionalidades Principales

* **🛒 Carrito de Compras:** Persistencia en sesión y cálculo dinámico de subtotales.
* **📑 Gestión de Pedidos:** Estructura Maestro-Detalle (Cabecera + Renglones).
* **📄 Facturación Automática:** Generación de PDFs con DOMPDF tras confirmar la compra.
* **🔒 Seguridad:** Validaciones en servidor, protección CSRF y sanitización de datos (`esc()`).
* **👤 Gestión de Usuarios:** Registro, autenticación y persistencia de datos del cliente en cada pedido.
* **📦 Catálogo Dinámico:** Filtrado por categorías y control de stock.

---

## 🧠 Arquitectura y Lógica de Negocio

El núcleo del sistema se basa en un modelo transaccional robusto:

### 1. Modelo Relacional Normalizado (Cabecera – Detalle)
Se implementó una separación estricta para garantizar la integridad:
* `pedido`: Almacena datos generales (Cliente, Fecha, Total, Estado).
* `pedido_detalle`: Almacena cada producto individual, su precio unitario congelado al momento de la compra y cantidad.

### 2. Inmutabilidad de Datos
> **Problema:** ¿Qué pasa si el cliente cambia su dirección o el producto cambia de precio después de una venta?
> **Solución:** Los datos del cliente y los precios se "congelan" en la tabla de pedidos al momento de la transacción. Esto garantiza la trazabilidad histórica y la consistencia contable.

### 3. Cálculo Transaccional
El sistema realiza validaciones cruzadas de los totales en tres momentos para evitar inconsistencias:
1.  En la vista del carrito (Frontend).
2.  Al procesar la orden (Backend).
3.  Al generar el PDF (Documento final).

---

## 🛠️ Stack Tecnológico

### Backend
* **Lenguaje:** PHP 8
* **Framework:** CodeIgniter 4 (MVC)
* **Librerías:** DOMPDF (Reportes), Composer.

### Base de Datos
* **Motor:** MySQL
* **Diseño:** Relacional, Normalizado (3FN), Integridad referencial (FKs).

### Frontend
* **Framework:** Bootstrap 5
* **Scripting:** JavaScript, HTML5, CSS3.
* **UX:** Modales dinámicos para resumen de compra.

---

## 📝 Instalación y Despliegue

1.  Clonar el repositorio:
    ```bash
    git clone https://github.com/fatimabret/Blendly.git
    ```
2.  Instalar dependencias:
    ```bash
    composer install
    ```
3.  Configurar base de datos:
    * Importar el script `db_blendly.sql` en MySQL.
    * Configurar credenciales en el archivo `.env`.
4.  Ejecutar servidor local:
    ```bash
    php spark serve
    ```

---
**Desarrollado por Fatima Bret** - *Estudiante de Lic. en Sistemas de Información*
