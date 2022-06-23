CREATE USER portal_cadastro IDENTIFIED BY sjc_pepita_24052022_ouro_1411;

GRANT CREATE SESSION TO portal_cadastro;
GRANT CREATE PROCEDURE TO portal_cadastro;
GRANT CREATE TABLE TO portal_cadastro;
GRANT CREATE TRIGGER TO portal_cadastro;
GRANT CREATE VIEW TO portal_cadastro;
GRANT UNLIMITED TABLESPACE TO portal_cadastro;
GRANT CREATE SEQUENCE TO portal_cadastro;

GRANT EXECUTE ON dbasgu.FNC_MV2000_HMVPEP TO portal_cadastro;
GRANT SELECT ON dbasgu.USUARIOS TO portal_cadastro;
GRANT SELECT ON DBASGU.PAPEL_USUARIOS TO portal_cadastro;
GRANT SELECT ON DBASGU.PAPEL TO portal_cadastro;

--SEQUENCES
GRANT SELECT ON dbamv.SEQ_PRODUTO TO portal_cadastro;
GRANT SELECT ON dbamv.SEQ_UNI_PRO TO portal_cadastro;
GRANT SELECT ON dbamv.SEQ_IMP_BRA TO portal_cadastro;
GRANT SELECT ON dbamv.SEQ_MAT_PROC TO portal_cadastro;
GRANT SELECT ON dbamv.SEQ_TUSS TO portal_cadastro;
GRANT SELECT ON dbamv.SEQ_TIP_PRESC TO portal_cadastro;
GRANT SELECT ON dbamv.SEQ_COMPON TO portal_cadastro;
GRANT SELECT ON dbamv.SEQ_CONTROLE_DOSE TO portal_cadastro;

--SELECT + INSERT
GRANT SELECT, INSERT ON dbamv.PRO_FAT TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.PRODUTO TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.EMPRESA_PRODUTO TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.UNI_PRO TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.PRODUTO_ESTABILIDADE TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.LAB_PRO TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.IMP_BRA TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.MAT_PROC TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.TUSS TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.TIP_PRESC TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.COMPON TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.FOR_APL TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.TIP_PRESC_FOR_APL TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.PW_CONTROLE_DOSE TO portal_cadastro;
GRANT SELECT, INSERT ON dbamv.TIP_PRESC_TIP_FRE TO portal_cadastro;

--UPDATE
GRANT UPDATE ON dbamv.TUSS TO portal_cadastro;
GRANT UPDATE ON dbamv.TIP_PRESC_TIP_FRE TO portal_cadastro;

--DELETAR APENAS PARA TESTE

/*
GRANT DELETE ON dbamv.PRODUTO TO portal_cadastro;
GRANT DELETE ON dbamv.PRO_FAT TO portal_cadastro;
GRANT DELETE ON dbamv.EMPRESA_PRODUTO TO portal_cadastro;
GRANT DELETE ON dbamv.UNI_PRO TO portal_cadastro;
GRANT DELETE ON dbamv.PRODUTO_ESTABILIDADE TO portal_cadastro;
*/

--SELECT
GRANT SELECT ON dbamv.ESPECIE TO portal_cadastro;
GRANT SELECT ON dbamv.CLASSE TO portal_cadastro;
GRANT SELECT ON dbamv.SUB_CLAS TO portal_cadastro;
GRANT SELECT ON dbamv.UNIDADE TO portal_cadastro;
GRANT SELECT ON dbamv.ITUNIDADE TO portal_cadastro;
GRANT SELECT ON dbamv.TIP_ATIV TO portal_cadastro;
GRANT SELECT ON dbamv.TAB_FAT TO portal_cadastro;
GRANT SELECT ON dbamv.B_LABORA TO portal_cadastro;
GRANT SELECT ON dbamv.B_MEDICAME TO portal_cadastro;
GRANT SELECT ON dbamv.B_APRES TO portal_cadastro;
GRANT SELECT ON dbamv.TIP_TUSS TO portal_cadastro;
GRANT SELECT ON dbamv.TIP_ESQ TO portal_cadastro;
GRANT SELECT ON dbamv.TIP_FRE TO portal_cadastro;
