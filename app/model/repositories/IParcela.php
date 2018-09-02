<?php
/**
 * IParcela Active Record
 * @author  <your-name-here>
 */
class IParcela extends TRecord
{
    use UtilImportDataTrait;
    
    const TABLENAME = 'i_parcela';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    private static $database = 'bd_cobranca';
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('chave_origem');
        parent::addAttribute('numero_parcela');
        parent::addAttribute('data_vencimento');
        parent::addAttribute('valor_liquido');
        parent::addAttribute('valor_bruto');
        parent::addAttribute('valor_estorno');
        parent::addAttribute('valor_reparcelamento');
        parent::addAttribute('valor_quitado');
        parent::addAttribute('data_prorrogacao');
        parent::addAttribute('valor_aberto');
        parent::addAttribute('chave_banco');
        parent::addAttribute('chave_agencia');
        parent::addAttribute('chave_conta');
        parent::addAttribute('chave_primaria_titulo');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
    }

 
     public static function getParcelaByTitulosAbertos()
     {
         
        $objects = new stdClass;
        
        $ObjLog = new LogImportacao();
        $ObjLog->nome_classe = get_class();
        $ObjLog->nome_metodo = __FUNCTION__ ;
        $ObjLog->inicio = date('Y-m-d H:i:s');
        
        try
        {
            TTransaction::open('STARWESTCON');
           
        	$conn = TTransaction::get();
        	
        	$sqlstring = " SELECT 
                        	 F13.UKEY CHAVE_PRIMARIA_ORIGEM
                        	,F13_001_C NUMERO_PARCELA
                        	,CAST(F13_003_D AS DATE) DATA_VENCIMENTO
                        	,CAST(F13_009_B AS MONEY) VALOR_LIQUIDO
                        	,CAST(F13_010_B AS MONEY) VALOR_BRUTO
                        	,CAST(F13_029_B AS MONEY) VALOR_ESTORNO
                        	,CAST(F13_025_B AS MONEY) VALOR_REPARCELAMENTO
                        	,CAST(F13_021_B AS MONEY) VALOR_QUITADO
                        	,CAST(ISNULL(F13_997_D, '19990101') AS DATE) DATA_PRORROGACAO
                        	,CAST((F13_009_B - F13_021_B - F13_029_B - F13_025_B) AS MONEY) VALOR_ABERTO
                        	,ISNULL(F13.A01_UKEY, 'NAO_INFORMADO') CHAVE_BANCO
                        	,ISNULL(F13.A38_UKEY, 'NAO_INFORMADO') CHAVE_AGENCIA
                        	,ISNULL(F13.A39_UKEY, 'NAO_INFORMADO') CHAVE_CONTA_BANCARIA
                        	,F12.UKEY CHAVE_PRIMARIA_TITULO
                        FROM F13(NOLOCK)
                        INNER JOIN f12(NOLOCK) ON f12.ukey = f13.F12_UKEY
                        WHERE (F13_009_B - F13_021_B - F13_029_B - F13_025_B) > 0.10 -- PARCELA EM ABERTO
                        	AND F13_003_D < GETDATE() -- VENCIMENTO MENOR QUE HOJE
                        	AND F12_016_C = '001'
                        	AND ISNULL(F13_997_D, '19990101') < GETDATE() -- PRORROGAÇÃO MENOR QUE HOJE ";
                          
        	$result = $conn->query($sqlstring);
        	
        	$objects = $result->fetchAll(PDO::FETCH_CLASS, "stdClass");
            	
            
            TTransaction::close();
            
            $ObjLog->quantidade_registro = count($objects);
            $ObjLog->fim = date('Y-m-d H:i:s');
            $ObjLog->ocorrencia = 'SUCESSO';
        }
        catch(Exception $e)
        {
            TTransaction::rollback();
            
            $ObjLog->fim = date('Y-m-d H:i:s');
            $ObjLog->ocorrencia = 'ERROR '. $e->getMessage();
            self::setLogImported($ObjLog);
            
            throw new Exception("Problemas carregando dados do ERP! ".$e->getMessage());
           
        }
        
        self::setLogImported($ObjLog);
        return $objects;
     
     }
     
     
     public static function setParcelaImportedInRepository($objects)
     {
        $ObjLog = new LogImportacao();
        $ObjLog->nome_classe = get_class();
        $ObjLog->nome_metodo = __FUNCTION__ ;
        $ObjLog->inicio = date('Y-m-d H:i:s');
        
        try
    	{    
    	    
           if($objects)
        	{    
        	     TTransaction::open(self::$database);
        	   
        	     foreach($objects as $object) 
                 { 
                  
                    
                    $obj = new IParcela();
                    
                    $objRetorno = $obj->getImportedByOrigem($object->CHAVE_PRIMARIA_ORIGEM,'IParcela');
                    
                    if(isset($objRetorno->id))
                    {
                        $obj = $objRetorno;
                    }
                                   
                    
                    $obj->chave_origem = $object->CHAVE_PRIMARIA_ORIGEM ;
                    $obj->numero_parcela = $object->NUMERO_PARCELA ;
                    $obj->data_vencimento = $object->DATA_VENCIMENTO ;
                    $obj->valor_liquido = $object->VALOR_LIQUIDO ;
                    $obj->valor_bruto = $object->VALOR_BRUTO ;
                    $obj->valor_estorno = $object->VALOR_ESTORNO ;
                    $obj->valor_reparcelamento = $object->VALOR_REPARCELAMENTO ;
                    $obj->valor_quitado = $object->VALOR_QUITADO ;
                    $obj->data_prorrogacao = $object->DATA_PRORROGACAO ;
                    $obj->valor_aberto = $object->VALOR_ABERTO ;
                    $obj->chave_banco = $object->CHAVE_BANCO ;
                    $obj->chave_agencia = $object->CHAVE_AGENCIA ;
                    $obj->chave_conta = $object->CHAVE_CONTA_BANCARIA ;
                    $obj->chave_primaria_titulo = $object->CHAVE_PRIMARIA_TITULO ;
                                       
                    $obj->ultima_atualizacao = date('Y-m-d H:i:s');
                    $obj->qt_atualizacoes = $obj->qt_atualizacoes + 1;
                    
                   
                    
                    // Só atualiza se ainda não tiver sido carregado
                    if($obj->importado == 0)
                    {
                       $obj->store();
                    }
                    
                                       
                 }
                 
                 TTransaction::close(); // close the transaction   
        		
        		 $ObjLog->quantidade_registro = count($objects);
                 $ObjLog->fim = date('Y-m-d H:i:s');
                 $ObjLog->ocorrencia = 'SUCESSO';
        	}     
                
            
    		
    	}
    	catch(Exception $e)
        {
            TTransaction::rollback();
            
            $ObjLog->fim = date('Y-m-d H:i:s');
            $ObjLog->ocorrencia = 'ERROR '. $e->getMessage();
            self::setLogImported($ObjLog);
            
            throw new Exception("Problemas na gravação de dados no repositorio! ".$e->getMessage());
        
        }
        
        self::setLogImported($ObjLog);
     
     }


}
