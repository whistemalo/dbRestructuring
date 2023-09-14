CREATE SCHEMA IF NOT EXISTS staging;


CREATE TABLE IF NOT EXISTS staging.procesos (
    id serial PRIMARY KEY,
    id_request integer
);

CREATE TABLE IF NOT EXISTS staging.request_details_mapping (
    id_request_details_NEW serial PRIMARY KEY,
    id_request_OLD integer
);

CREATE TABLE IF NOT EXISTS staging.resquest_admins (
  idSolicitudCompra INTEGER
, lugarEntrega VARCHAR(250)
, CODI_EMPL VARCHAR(4)
, fhIngreso TIMESTAMP
, fhUltimaModificacion TIMESTAMP
);

CREATE TABLE IF NOT EXISTS staging.employee_mapping
(
  id INTEGER
, code_employee VARCHAR(4)
, username VARCHAR(15)
)
;


CREATE TABLE IF NOT EXISTS staging.po_statuses
(
  id_statuses BIGINT ,
   CODI_ESTA_OLD VARCHAR(2),
 DESC_ESTA VARCHAR(255)
)
;

