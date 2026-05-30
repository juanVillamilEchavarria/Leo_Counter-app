<p align="center">
  <img src="public/favicon.svg" alt="Leo Counter Logo" width="150" onerror="this.onerror=null; this.src='public/favicon.png'">
</p>

<h1 align="center">Leo Counter</h1>

<p align="center">
  <strong>Sistema de Gestión Financiera Open Source</strong><br>
  Construido con los más altos estándares de ingeniería
</p>
<p align="center">
  <em>Creado Por <a href="https://github.com/juanVillamilEchavarria">Juan Esteban Villamil Echavarria</a></em>
</p>

---

## Sobre Leo Counter

Leo Counter es una plataforma web **autoalojada** de gestión financiera diseñada para que hogares y  negocios mantengan el control total de su economía, construida en memoria del Ingeniero Leonardo Villamil Gamba 

Leo Counter permite registrar y gestionar ingresos, gastos, cuentas bancarias, presupuestos, categorías y otros elementos financieros relevantes. El sistema se compone de varios módulos integrados (Movimientos y sus Subgrupos, Presupuestos, Cuentas, Categorías, etc.) que cubren las necesidades básicas de contabilidad 

Cada línea de código refleja meses de dedicación aplicando principios de arquitectura de software al más alto nivel: Domain-Driven Design, CQRS, Clean Architecture y SOLID. El resultado es un sistema impecable, extensible y preparado para funcionar durante décadas.

La privacidad es absoluta. Tus datos nunca abandonan tu red local. El proyecto es completamente open source y puedes instalarlo en cualquier máquina con Docker, desde una laptop antigua hasta un servidor doméstico.

---

## Requisitos previos

Antes de comenzar, asegúrate de que tu sistema cumple con los siguientes requisitos.

**Linux (Fedora, Ubuntu, Debian, etc.):**
- Docker Engine instalado y en ejecución.
- Docker Compose v2 disponible.
- Tu usuario debe pertenecer al grupo `docker`. Si no es así, ejecuta `sudo usermod -aG docker $USER` y reinicia sesión.

**Windows:**
- Docker Desktop instalado y corriendo en segundo plano.
- PowerShell 5.1 o superior.
- WSL2 habilitado (recomendado para máximo rendimiento).

---

# Instalación
**Lo primero que debes hacer es clonar este repositorio para obtener el codigo de la palicacion**:
```bash
git clone https://github.com/juanVillamilEchavarria/Leo_Counter-app
```

## Despliegue en producción

El entorno de producción compila el código fuente, optimiza el autoloader de Composer, empaqueta los assets de React con Vite y aísla la aplicación de tu máquina anfitriona. Solo necesitas los contenedores; no tocas nada de código.

### Instalación en Linux

El script `install.sh` automatiza todo el proceso. Construye las imágenes Docker, inicia los servicios de soporte, ejecuta las migraciones y seeders, optimiza Laravel y configura un servicio `systemd` para que Leo Counter se ejecute en segundo plano como cualquier otro servicio del sistema.

Pasos:

1) Abre una terminal en la raíz del proyecto.
2) Otorga permisos de ejecución al script:
    ```bash
    chmod +x install.sh
3) Ejecuta el instalador:

    ```bash
    ./install.sh
    ```
Si no existe un archivo .env, el script pausará la instalación para que configures las credenciales. Edita el archivo .env generado desde .env.example y presta especial atención a estas variables:

```
DB_ROOT_PASSWORD

DB_USERNAME

DB_PASSWORD

APP_URL
```
Una vez guardado, presiona **Enter** para continuar.

**El instalador realiza, en orden**:

1) Verificación de requisitos (Docker Engine, Docker Compose, grupo docker).

2) Creación del archivo .env a partir de .env.example.

3) Construcción de la estructura de directorios de almacenamiento.

4) Ajuste de permisos base.

5) Lectura de las variables de entorno necesarias para el build de Vite y Reverb.

6) Construcción de la imagen Docker sin caché.

7) Inicio de los servicios de soporte (MariaDB, Redis, Mailhog, PhpMyAdmin).

8) Espera activa hasta que la base de datos esté saludable.

9) Inicio del contenedor de la aplicación.

10) Ejecución de migraciones y seeders de Laravel.

11) Limpieza y regeneración de cachés.

12) Configuración del servicio systemd leo-counter.service.

13) Arranque final de todos los servicios.

**Al terminar, verás un resumen con las URLs de acceso.**

### Instalación en Windows
El script `install.ps1` realiza las mismas operaciones que su contraparte de Linux, adaptándose a las particularidades de PowerShell y Docker Desktop.

Pasos:

1) Abre PowerShell como Administrador en la raíz del proyecto.

2) Habilita temporalmente la ejecución de scripts locales:

    ```powershell
    Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope Process
    ```
3) Ejecuta el instalador:

    ```powershell
    .\install.ps1
    ```
***Sigue las instrucciones en pantalla para configurar el archivo .env.***

El script se encarga de extraer las variables de entorno del archivo `.env` mediante una función personalizada que evita problemas con comillas y espacios, y las inyecta como argumentos de construcción en docker compose build. El resto del flujo es idéntico al de Linux, excepto la configuración del servicio systemd, que no aplica en Windows.

## Entorno de desarrollo
El modo de desarrollo monta el código fuente de tu máquina directamente en los contenedores mediante bind mounts. Esto permite que los cambios en el frontend (React con Vite) y en el backend (PHP con Laravel) se reflejen instantáneamente sin reconstruir imágenes.

### Desarrollo en Linux
El script `dev.sh` prepara las carpetas locales, ajusta permisos y propiedad para evitar conflictos con SELinux, e instala las dependencias de PHP y Node dentro del contenedor.

Pasos:

1) Otorga permisos al script:

```bash
chmod +x dev.sh
```
2) Inicia el entorno:

```bash
./dev.sh
```
3) Para activar la recarga en vivo de React (Hot Module Replacement), abre otra terminal y ejecuta:

```bash
docker compose -f docker-compose.dev.yml exec app pnpm run dev
```
El script `dev.sh` también maneja la configuración de Git dentro del contenedor y aplica contextos SELinux cuando es necesario.

### Desarrollo en Windows
El script `dev.ps1` realiza las mismas operaciones, aprovechando que Docker Desktop administra automáticamente los permisos de los volúmenes compartidos.

Pasos:

1) Abre PowerShell en la raíz del proyecto.

2) Ejecuta:
    ```powershell
    .\dev.ps1
    ```
3) Para Vite con Hot Reload:
    ```powershell
    docker compose -f docker-compose.dev.yml exec app pnpm run dev
    ```
## Puertos y accesos
Una vez finalizada la instalación, **los siguientes servicios estarán disponibles**:


1) **Leo Counter (App)**	http://localhost:8080	Interfaz principal del sistema financiero.
2) **PhpMyAdmin**	http://localhost:8082	Gestor visual de la base de datos MariaDB.
3) **Mailhog**	http://localhost:8025	Bandeja virtual para capturar correos salientes en desarrollo.
4) **Reverb WebSockets**	ws://localhost:8085	Puerto de conexión para eventos en tiempo real.

### Comandos de mantenimiento y solución de problemas
#### Entorno de producción (Linux con systemd)
**Detener la aplicación**:

```bash
sudo systemctl stop leo-counter.service
```
**Iniciar la aplicación**:

```bash
sudo systemctl start leo-counter.service
```
**Ver el estado**:

```bash
sudo systemctl status leo-counter.service
```
#### Para Windows o Si systemd no está disponible, puedes usar los comandos directos de Docker Compose:

**Detener**:

```bash
docker compose down
```
**Iniciar**:

```bash
docker compose up -d
```
### Entorno de desarrollo (ambos sistemas operativos)
**Apagar el entorno completamente**:

```bash
docker compose -f docker-compose.dev.yml down
```
**Iniciar el entorno**:

```bash
docker compose -f docker-compose.dev.yml up -d
```
**Instalar nuevos paquetes tras modificar package.json**:

```bash
docker compose -f docker-compose.dev.yml exec app pnpm install
```
**Si modificas el archivo .env y no se reflejan los cambios**:

```bash
docker compose -f docker-compose.dev.yml exec app php artisan config:clear
```
## Revisión de logs
***Si encuentras un error 500 o la aplicación no responde correctamente, revisa los registros de Laravel***:

```bash
docker compose exec app cat storage/logs/laravel.log
```
**También puedes seguir los logs en tiempo real**:

```bash
docker compose logs -f app
```

---
<p align="center" >Leo Counter — Tus Finanzas, Tu Control.</p>
