## Pendings
### To add
- Tickets
- Contactos
- Passwords complex
### Changed
### Deprecated
### Removed
### To Fixed
### Security

<!-- antes de subir proyecto completo
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear -->

## [0.0.5] - 2026-08-24
### Added 
- Se agrego los modelos y migración de Adicional_Cache, Adicional, Evento, Reserva. 
- ABM de Eventos.
- Modal de Reservas
- VIsta reservas del cliente
- refactory de welcome Blade.
- Modificaciones varias por la implementacion en servidor.

## [0.0.4] - 2026-08-04
### Added 
- Array de roles en constants.php con rol de clientes
- agregarRoleToUser desarrollado
- Registro de clientes redirije a la vista clientes
- Vista de Cliente
### To Fixed
- corregir links en vista Permissions

## [0.0.3] - 2024-07-31
### Added 
- https://github.com/spatie/laravel-permission | https://spatie.be/docs/laravel-permission/v6/introduction | Installed
- Flash Messages
- Crud de Permisos 
- Crud de Roles
- Métodos de Permisos Factory
- Edit php.ini with the following line 'extension=php_zip.dll'

## [0.0.2] - 2024-07-17
### Added 
- Crud de usuarios
    1. Pedido de renovacion de pass por expirado
    2. Editar usuarios
    3. Paginate
    4. Habilitar, deshabilitar usuarios
    5. Validación de mail obligatorio
    6. Cambio email pide nueva validacion de email
    7. Caja de Busqueda de Usuarios


## [0.0.1] - 2024-06-07
### Added
- First Commit
    1. Laravel Framework 11. 
    2. Livewire installed. 
    3. Vista basica de Welcome con header, footer y main
    4. Instalación de Breeze
    5. Configuración de User validation. 
    6. View_mode.
