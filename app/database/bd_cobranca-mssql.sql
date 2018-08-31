begin; 

CREATE TABLE agencia( 
      id  INT IDENTITY    NOT NULL  , 
      chave_origem varchar  (45)   , 
      codigo varchar  (200)   , 
      nome_agencia varchar  (45)   , 
      chave_primaria_banco varchar  (200)   , 
      chave_primaria_cidade varchar  (200)   , 
      data_hora_criacao datetime2   , 
      ultima_atualizacao datetime2   , 
      qt_atualizacoes int  (11)   , 
      banco_id int  (11)   NOT NULL  , 
      cidade_id int  (11)   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE banco( 
      id  INT IDENTITY    NOT NULL  , 
      chave_origem varchar  (45)   , 
      codigo varchar  (200)   , 
      nome_banco varchar  (45)   , 
      nome_banco_completo varchar  (200)   , 
      data_hora_criacao datetime2   , 
      ultima_atualizacao datetime2   , 
      qt_atualizacoes int  (11)   , 
 PRIMARY KEY (id)); 

 CREATE TABLE cidade( 
      id  INT IDENTITY    NOT NULL  , 
      chave_origem varchar  (45)   , 
      descricao varchar  (200)   , 
      chave_estado varchar  (45)   , 
      data_hora_criacao datetime2   , 
      ultima_atualizacao datetime2   , 
      qt_atualizacoes int  (11)   , 
      estado_id int  (11)   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE conta( 
      id  INT IDENTITY    NOT NULL  , 
      chave_origem varchar  (45)   , 
      numero_conta varchar  (200)   , 
      chave_primaria_agencia varchar  (200)   , 
      data_hora_criacao datetime2   , 
      ultima_atualizacao datetime2   , 
      qt_atualizacoes int  (11)   , 
      agencia_id int  (11)   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE estado( 
      id  INT IDENTITY    NOT NULL  , 
      chave_origem varchar  (45)   , 
      descricao varchar  (200)   , 
      sigla varchar  (45)   , 
      chave_origem_pais varchar  (45)   , 
      data_hora_criacao datetime2   , 
      ultima_atualizacao datetime2   , 
      qt_atualizacoes int  (11)   , 
      pais_id int  (11)   NOT NULL  , 
 PRIMARY KEY (id)); 

 CREATE TABLE pais( 
      id  INT IDENTITY    NOT NULL  , 
      chave_origem varchar  (45)   , 
      descricao varchar  (45)   NOT NULL  , 
      data_hora_criacao datetime2   , 
      ultima_atualizacao datetime2   , 
      qt_atualizacoes int  (11)   , 
 PRIMARY KEY (id)); 

  
 ALTER TABLE agencia ADD CONSTRAINT fk_agencia_2 FOREIGN KEY (cidade_id) references cidade(id); 
ALTER TABLE agencia ADD CONSTRAINT fk_agencia_1 FOREIGN KEY (banco_id) references banco(id); 
ALTER TABLE cidade ADD CONSTRAINT fk_cidade_1 FOREIGN KEY (estado_id) references estado(id); 
ALTER TABLE conta ADD CONSTRAINT fk_conta_1 FOREIGN KEY (agencia_id) references agencia(id); 
ALTER TABLE estado ADD CONSTRAINT fk_estado_1 FOREIGN KEY (pais_id) references pais(id); 
 
 commit;