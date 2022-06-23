CREATE USER escala_medica IDENTIFIED BY pepita_sjc_23062022_ouro_08_12;

GRANT CREATE SESSION TO escala_medica;
GRANT CREATE PROCEDURE TO escala_medica;
GRANT CREATE TABLE TO escala_medica;
GRANT CREATE TRIGGER TO escala_medica;
GRANT CREATE VIEW TO escala_medica;
GRANT UNLIMITED TABLESPACE TO escala_medica;
GRANT CREATE SEQUENCE TO escala_medica;

GRANT EXECUTE ON dbasgu.FNC_MV2000_HMVPEP TO escala_medica;
GRANT SELECT ON dbasgu.USUARIOS TO escala_medica;
GRANT SELECT ON DBASGU.PAPEL_USUARIOS TO escala_medica;
GRANT SELECT ON DBASGU.PAPEL TO escala_medica;

--SEQUENCES
--GRANT SELECT ON dbamv.SEQ_PRODUTO TO portal_cadastro;

--SELECT + INSERT
GRANT SELECT, INSERT ON dbamv.PRO_FAT TO portal_cadastro;

--SELECT
GRANT SELECT ON dbamv.PRESTADOR TO escala_medica;
GRANT REFERENCES ON dbamv.PRESTADOR TO escala_medica;
