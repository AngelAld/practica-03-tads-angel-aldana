# TODO

- [x] Create migrations for tables:

  - [x] employee_types
  - [x] employees
  - [x] departament
  - [x] province
  - [x] district
  - [x] zones
  - [x] zone_coords
  - [x] brands
  - [x] brand_models
  - [x] colors
  - [x] vehicle_types
  - [x] vehicles
  - [x] contract_types
  - [x] contracts
  - [x] vacations
  - [x] assistances
  - [x] schedule_status
  - [x] schedule_shift
  - [x] schedules
  - [x] schedule_vehicles
  - [x] schedule_employees

- [x] Order migrations

- [x] Seed Locations

  - [x] Departments
  - [x] Provinces
  - [x] Districts

- [x] Seed Other tables

  - [x] employee_types
  - [x] vehicle_types
  - [x] contract_types
  - [x] schedule_shift
  - [x] schedule_status

- [x] Create CRUDs for tables:

  - [x] vehicle_types
  - [x] contract_types
  - [x] schedule_shifts
  - [x] schedule_status
  - [x] brands
  - [x] brand_models
  - [x] colors
  - [x] employees
  - [x] vehicles

- [x] New Tables

  - [x] Period (for vacations)

  - [x] EmployeeFunction many to many relationship
  - [x] VehicleDriver many to many relationship
  - [x] Vehicle Images
  - [x] Refill Schedule
  - [x] Holydays (bounded to period)

- [x] Change employee type table name to employee function

- [x] CRUDs For New Tables
  - [x] Period (Chung)
  - [x] EmployeeFunction (Chung)
  - [x] EmployeeFunctionDetail (the many to many relationship)
  - [x] VehicleImages (Same page as Vehicle CRUD) (Aldana)
  - [x] Holyday (Chung)

## 14 jun

- [ ] Contrato (Vasquez)

  - [ ] tipo de contrato, empleado
  - [ ] validación de contrato temporal:fecha inicio (2 meses desde el ultimo contrato)
  - [ ] validación de contrato temporal: fecha actual (2 meses desde el ultimo contrato)
  - [ ] validación de contrato temporal: duración maxima (2 meses\*)

  - [ ] solo 1 contrato vigente a la vez
  - [ ] Agregar atributo clave (numero de 5 digitos hasheado)

- [ ] Vacaciones (Galvez)

  - [ ] por contrato (empleado)
  - [ ] 30 días como maximo por periodo (año)
  - [ ] pueden estar divididas en varias vacaciones
  - [ ] solo contrato permanente tiene vacaciones

- [ ] Asistencia (Aldana)

  - [ ] pantalla externa al adminlte
  - [ ] dni y clave, la clave de contrato
  - [ ] validación de hacerlo en mismo día

- [ ] Programación de cargar gasolina (Vasquez y Iván)

  - [ ] validación de cruce con programación (vehiculo y conductor) (está postergada hasta que tengamos programación)
  - [ ] agregar hora inicio y hora fin en la tabla
  - [ ] Cambiar relacion de employeefunctiondetail a contract

- [ ] Turnos (Ivan)

  - [ ] Agregar hora inicio y hora fin a la tabla

- [ ] Programación (crear)

  - [ ] Programación vehiculo
  - [ ] Programación empleado
  - [ ] Preferencia vehiculo conductor (función separada que se llama en este proceso)
  - [ ] Validación vacaciones
  - [ ] Advertencia feriados
  - [ ] Cruce con otras programaciones

- [ ] Función de validar cruce de programaciones de vehiculo

  - [ ] validar cruce con programaciones
  - [ ] validar cruce con recarga
  - [ ] validar estado del vehiculo

- [ ] Función de validar cruce de programaciones de empleado
  - [ ] validar contrato vigente
  - [ ] validar vacaciones
- [ ] Asistencia Vehiculo (Aldana)
  - [ ] No es una tabla real
  - [ ] Debe actualizar el estado de los vehicleSchedule del día a listo para iniciar o cancelado con observación
- [ ] Iniciar Programación

  - [ ] Validación asistencia
  - [ ] Validación del vehiculo
  - [ ] reprogramación
    - [ ] Programación vehiculo
    - [ ] Programación empleado
    - [ ] Validación vacaciones
    - [ ] Advertencia feriados
    - [ ] Cruce con otras programaciones
    - [ ] Sugerencia de retenes

- [ ] Programaciones en proceso

  - [ ] Cambiar estado de programación a cancelado por alguna eventualidad

- [ ] Finalizar Programación
  - [ ] Al finalizar el turno, si no hubo eventualidad sus programaciones pasan al estado completado

// Adicionales (sin ordenas)

- [x] ScheduleStatus defined:
  - asignado
  - listo para iniciar
  - en proceso
  - finalizado
  - cancelado

<!-- Coorecciones del la del viernes 6 de junio -->

- [ ] Add hours for schedule shifts
- [ ] Add assistances to employees
- [ ] Add validations to the forms of employees and vehicles

  - [ ] license plate
  - [ ] document number
  - [ ] phone number
  - [ ] email
  - [ ] etc.

  - [ ] Personalizar el template de adminlte (Colores, logos, textos, etc.)
  - [ ] Agregar la libreria para traducir jetstream a español (<https://github.com/amendozaaguiar/laraveles-spanish-for-jetstream>)
  - [ ] Agregar la traduccion de datatable (teniendo encuenta el firewall de la universidad)

<!-- Coorecciones del Viernes 13 de junio -->

- [ ] Show all zones in a map
- [ ] Agrupar el menu por entidades
