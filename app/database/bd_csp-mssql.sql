begin; 

CREATE TABLE fabricante( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (200)   , 
      codigo varchar  (200)   , 
      cnpj varchar  (200)   , 
 PRIMARY KEY (id)); 

 CREATE TABLE periodo( 
      id  INT IDENTITY    NOT NULL  , 
      codigo varchar  (200)   , 
      data_iniciio date   , 
      data_fim date   , 
 PRIMARY KEY (id)); 

 CREATE TABLE reconfile( 
      id  INT IDENTITY    NOT NULL  , 
      codigo varchar  (200)   , 
      descricao varchar  (200)   , 
      fabricante_id int   NOT NULL  , 
      periodo_id int   NOT NULL  , 
      tipo_reconfile_id int   NOT NULL  , 
      nome_arquivo varchar  (200)   , 
      data_arquivo date   , 
 PRIMARY KEY (id)); 

 CREATE TABLE tipo_reconfile( 
      id  INT IDENTITY    NOT NULL  , 
      codigo varchar  (200)   , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)); 

  
 ALTER TABLE reconfile ADD CONSTRAINT fk_reconfile_3 FOREIGN KEY (tipo_reconfile_id) references tipo_reconfile(id); 
ALTER TABLE reconfile ADD CONSTRAINT fk_reconfile_2 FOREIGN KEY (periodo_id) references periodo(id); 
ALTER TABLE reconfile ADD CONSTRAINT fk_reconfile_1 FOREIGN KEY (fabricante_id) references fabricante(id); 
 
 commit;