--EXCLUIR VINCULOS FKs
--ALTER TABLE portal_cadastro.REGRA DROP CONSTRAINT fk_cd_tipo_regra;

---------
--SETOR--
---------
DROP TABLE escala_medica.ESCALA;
DROP TABLE escala_medica.SETOR;
DROP TABLE escala_medica.DIVISAO_HORA;

DROP SEQUENCE escala_medica.SEQ_CD_SETOR; 
CREATE SEQUENCE escala_medica.SEQ_CD_SETOR 
START WITH 1    
INCREMENT BY 1
NOCACHE
NOCYCLE;

create table DIVISAO_HORA
(
  tp_hora VARCHAR2(1) not null,
  ds_hora VARCHAR2(5) not null
);
--executar a pagina alimentar_tabela_horas.php localizado



CREATE TABLE escala_medica.SETOR(

CD_SETOR            INT NOT NULL,
CD_ESPECIALID       INTEGER,
TP_SETOR            VARCHAR(1) NOT NULL,
DS_SETOR            VARCHAR(50) NOT NULL,
CD_PRESTADOR_MV     INT NOT NULL,
CD_USUARIO_CADASTRO VARCHAR(20) NOT NULL,
HR_CADASTRO         TIMESTAMP NOT NULL,
CD_USUARIO_ULT_ALT  VARCHAR(20),
HR_ULT_ALT          TIMESTAMP,

--PRIMARY KEY
CONSTRAINT pk_cd_setor PRIMARY KEY (CD_SETOR),

--TRAVA DE CARACTER TP SETOR (D OU P)
CONSTRAINT check_tp_setor CHECK (TP_SETOR IN ('D', 'P')),

CONSTRAINT FK_CD_ESPECIALID FOREIGN KEY (CD_ESPECIALID)
REFERENCES DBAMV.ESPECIALID (CD_ESPECIALID)

--KEY (CHAVE ESTRANGEIRA) CONEXAO COM dbamv.PRESTADOR
--CONSTRAINT fk_cd_prestador_mv FOREIGN KEY (CD_PRESTADOR_MV) REFERENCES dbamv.PRESTADOR(CD_PRESTADOR)

);

CREATE TABLE ESCALA
(
  CD_ESCALA           INTEGER not null,
  PERIODO             VARCHAR2(7) not null,
  CD_SETOR            INTEGER not null,
  CD_PRESTADOR_MV     INTEGER not null,
  DIA                 INTEGER,
  DIARISTA            VARCHAR2(1),
  HR_INICIAL          VARCHAR2(5),
  HR_FINAL            VARCHAR2(5),
  CD_USUARIO_CADASTRO VARCHAR2(20) not null,
  HR_CADASTRO         TIMESTAMP(6) not null,
  CD_USUARIO_ULT_ALT  VARCHAR2(20),
  HR_ULT_ALT          TIMESTAMP(6),

  CONSTRAINT PK_CD_ESCALA PRIMARY KEY (CD_ESCALA),
  CONSTRAINT FK_CD_PRESTADOR_MV FOREIGN KEY (CD_PRESTADOR_MV)
  REFERENCES DBAMV.PRESTADOR (CD_PRESTADOR),
  CONSTRAINT FK_CD_SETOR FOREIGN KEY (CD_SETOR)
  REFERENCES SETOR (CD_SETOR)


);

COMMENT ON COLUMN escala_medica.SETOR.CD_SETOR IS 'SEQ_CD_SETOR';
COMMENT ON COLUMN escala_medica.SETOR.TP_SETOR IS 'D - Distancia | P - Presencial';

