# AI CONTEXT - PROYECTO MVC PHP

## Arquitectura obligatoria (NO romper)

Este proyecto sigue estrictamente el patrón MVC:

* Controller → maneja peticiones y lógica básica
* DAO → acceso a base de datos (consultas SQL)
* View → interfaz (HTML + JS)
* Lib → configuración (conexión, helpers)

⚠️ NUNCA mezclar responsabilidades:

* ❌ No hacer consultas SQL en el Controller
* ❌ No hacer lógica en la View
* ❌ No acceder directamente a la BD desde la View

---

## Estructura del proyecto

* /Controller/Ciudad/CtrlCiudad.php
* /DAO/Ciudad/CiudadDAO.php
* /View/Ciudad/viewCiudad.php
* /View/Ciudad/ciudad.js

---

## Flujo de funcionamiento

1. El usuario interactúa con la vista

2. JS (DataTable o AJAX) llama a:
   ajax.php?module=Ciudad&controller=Ciudad&function=...

3. El Controller:

   * recibe la petición
   * llama al DAO
   * procesa datos

4. El DAO:

   * ejecuta consultas SQL
   * retorna datos

5. El Controller:

   * devuelve JSON o carga una vista

---

## Convenciones obligatorias

### Controller

* Extiende del DAO
* Métodos públicos para cada acción:

  * read()
  * data()
  * postNew()
  * update()
  * delete()

---

### DAO

* SOLO consultas SQL
* Métodos tipo:

  * getAll()
  * getById()
  * insert()
  * update()
  * delete()

---

### View (PHP + HTML)

* No lógica de negocio
* Usa formularios y tablas
* Usa funciones como getUrl()

---

### JavaScript

* Maneja DataTables
* Hace llamadas AJAX
* No contiene lógica del backend

---

## Formato de respuestas

Cuando el Controller responde a DataTables:

{
"data": [
{
"id": "",
"nombre": "",
"depto": "",
"habitantes": "",
"buttons": ""
}
]
}

---

## Reglas IMPORTANTES para la IA

Cuando generes código:

1. RESPETAR la arquitectura MVC
2. NO mezclar DAO con Controller
3. NO escribir SQL fuera del DAO
4. Mantener nombres consistentes (Ciudad, CtrlCiudad, CiudadDAO)
5. Usar JSON para respuestas AJAX
6. Mantener compatibilidad con DataTables

---

## Tareas comunes que se deben soportar

* Listar datos (data())
* Crear registros (postNew)
* Editar registros (update)
* Eliminar registros (delete)

Siempre siguiendo el flujo MVC.

---

## Ejemplo de flujo correcto

JS → AJAX → Controller → DAO → BD → DAO → Controller → JSON → DataTable

---

## NOTA FINAL

Si alguna solicitud rompe el patrón MVC:
❌ NO hacerlo
✔️ Proponer una alternativa correcta dentro de MVC
