<?php
/**
 * IConta Active Record
 * @author  <your-name-here>
 */
class IConta extends TRecord
{
    use UtilImportDataTrait;
   
    const TABLENAME = 'i_conta';
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
        parent::addAttribute('numero_conta');
        parent::addAttribute('chave_primaria_agencia');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
    }
    
    
     public static function getContaByTitulosAbertos()
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
                            	A39.UKEY CHAVE_PRIMARIA_ORIGEM,
                            	A39_001_C NUMERO_CONTA,
                            	A39.A38_UKEY CHAVE_PRIMARIA_AGENCIA
                            
                            FROM F13(NOLOCK)
                            INNER JOIN f12(NOLOCK) ON f12.ukey = f13.F12_UKEY
                            INNER JOIN A39(NOLOCK) ON A39.UKEY = F13.A39_UKEY
                            WHERE (F13_009_B - F13_021_B - F13_029_B - F13_025_B) > 0.10 -- PARCELA EM ABERTO
                            	AND F13_003_D < GETDATE() -- VENCIMENTO MENOR QUE HOJE
                            	AND F12_016_C = '001'
                            	AND ISNULL(F13_997_D, '19990101') < GETDATE() -- PRORROGAÇÃO MENOR QUE HOJE
                            GROUP BY
                            	A39.UKEY,
                            	A39_001_C,
                            	A39.A38_UKEY ";
                          
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
     
     
     public static function setContaImportedInRepository($objects)
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
                  
                    
                    $obj = new IConta();
                    
                    $objRetorno = $obj->getImportedByOrigem($object->CHAVE_PRIMARIA_ORIGEM,'IConta');
                    
                    if(isset($objRetorno->id))
                    {
                        $obj = $objRetorno;
                    }
                                   
                    
                    $obj->chave_origem = $object->CHAVE_PRIMARIA_ORIGEM ;
                    $obj->numero_conta = $object->NUMERO_CONTA ;
                    $obj->chave_primaria_agencia = $object->CHAVE_PRIMARIA_AGENCIA ;
                    
                    
                    $obj->ultima_atualizacao = date('Y-m-d H:i:s');
                    $obj->qt_atualizacoes = $obj->qt_atualizacoes + 1;
                    
                   
                    
                   $obj->store();
                                    
                    
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
