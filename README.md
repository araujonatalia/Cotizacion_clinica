# Cotizacion_clinica

Prueba Técnica – Sistema de Gestión de Cotizaciones Médicas

Descripción General

Este proyecto tiene como objetivo desarrollar un sistema basado en una interfaz gráfica web que permita la consulta de cotizaciones médicas, con visualización de la información relacionada con el paciente, profesional, medicamentos y citas. La solución utiliza PHP, Bootstrap y JavaScript/jQuery, organizados mediante el patrón de diseño MVC (Modelo - Vista - Controlador).

Tecnologías Utilizadas

PHP 8+: Lenguaje de backend para manejar lógica de negocio, conexión con base de datos y renderizado del lado del servidor.

PostgreSQL: Sistema gestor de base de datos relacional donde se modelan todas las entidades del dominio médico (cotizaciones, citas, órdenes médicas, etc).

Bootstrap 5: Framework CSS para la creación de una interfaz visualmente amigable.

JavaScript/jQuery: Para realizar peticiones asincrónicas (AJAX) y mejorar la experiencia del usuario en tiempo real.

MVC: Separación de responsabilidades para escalabilidad y mantenimiento:

Modelo: Se encarga de interactuar con la base de datos.

Vista: HTML + Bootstrap para la interfaz de usuario.

Controlador: Recibe las peticiones del usuario, invoca los modelos y retorna las vistas.

Estructura del Proyecto

/
├── index.php // Punto de entrada
├── /controllers
│ └── QuotationController.php // Controlador principal
├── /models
│ ├── Database.php
│ ├── Quotation.php
│ ├── Patient.php
│ └── Appointment.php
├── /views
│ └── quotation_view.php // Vista con interfaz de búsqueda
├── /assets
│ ├── /css (Bootstrap)
│ └── /js (JS/jQuery)
└── README.md

Base de Datos

Se utilizó PostgreSQL para modelar las siguientes entidades clave:

gbl_entity: Tabla base para pacientes y profesionales.

com_quotation y com_quotation_line: Cotizaciones y sus detalles.

cnt_medical_order y cnt_medical_order_medicament: Órdenes médicas y medicamentos.

adm_admission y adm_admission_flow: Flujo de admisión del paciente.

sch_calendar, sch_event, sch_slot: Calendario de disponibilidad profesional.

sch_slot_assigned y sch_workflow_slot_assigned: Asignaciones de citas.

adm_admission_appointment: Relación entre admisión y cita.

Se incluyó también una sección de datos de prueba para simular un entorno realista de consultas.

Funcionamiento General

El usuario accede a index.php, que redirige al controlador CotizacionController.

El controlador lee los parámetros de búsqueda (por identificación del paciente o número de cotización).

A través de los modelos se consulta la base de datos y se ensamblan los datos relacionados (profesional, cita, medicamentos).

La vista (quotation_view.php) muestra los datos utilizando Bootstrap y tablas dinámicas.

Las búsquedas se pueden hacer sin recargar la página gracias al uso de AJAX con jQuery.

Interacción de Usuario

Búsqueda por número de cotización.

Visualización de:

Datos del paciente y profesional.

Fecha y hora de la cita.

Medicamentos prescritos.

Monto total y líneas de la cotización.

Captura de Interfaz
![image](https://github.com/user-attachments/assets/499f16fd-4928-4309-befb-ab5cd7010618)


Instalación Local

Clonar el repositorio:

git clone https://github.com/usuario/proyecto-cotizacion-medica.git

Adjunto base de datos en postgreSQL- Uso de scripts de creación e inserción de datos.
Ejecutar en navegador: http://localhost/proyecto-cotizacion-medica/index.php

Notas Finales
Este proyecto fue desarrollado con el propósito de demostrar habilidades en diseño de bases de datos relacionales, desarrollo con PHP, estructuración MVC y experiencia de usuario con tecnologías modernas del frontend.
Contacto
Desarrollador: Natalia Araujo Martinez
Correo: natikaraujo@gmail.com
LinkedIn: 
