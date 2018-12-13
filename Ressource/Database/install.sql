CREATE DATABASE dutinfopw201622 ;
CREATE USER projet_web password 'najymahe';
GRANT ALL ON DATABASE dutinfopw201622 to projet_web;

\c dutinfopw201622
\i Script_tables/script-final.sql

--TRIGGERS
\i Triggers/semestre.sql


\i Fonctions/groupe-pgsql.sql
\i Fonctions/utilisateur/personnel-pgsql.sql