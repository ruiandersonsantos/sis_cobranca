<?php
class LoadService{

    public static function loadDados()
    {    
    
        // Carregando coleções
        $ipaise      = IPais::getObjetcNoImported();
        $iestados    = IEstado::getObjetcNoImported();
        $icidades    = ICidade::getObjetcNoImported();
        $ibancos     = IBanco::getObjetcNoImported();
        $iagencias   = IAgencia::getObjetcNoImported();
        $icontas     = IConta::getObjetcNoImported();
        $iclientes     = ICliente::getObjetcNoImported();
        
        // Carregando paises --------------------------------------------------------------
        if($ipaise)
        {
            TTransaction::open('bd_cobranca');
            
            foreach($ipaise as $ipais)
            { 
                $pais = new Pais();
                $pais->chave_origem = $ipais->chave_origem;
                $pais->descricao = $ipais->descricao;
                $pais->ultima_atualizacao = date('Y-m-d H:i:s');
                $pais->qt_atualizacoes = $ipais->qt_atualizacoes;
                
                $ipais->importado = 1;
            
                try
                {
                   $pais->store();
                   $ipais->store();                
                    
                }
                catch (Exception $e) // in case of exception
                {
                    new TMessage('error', $e->getMessage()); // shows the exception error message
                    TTransaction::rollback(); // undo all pending operations
                }
        
            }
            
            TTransaction::close();        
        
        }
        // Carregando paises --------------------------------------------------------------
        
        // Carregando estados --------------------------------------------------------------
        if($iestados)
        {
            TTransaction::open('bd_cobranca');
            
            foreach($iestados as $iestado)
            {
                $estado = new Estado();
                
                $pais = Pais::getObjetcChild($iestado->chave_origem_pais);
                
                $estado->chave_origem = $iestado->chave_origem;
                $estado->descricao = $iestado->descricao;
                $estado->sigla = $iestado->sigla;
                $estado->chave_origem_pais = $pais->chave_origem;
                $estado->ultima_atualizacao = date('Y-m-d H:i:s');
                $estado->qt_atualizacoes = $iestado->qt_atualizacoes;
                $estado->pais_id = $pais->id;
                
                $iestado->importado = 1;
                
                try
                {
                   $estado->store();
                   $iestado->store();                
                    
                }
                catch (Exception $e) // in case of exception
                {
                    new TMessage('error', $e->getMessage()); // shows the exception error message
                    TTransaction::rollback(); // undo all pending operations
                }
        
            }
            
            TTransaction::close();        
        
        }
        // Carregando estados --------------------------------------------------------------
        
        // Carregando cidades --------------------------------------------------------------
        if($icidades)
        {
            TTransaction::open('bd_cobranca');
            
            foreach($icidades as $icidade)
            {
                $cidade = new Cidade();
                
                $estado = Estado::getObjetcChild($icidade->chave_estado);
                
                $cidade->chave_origem = $icidade->chave_origem;
                $cidade->descricao = $icidade->descricao;
                $cidade->chave_estado = $estado->chave_origem;
                $cidade->ultima_atualizacao = date('Y-m-d H:i:s');
                $cidade->qt_atualizacoes = $icidade->qt_atualizacoes;
                $cidade->estado_id = $estado->id;
                
                $icidade->importado = 1;
        
                try
                {
                   $cidade->store();
                   $icidade->store();                
                    
                }
                catch (Exception $e) // in case of exception
                {
                    new TMessage('error', $e->getMessage()); // shows the exception error message
                    TTransaction::rollback(); // undo all pending operations
                }
            
            
            }
            
            TTransaction::close();        
        
        }
        // Carregando cidades --------------------------------------------------------------
        
           
       // Carregando bancos --------------------------------------------------------------
        if($ibancos)
        {    
            // gravando bancos
            TTransaction::open('bd_cobranca');
            
            foreach($ibancos as $ibanco)
            { 
                $banco = new Banco();
                $banco->chave_origem = $ibanco->chave_origem;
                $banco->codigo = $ibanco->codigo;
                $banco->nome_banco = $ibanco->nome_banco;
                $banco->nome_banco_completo = $ibanco->nome_banco_completo;
                $banco->ultima_atualizacao = date('Y-m-d H:i:s');
                $banco->qt_atualizacoes = $ibanco->qt_atualizacoes;
                
                $ibanco->importado = 1;
            
                try
                {
                   $banco->store();
                   $ibanco->store();                
                    
                }
                catch (Exception $e) // in case of exception
                {
                    new TMessage('error', $e->getMessage()); // shows the exception error message
                    TTransaction::rollback(); // undo all pending operations
                }
                
               
            }
            
            TTransaction::close();
        }
        // Carregando bancos --------------------------------------------------------------
        
        // Carregando agencias --------------------------------------------------------------
        if($iagencias)
        {    
            // gravando bancos
            TTransaction::open('bd_cobranca');
            
            foreach($iagencias as $iagencia)
            { 
                $agencia = new Agencia();
                
                $cidade = Cidade::getObjetcChild($iagencia->chave_primaria_cidade);
                $banco = Banco::getObjetcChild($iagencia->chave_primaria_banco);
                
               // var_dump($iagencia->chave_primaria_cidade);
                //var_dump($banco);
                
                $agencia->chave_origem = $iagencia->chave_origem;
                $agencia->codigo = $iagencia->codigo;
                $agencia->nome_agencia = $iagencia->nome_agencia;
                $agencia->chave_primaria_banco = $iagencia->chave_primaria_banco;
                $agencia->chave_primaria_cidade = $iagencia->chave_primaria_cidade;
                $agencia->codigo = $iagencia->codigo;
                $agencia->ultima_atualizacao = date('Y-m-d H:i:s');
                $agencia->qt_atualizacoes = $iagencia->qt_atualizacoes;
                $agencia->banco_id = $banco->id;
                
                if($cidade)
                {
                    $agencia->cidade_id = $cidade->id;
                }
                
                
                $iagencia->importado = 1;
            
                try
                {
                   $agencia->store();
                   $iagencia->store();                
                    
                }
                catch (Exception $e) // in case of exception
                {
                    new TMessage('error', $e->getMessage()); // shows the exception error message
                    TTransaction::rollback(); // undo all pending operations
                }
                
               
            }
            
            TTransaction::close();
        }
        // Carregando Agencias --------------------------------------------------------------
        
        // Carregando Contas --------------------------------------------------------------
        if($icontas)
        {    
            // gravando bancos
            TTransaction::open('bd_cobranca');
            
            foreach($icontas as $iconta)
            { 
                $conta = new Conta();
                
                $agencia = Agencia::getObjetcChild($iconta->chave_primaria_agencia);
              
                
               // var_dump($iagencia->chave_primaria_cidade);
                //var_dump($banco);
                
                $conta->chave_origem           = $iconta->chave_origem;
                $conta->numero_conta           = $iconta->numero_conta;
                $conta->chave_primaria_agencia = $iconta->chave_primaria_agencia;
                $conta->ultima_atualizacao     = date('Y-m-d H:i:s');
                $conta->agencia_id             = $agencia->id;
            
                
                $iconta->importado = 1;
            
                try
                {
                   $conta->store();
                   $iconta->store();                
                    
                }
                catch (Exception $e) // in case of exception
                {
                    new TMessage('error', $e->getMessage()); // shows the exception error message
                    TTransaction::rollback(); // undo all pending operations
                }
                
               
            }
            
            TTransaction::close();
        }
        // Carregando contas --------------------------------------------------------------
        
        // Carregando clientes --------------------------------------------------------------
        if($iclientes)
        {
            TTransaction::open('bd_cobranca');
            
            foreach($iclientes as $icliente)
            { 
                $cliente = new Cliente();
                $cliente->chave_origem = $icliente->chave_origem;
                $cliente->codigo = $icliente->codigo;
                $cliente->razao = $icliente->razao;
                $cliente->nome_fantasia = $icliente->nome_fantasia;
                $cliente->documento = $icliente->documento;
                $cliente->ultima_atualizacao = date('Y-m-d H:i:s');
                $cliente->qt_atualizacoes = $icliente->qt_atualizacoes;
                
                
                
                $icliente->importado = 1;
            
                try
                {
                   $cliente->store();
                   
                   
                   $cidade = ICliente::getObjetcChildByChave('chave_municipio',$icliente->chave_municipio);
                   
                   $endereco = new Endereco();
                   
                   $endereco->set_cliente($cliente);
                   $endereco->set_cidade($cidade);
                   
                   
                                   
                   $icliente->store();  
                }
                catch (Exception $e) // in case of exception
                {
                    new TMessage('error', $e->getMessage()); // shows the exception error message
                    TTransaction::rollback(); // undo all pending operations
                }
        
            }
            
            TTransaction::close();        
        
        }
        // Carregando paises --------------------------------------------------------------
    }
} 
