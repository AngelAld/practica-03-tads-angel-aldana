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

- [ ] Create CRUDs for tables:
  - [-] vehicle_types
  - [-] contract_types
  - [-] schedule_shift
  - [-] schedule_status
  - [-] brands
  - [-] brand_models
  - [-] colors
  - [ ] employees
  - [ ] vehicles

- [x] New Tables
  - [x] Period (for vacations)
  - [x] EmployeeFunction many to many relationship
  - [x] VehicleDriver many to many relationship
  - [x] Vehicle Images
  - [x] Refill Schedule
  - [x] Holydays (bounded to period)

- [x] Change employee type table name to employee function

- [ ] CRUDs For New Tables
  - [ ] Period
  - [ ] EmployeeFunction
  - [x] EmployeeFunctionDetail (the many to many relationship)
  - [ ] VehicleDriver (the employee to vehicle many to many relationship)
  - [ ] VehicleImages (Same page as Vehicle CRUD)
  - [ ] RefillSchedule
  - [ ] Holyday

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
  - [ ] Agregar la libreria para traducir jetstream a español (https://github.com/amendozaaguiar/laraveles-spanish-for-jetstream)
  - [ ] Agregar la traduccion de datatable (teniendo encuenta el firewall de la universidad)


  