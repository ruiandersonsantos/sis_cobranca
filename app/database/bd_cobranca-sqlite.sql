begin; 

PRAGMA foreign_keys=OFF; 

CREATE TABLE agencia( 
      id  INTEGER    NOT NULL  , 
      chave_origem varchar  (45)   , 
      codigo varchar  (200)   , 
      nome_agencia varchar  (45)   , 
      chave_primaria_banco varchar  (200)   , 
      chave_primaria_cidade varchar  (200)   , 
      data_hora_criacao datetime   , 
      ultima_atualizacao datetime   , 
      qt_atualizacoes int  (11)   , 
      banco_id int  (11)   NOT NULL  , 
      cidade_id int  (11)   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(cidade_id) REFERENCES cidade(id),
FOREIGN KEY(banco_id) REFERENCES banco(id)); 

 CREATE TABLE banco( 
      id  INTEGER    NOT NULL  , 
      chave_origem varchar  (45)   , 
      codigo varchar  (200)   , 
      nome_banco varchar  (45)   , 
      nome_banco_completo varchar  (200)   , 
      data_hora_criacao datetime   , 
      ultima_atualizacao datetime   , 
      qt_atualizacoes int  (11)   , 
 PRIMARY KEY (id)); 

 CREATE TABLE cidade( 
      id  INTEGER    NOT NULL  , 
      chave_origem varchar  (45)   , 
      descricao varchar  (200)   , 
      chave_estado varchar  (45)   , 
      data_hora_criacao datetime   , 
      ultima_atualizacao datetime   , 
      qt_atualizacoes int  (11)   , 
      estado_id int  (11)   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(estado_id) REFERENCES estado(id)); 

 CREATE TABLE conta( 
      id  INTEGER    NOT NULL  , 
      chave_origem varchar  (45)   , 
      numero_conta varchar  (200)   , 
      chave_primaria_agencia varchar  (200)   , 
      data_hora_criacao datetime   , 
      ultima_atualizacao datetime   , 
      qt_atualizacoes int  (11)   , 
      agencia_id int  (11)   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(agencia_id) REFERENCES agencia(id)); 

 CREATE TABLE estado( 
      id  INTEGER    NOT NULL  , 
      chave_origem varchar  (45)   , 
      descricao varchar  (200)   , 
      sigla varchar  (45)   , 
      chave_origem_pais varchar  (45)   , 
      data_hora_criacao datetime   , 
      ultima_atualizacao datetime   , 
      qt_atualizacoes int  (11)   , 
      pais_id int  (11)   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(pais_id) REFERENCES pais(id)); 

 CREATE TABLE pais( 
      id  INTEGER    NOT NULL  , 
      chave_origem varchar  (45)   , 
      descricao varchar  (45)   NOT NULL  , 
      data_hora_criacao datetime   , 
      ultima_atualizacao datetime   , 
      qt_atualizacoes int  (11)   , 
 PRIMARY KEY (id)); 

  
 commit;