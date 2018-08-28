begin; 

PRAGMA foreign_keys=OFF; 

CREATE TABLE fabricante( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (200)   , 
      codigo varchar  (200)   , 
      cnpj varchar  (200)   , 
 PRIMARY KEY (id)); 

 CREATE TABLE periodo( 
      id  INTEGER    NOT NULL  , 
      codigo varchar  (200)   , 
      data_iniciio date   , 
      data_fim date   , 
 PRIMARY KEY (id)); 

 CREATE TABLE reconfile( 
      id  INTEGER    NOT NULL  , 
      codigo varchar  (200)   , 
      descricao varchar  (200)   , 
      fabricante_id int   NOT NULL  , 
      periodo_id int   NOT NULL  , 
      tipo_reconfile_id int   NOT NULL  , 
      nome_arquivo varchar  (200)   , 
      data_arquivo date   , 
 PRIMARY KEY (id),
FOREIGN KEY(tipo_reconfile_id) REFERENCES tipo_reconfile(id),
FOREIGN KEY(periodo_id) REFERENCES periodo(id),
FOREIGN KEY(fabricante_id) REFERENCES fabricante(id)); 

 CREATE TABLE tipo_reconfile( 
      id  INTEGER    NOT NULL  , 
      codigo varchar  (200)   , 
      descricao varchar  (200)   , 
 PRIMARY KEY (id)); 

  
 commit;