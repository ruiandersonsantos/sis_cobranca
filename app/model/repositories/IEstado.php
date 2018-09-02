<?php
/**
 * IEstado Active Record
 * @author  <your-name-here>
 */
class IEstado extends TRecord
{
    use UtilImportDataTrait;
     
    const TABLENAME = 'i_estado';
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
        parent::addAttribute('descricao');
        parent::addAttribute('sigla');
        parent::addAttribute('chave_origem_pais');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
        parent::addAttribute('importado');
    }
    
    
     public static function getEstadoByTitulosAbertos()
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
        	
        	$sqlstring = 'SELECT A23.UKEY CHAVE_PRIMARIA_ORIGEM, A23_001_C ESTADO, A23_002_C SIGLA, A22_UKEY CHAVE_PAIS FROM A23(NOLOCK)';
                          
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
     
     
     public static function setEstadoImportedInRepository($objects)
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
                  
                    
                    $obj = new IEstado();
                    
                    $objRetorno = $obj->getImportedByOrigem($object->CHAVE_PRIMARIA_ORIGEM,'IEstado');
                    
                    if(isset($objRetorno->id))
                    {
                        $obj = $objRetorno;
                    }
                                   
                    
                    $obj->chave_origem = $object->CHAVE_PRIMARIA_ORIGEM ;
                    $obj->descricao = $object->ESTADO ;
                    $obj->sigla = $object->SIGLA ;
                    $obj->chave_origem_pais = $object->CHAVE_PAIS ;
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
