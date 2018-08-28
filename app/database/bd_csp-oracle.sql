begin; 

CREATE TABLE fabricante( 
      id number(10)    NOT NULL , 
      nome varchar  (200)   , 
      codigo varchar  (200)   , 
      cnpj varchar  (200)   , 
 PRIMARY KEY (id)); 

 CREATE TABLE periodo( 
      id number(10)    NOT NULL , 
      codigo varchar  (200)   , 
      data_iniciio date   , 
      data_fim date   , 
 PRIMARY KEY (id)); 

 CREATE TABLE reconfile( 
      id number(10)    NOT NULL , 
      codigo varchar  (200)   , 
      descricao varchar  (200)   , 
      fabricante_id number(10)    NOT NULL , 
      periodo_id number(10)    NOT NULL , 
      tipo_reconfile_id number(10)    NOT NULL , 
      nome_arquivo varchar  (200)   , 
      data_arquivo date   , 
 PRIMARY KEY (id)); 

 CREATE TABLE tipo_reconfile( 
      id number(10)    NOT NULL , 
      codigo varchar  (200)   , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)); 

  
 ALTER TABLE reconfile ADD CONSTRAINT fk_reconfile_3 FOREIGN KEY (tipo_reconfile_id) references tipo_reconfile(id); 
ALTER TABLE reconfile ADD CONSTRAINT fk_reconfile_2 FOREIGN KEY (periodo_id) references periodo(id); 
ALTER TABLE reconfile ADD CONSTRAINT fk_reconfile_1 FOREIGN KEY (fabricante_id) references fabricante(id); 
 CREATE SEQUENCE fabricante_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER fabricante_id_seq_tr 

BEFORE INSERT ON fabricante FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT fabricante_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE periodo_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER periodo_id_seq_tr 

BEFORE INSERT ON periodo FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT periodo_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE reconfile_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER reconfile_id_seq_tr 

BEFORE INSERT ON reconfile FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT reconfile_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_reconfile_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_reconfile_id_seq_tr 

BEFORE INSERT ON tipo_reconfile FOR EACH ROW 

WHEN 

(NEW.id IS NULL) 

BEGIN 

SELECT tipo_reconfile_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
  
 commit;