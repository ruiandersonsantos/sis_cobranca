begin; 

CREATE TABLE fabricante( 
      id  SERIAL    NOT NULL  , 
      nome varchar  (200)   , 
      codigo varchar  (200)   , 
      cnpj varchar  (200)   , 
 PRIMARY KEY (id)); 

 CREATE TABLE periodo( 
      id  SERIAL    NOT NULL  , 
      codigo varchar  (200)   , 
      data_iniciio date   , 
      data_fim date   , 
 PRIMARY KEY (id)); 

 CREATE TABLE reconfile( 
      id  SERIAL    NOT NULL  , 
      codigo varchar  (200)   , 
      descricao varchar  (200)   , 
      fabricante_id integer   NOT NULL  , 
      periodo_id integer   NOT NULL  , 
      tipo_reconfile_id integer   NOT NULL  , 
      nome_arquivo varchar  (200)   , 
      data_arquivo date   , 
 PRIMARY KEY (id)); 

 CREATE TABLE tipo_reconfile( 
      id  SERIAL    NOT NULL  , 
      codigo varchar  (200)   , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)); 

  
 ALTER TABLE reconfile ADD CONSTRAINT fk_reconfile_3 FOREIGN KEY (tipo_reconfile_id) references tipo_reconfile(id); 
ALTER TABLE reconfile ADD CONSTRAINT fk_reconfile_2 FOREIGN KEY (periodo_id) references periodo(id); 
ALTER TABLE reconfile ADD CONSTRAINT fk_reconfile_1 FOREIGN KEY (fabricante_id) references fabricante(id); 
 
 commit;