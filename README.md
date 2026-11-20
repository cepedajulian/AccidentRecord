# Accident Record

**Registro, consulta y análisis geográfico de siniestros viales.**

Accident Record es una aplicación web desarrollada en **PHP con CodeIgniter 2** para registrar hechos de tránsito, documentar los vehículos y las personas involucradas, consultar estadísticas y visualizar la distribución geográfica de los siniestros.

El objetivo es facilitar el análisis de datos históricos para identificar **concentraciones de incidentes** y apoyar estudios de seguridad vial. Una mayor concentración de registros no constituye, por sí sola, una predicción de riesgo: su interpretación depende de la cobertura y calidad de los datos, el período analizado y la exposición al tránsito.

> **Estado del proyecto:** aplicación heredada (*legacy*). La documentación describe las funcionalidades presentes en el código facilitado, no certifica compatibilidad con las versiones actuales de PHP ni aptitud para despliegue público sin actualizaciones.

## Funcionalidades

- **Gestión de siniestros:** alta, consulta, edición y eliminación de registros; fecha y hora, municipio/localidad, calle o ruta, condiciones del entorno, tipo de accidente, causas y descripción.
- **Geolocalización:** selección y visualización de coordenadas de los incidentes sobre Google Maps.
- **Consulta cartográfica:** representación de siniestros mediante marcadores y filtros.
- **Mapa de calor histórico:** módulo diseñado para mostrar densidad de siniestros en un área geográfica. **Actualmente requiere migración** porque utiliza una API de Google descontinuada (ver «Limitaciones conocidas»).
- **Personas involucradas:** registro de víctimas y clasificación de lesiones, incluidas categorías como ileso, leve, grave y fallecido.
- **Vehículos involucrados:** asociación de vehículos a cada siniestro.
- **Evidencia fotográfica:** carga y consulta de imágenes relacionadas con registros.
- **Estadísticas:** gráficos y agregaciones por período y características de los siniestros, mediante Highcharts.
- **Exportación:** descarga de listados en un archivo con extensión `.xls`, generado a partir de una tabla HTML; no se trata de un libro Excel nativo.
- **Administración:** usuarios, roles, permisos, catálogos de municipios, localidades, calles, rutas y otros parámetros.
- **Auditoría básica:** registro de acciones de usuarios en la tabla `activity`.

La disponibilidad de cada opción en la interfaz depende de los permisos del usuario.

## Tecnologías

| Componente | Tecnología utilizada |
| --- | --- |
| Backend | PHP y CodeIgniter **2.1.4** |
| Arquitectura | MVC (controladores, modelos y vistas) |
| Base de datos | MySQL/MariaDB, controlador **MySQLi** |
| Servidor web | Configuración Apache mediante `.htaccess` |
| Interfaz | HTML, CSS, JavaScript, jQuery y Bootstrap |
| Mapas | Google Maps JavaScript API |
| Gráficos | Highcharts y otras bibliotecas de frontend incluidas |
| Autenticación | Sesiones de CodeIgniter almacenadas en `ci_sessions` |
| Control de acceso | Roles y permisos mediante la biblioteca `acl` |

El volcado suministrado fue generado desde **MariaDB 10.5.21**. Esta versión es una referencia del origen de los datos, no una garantía de compatibilidad con cualquier otra versión.

## Estructura del proyecto

```text
AccidentRecord-main/
├── application/
│   ├── config/                 # Conexión, URL, rutas y parámetros
│   ├── controllers/            # Login, siniestros, usuarios, configuración...
│   ├── models/                 # Acceso a datos
│   ├── views/                  # Pantallas y plantillas
│   │   └── siniestros/         # Formularios, mapas y estadísticas
│   ├── libraries/              # ACL y otras librerías
│   ├── core/                   # Extensiones de CodeIgniter
│   └── third_party/            # Dependencias de terceros
├── assets/                     # CSS, JavaScript, imágenes y plugins
├── files/                      # Imágenes y archivos asociados
├── system/                     # Framework CodeIgniter 2.1.4
├── siniestros.sql              # Esquema, catálogos y registros de ejemplo
├── .htaccess                   # Reescritura de URL para Apache
└── index.php                   # Punto de entrada
```

## Requisitos previos

- Un entorno de pruebas **aislado** con una versión de PHP compatible con esta aplicación heredada, incluida la extensión `mysqli`.
- Un servidor web, por ejemplo Apache con `mod_rewrite` si se utiliza el `.htaccess` incluido.
- MySQL o MariaDB y una cuenta de base de datos con los permisos adecuados.
- Una clave válida para **Google Maps JavaScript API**; pueden aplicarse requisitos de facturación, cuotas y restricciones de dominio.
- Un navegador moderno, teniendo en cuenta las limitaciones de las bibliotecas JavaScript antiguas incluidas.

**Aviso:** las versiones antiguas de PHP y CodeIgniter 2 están fuera del ciclo normal de mantenimiento. No se recomienda desplegar el proyecto directamente en Internet sin modernizar y auditar su seguridad.

## Instalación en un entorno local de pruebas

### 1. Colocar los archivos

Descomprimir el proyecto y copiarlo al directorio servido por Apache. Por ejemplo:

```text
/var/www/html/siniestros/
```

El directorio debe contener `index.php`, `application/`, `system/`, `assets/` y los demás archivos del repositorio.

### 2. Importar la base de datos

El archivo `siniestros.sql` contiene instrucciones que **eliminan la base de datos `siniestros` si ya existe** (`DROP DATABASE IF EXISTS`) y después la crean e importan sus tablas.

**Usar exclusivamente una instancia desechable o una base de datos previamente respaldada.** El siguiente comando debe ejecutarse solo después de revisar ese contenido:

```bash
mysql -u root -p < siniestros.sql
```

El SQL incluye tablas de siniestros, víctimas, vehículos, usuarios, roles, permisos, sesiones, catálogos y actividades. También contiene registros iniciales de usuarios y datos de configuración que deben considerarse **no aptos para publicación sin revisión y saneamiento**.

### 3. Configurar la conexión

Editar `application/config/database.php` y reemplazar los valores existentes por los de tu entorno:

```php
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'usuario_local';
$db['default']['password'] = 'clave_local_segura';
$db['default']['database'] = 'siniestros';
$db['default']['dbdriver'] = 'mysqli';
```

Crear un usuario de base de datos con privilegios limitados. No publicar credenciales reales en repositorios ni conservar las incluidas en configuraciones heredadas.

### 4. Configurar la URL del sitio

Editar `application/config/config.php`:

```php
$config['base_url'] = 'http://localhost/siniestros/';
$config['index_page'] = 'index.php';
```

La barra final de `base_url` es importante. El proyecto contiene enlaces que incluyen `index.php`; conviene mantener este ajuste durante la primera prueba. Revisar las reglas de `.htaccess` si el proyecto se despliega en un subdirectorio o en un servidor distinto de Apache.

En el mismo archivo se definen las coordenadas iniciales del mapa mediante `lat`, `lng` y `zoom`.

### 5. Configurar Google Maps

Localizar las URL de carga de Google Maps y sustituir sus claves de ejemplo o antiguas por una clave de tu proyecto de Google Cloud, restringida a los dominios autorizados.

Archivos que utilizan la API de Google Maps:

```text
application/views/siniestros/siniestros_form_view.php
application/views/siniestros/siniestros_details_view.php
application/views/siniestros/siniestros_map_view.php
application/views/siniestros/siniestros_heatmap_view.php
```

**Importante:** cambiar la clave no repara el mapa de calor: ese módulo necesita reemplazar `google.maps.visualization.HeatmapLayer` por una alternativa compatible.

### 6. Verificar el acceso

Abrir la URL configurada, por ejemplo:

```text
http://localhost/siniestros/index.php/login
```

La ruta por defecto dirige al controlador de autenticación (`login`). El proyecto **no incluye un instalador** para crear una cuenta administrativa nueva. Verificar o crear usuarios y roles de prueba de forma controlada en la base de datos; no utilizar cuentas ni contraseñas antiguas en un entorno accesible públicamente.

## Módulos y rutas principales

| Ruta de CodeIgniter | Función |
| --- | --- |
| `login` | Acceso a la aplicación |
| `home` | Pantalla principal |
| `siniestros` | Listado y búsqueda |
| `siniestros/add` | Nuevo siniestro |
| `siniestros/map` | Consulta de incidentes en el mapa |
| `siniestros/heatmap` | Mapa de calor heredado (requiere migración) |
| `siniestros/stats` | Estadísticas |
| `siniestros/export` | Exportación de registros |
| `users` | Administración de usuarios |
| `config` | Parámetros y catálogos |
| `activity` | Historial de actividades |

Las URL completas pueden incluir `/index.php/` según la configuración.

## Modelo de datos (tablas principales)

- `siniestros`: información general, ubicación, circunstancias y descripción del incidente.
- `victimas`: personas involucradas y lesiones asociadas al siniestro.
- `vehiculos`: vehículos asociados a un siniestro.
- `imagenes`: metadatos de archivos relacionados con registros.
- `config_ciudades`, `config_localidades`, `config_calles`, `config_rutas`: datos geográficos y catálogos.
- `users`, `role_data`, `perm_data`, `user_roles`, `role_perms`, `user_perms`: usuarios y autorización.
- `ci_sessions`: sesiones persistidas en base de datos.
- `activity`: registro de operaciones.

El esquema completo está disponible en `siniestros.sql`.

## Limitaciones conocidas y mantenimiento recomendado

1. **Mapa de calor descontinuado.** La vista `application/views/siniestros/siniestros_heatmap_view.php` utiliza `google.maps.visualization.HeatmapLayer`. Google retiró esta función en **mayo de 2026**. Para recuperarla, migrar a una implementación mantenida, como [`deck.gl` HeatmapLayer](https://deck.gl/docs/api-reference/aggregation-layers/heatmap-layer), sobre una base cartográfica compatible. Referencia: [deprecaciones oficiales de Google Maps](https://developers.google.com/maps/deprecations).
2. **Framework antiguo.** CodeIgniter 2.1.4 requiere una evaluación de compatibilidad y una migración planificada antes de usar PHP moderno o publicar el sistema en producción.
3. **Autenticación heredada.** Se utiliza `MD5` para verificar contraseñas en `application/models/users_model.php`; debe migrarse a `password_hash()`/`password_verify()` con una estrategia de transición de hashes.
4. **Protección CSRF desactivada.** La configuración actual tiene `csrf_protection = FALSE`; debe revisarse y habilitarse tras validar formularios y solicitudes AJAX.
5. **Consultas SQL dinámicas.** Hay filtros incorporados directamente a sentencias SQL en métodos como `Siniestros::buscar()` y `Siniestros::mapadibujar()`. Se recomienda sustituirlos por parámetros validados y consultas seguras, y comprobar la autorización en todos los endpoints.
6. **Dependencias antiguas.** Revisar las versiones de JavaScript, plugins, Highcharts y bibliotecas PHP antes de una puesta en producción.
7. **Datos sensibles.** Examinar `siniestros.sql`, archivos de configuración y contenidos cargados antes de compartir el repositorio; eliminar credenciales, claves, contraseñas/hash y datos personales o reemplazarlos por ejemplos ficticios.
8. **Interpretación estadística.** Los mapas muestran puntos o densidad histórica de hechos registrados; no calculan automáticamente una probabilidad de accidente ni ajustan por volumen vehicular, longitud de vía o subregistro.

Estos puntos surgieron de una revisión estática del repositorio: **no se ha ejecutado una auditoría de seguridad exhaustiva ni una batería de pruebas funcionales**.

## Licencia y componentes de terceros

El **código original del proyecto** se distribuye bajo la **licencia MIT**, conforme al archivo [`LICENSE`](LICENSE). Esto no cambia ni reemplaza las licencias de componentes de terceros que se distribuyen junto al código.

Entre las dependencias incluidas se encuentran **CodeIgniter 2.1.4**, **PHPExcel**, **NuSOAP**, **TinyMCE**, **Select2** y **Fine Uploader 4.3.1**. En particular, la versión incluida de **Fine Uploader declara GPLv3**, por lo que la distribución y modificación del conjunto requiere revisar las obligaciones aplicables a dicho componente. También deben conservarse los avisos de autor y archivos de licencia de las bibliotecas existentes en `assets/`, `application/` y `system/`.

**El archivo `LICENSE` no debe interpretarse como una relicencia de todo el contenido de terceros.** Antes de redistribuir una aplicación combinada, revisar compatibilidad y cumplimiento de las condiciones de cada dependencia. La copia de CodeIgniter 2.1.4 proviene del régimen de licencia de EllisLab, distinto del aplicado a versiones posteriores de CodeIgniter; debe incluirse el aviso correspondiente al redistribuir el framework.

## Autor

**Julián Cepeda** — [GitHub](https://github.com/cepedajulian)

---

*Accident Record es una herramienta de registro y análisis de siniestralidad vial. Sus resultados son auxiliares y no sustituyen evaluaciones técnicas, estudios de movilidad o decisiones de seguridad vial basadas en evidencia validada.*
