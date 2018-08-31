begin; 

CREATE TABLE agencia( 
      id number(10)    NOT NULL , 
      chave_origem varchar  (45)   , 
      codigo varchar  (200)   , 
      nome_agencia varchar  (45)   , 
      chave_primaria_banco varchar  (200)   , 
      chave_primaria_cidade varchar  (200)   , 
      data_hora_criacao timestamp(0)   , 
      ultima_atualizacao timestamp(0)   , 
      qt_atualizacoes number(10)  (11)   , 
      banco_id number(10)  (11)    NOT NULL , 
      cidade_id number(10)  (11)    NOT NULL , 
 PRIMARY KEY (id)); 

 CREATE TABLE banco( 
      id number(10)    NOT NULL , 
      chave_origem varchar  (45)   , 
      codigo varchar  (200)   , 
      nome_banco varchar  (45)   , 
      nome_banco_completo varchar  (200)   , 
      data_hora_criacao timestamp(0)   , 
      ultima_atualizacao timestamp(0)   , 
      qt_atualizacoes number(10)  (11)   , 
 PRIMARY KEY (id)); 

 CREATE TABLE cidade( 
      id number(10)    NOT NULL , 
      chave_origem varchar  (45)   , 
      descricao varchar  (200)   , 
      chave_estado varchar  (45)   , 
      data_hora_criacao timestamp(0)   , 
      ultima_atualizacao timestamp(0)   , 
      qt_atualizacoes number(10)  (11)   , 
      estado_id number(10)  (11)    NOT NULL , 
 PRIMARY KEY (id)); 

 CREATE TABLE conta( 
      id number(10)    NOT NULL , 
      chave_origem varchar  (45)   , 
      numero_conta varchar  (200)   , 
      chave_primaria_agencia varchar  (200)   , 
      data_hora_criacao timestamp(0)   , 
      ultima_atualizacao timestamp(0)   , 
      qt_atualizacoes number(10)  (11)   , 
      agencia_id number(10)  (11)    NOT NULL , 
 PRIMARY KEY (id)); 

 CREATE TABLE estado( 
      id number(10)    NOT NULL , 
      chave_origem varchar  (45)   , 
      descricao varchar  (200)   , 
      sigla varchar  (45)   , 
      chave_origem_pais varchar  (45)   , 
      data_hora_criacao timestamp(0)   , 
      ultima_atualizacao timestamp(0)   , 
      qt_atualizacoes number(10)  (11)   , 
      pais_id number(10)  (11)    NOT NULL , 
 PRIMARY KEY (id)); 

 CREATE TABLE pais( 
      id number(10)    NOT NULL , 
      chave_origem varchar  (45)   , 
      descricao varchar  (45)    NOT NULL , 
      data_hora_criacao timestamp(0)   , 
      ultima_atualizacao timestamp(0)   , 
      qt_atualizacoes number(10)  (11)   , 
 PRIMARY KEY (id)); 

  
 ALTER TABLE agencia ADD CONSTRAINT fk_agencia_2 FOREIGN KEY (cidade_id) references cidade(id); 
ALTER TABLE agencia ADD CONSTRAINT fk_agencia_1 FOREIGN KEY (banco_id) references banco(id); 
ALTER TABLE cidade ADD CONSTRAINT fk_cidade_1 FOREIGN KEY (estado_id) references estado(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_1 FOREIGN KEY (agencia_id) references agencia(id); 
ALTER TABLE estado ADD CONSTRAINT fk_estado_1 FOREIGN KEY (pais_id) references pais(id); 
 CREATE SEQUENCE agencia_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER agencia_id_seq_tr 

BEFORE INSERT ON agencia FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT agencia_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE banco_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER banco_id_seq_tr 

BEFORE INSERT ON banco FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT banco_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE cidade_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER cidade_id_seq_tr 

BEFORE INSERT ON cidade FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT cidade_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE conta_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER conta_id_seq_tr 

BEFORE INSERT ON conta FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT conta_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE estado_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER estado_id_seq_tr 

BEFORE INSERT ON estado FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT estado_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE pais_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER pais_id_seq_tr 

BEFORE INSERT ON pais FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT pais_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
  
 commit;