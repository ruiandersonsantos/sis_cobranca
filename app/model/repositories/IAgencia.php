<?php
/**
 * IAgencia Active Record
 * @author  <your-name-here>
 */
class IAgencia extends TRecord
{
    use UtilImportDataTrait;
    
    private static $database = 'bd_cobranca';
    
    const TABLENAME = 'i_agencia';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('chave_origem');
        parent::addAttribute('codigo');
        parent::addAttribute('nome_agencia');
        parent::addAttribute('chave_primaria_banco');
        parent::addAttribute('chave_primaria_cidade');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
        parent::addAttribute('importado');
    }
    
    
     public static function getAgenciaByTitulosAbertos()
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
                            	A38.UKEY CHAVE_PRIMARIA_ORIGEM,
                            	A38_001_C CODIGO_AGENCIA,
                            	A38_003_C NOME_AGENCIA,
                            	A38.A01_UKEY CHAVE_PRIMARIA_BANCO,
                            	A38.A24_UKEY CHAVE_PRIMARIA_CIDADE
                            FROM F13(NOLOCK)
                            INNER JOIN f12(NOLOCK) ON f12.ukey = f13.F12_UKEY
                            INNER JOIN A38(NOLOCK) ON A38.UKEY = F13.A38_UKEY
                            WHERE (F13_009_B - F13_021_B - F13_029_B - F13_025_B) > 0.10 -- PARCELA EM ABERTO
                            	AND F13_003_D < GETDATE() -- VENCIMENTO MENOR QUE HOJE
                            	AND F12_016_C = '001'
                            	AND ISNULL(F13_997_D, '19990101') < GETDATE() -- PRORROGAÇÃO MENOR QUE HOJE
                            GROUP BY
                            	A38.UKEY,
                            	A38_001_C,
                            	A38_003_C,
                            	A38.A01_UKEY,
                            	A38.A24_UKEY
                             ";
                          
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
     
     
     public static function setAgenciaImportedInRepository($objects)
     {
        $ObjLog = new LogImportacao();
        $ObjLog->nome_classe = get_class();
        $ObjLog->nome_metodo = __FUNCTION__ ;
        
        try
    	{    
    	    if($objects)
        	{    
        	     TTransaction::open(self::$database);
        	     $ObjLog->inicio = date('Y-m-d H:i:s');
        	
        	     foreach($objects as $object) 
                 { 
                  
                    
                    $obj = new IAgencia();
                    
                    $objRetorno = $obj->getImportedByOrigem($object->CHAVE_PRIMARIA_ORIGEM,'IAgencia');
                    
                    if(isset($objRetorno->id))
                    {
                        $obj = $objRetorno;
                    }
                                   
                    
                    $obj->chave_origem = $object->CHAVE_PRIMARIA_ORIGEM ;
                    $obj->codigo = $object->CODIGO_AGENCIA ;
                    $obj->nome_agencia = $object->NOME_AGENCIA ;
                    $obj->chave_primaria_banco = $object->CHAVE_PRIMARIA_BANCO ;
                    $obj->chave_primaria_cidade = $object->CHAVE_PRIMARIA_CIDADE ;
                    
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
            throw new Exception("Problemas na gravação de dados no repositorio! ".$e->getMessage());
        
        }
        
        self::setLogImported($ObjLog);
     
     }
     


}
