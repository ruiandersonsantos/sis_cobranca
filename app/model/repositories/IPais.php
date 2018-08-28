<?php
/**
 * IPais Active Record
 * @author  <your-name-here>
 */
class IPais extends TRecord
{
    use UtilImportDataTrait;
     
    const TABLENAME = 'i_pais';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
   private static $database = 'bd_cobranca';
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('chave_origem');
        parent::addAttribute('descricao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
        parent::addAttribute('importado');
    }
    
    

 public static function getPaisByTitulosAbertos()
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
    	
    	$sqlstring = 'SELECT A22.UKEY CHAVE_PRIMARIA_ORIGEM
                            ,A22_001_C PAIS
                      FROM A22(NOLOCK)';
                      
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
 
 
 public static function setPaisImportedInRepository($objects)
 {
    $ObjLog = new LogImportacao();
    $ObjLog->nome_classe = get_class();
    $ObjLog->nome_metodo = __FUNCTION__ ;
    $ObjLog->inicio = date('Y-m-d H:i:s');
    
    try
	{    
	    if($objects)
    	{   
    	     foreach($objects as $object) 
             { 
              
                
                $objPais = new IPais();
                
                $objRetorno = $objPais->getImportedByOrigem($object->CHAVE_PRIMARIA_ORIGEM,'IPais');
                
                if(isset($objRetorno->id))
                {
                    $objPais = $objRetorno;
                }
                               
                
                $objPais->chave_origem = $object->CHAVE_PRIMARIA_ORIGEM ;
                $objPais->descricao = $object->PAIS ;
                $objPais->ultima_atualizacao = date('Y-m-d H:i:s');
                $objPais->qt_atualizacoes = $objPais->qt_atualizacoes + 1;
                
                TTransaction::open(self::$database);
                
                $objPais->store();
                
                TTransaction::close();
                $ObjLog->quantidade_registro = count($objects);
                $ObjLog->fim = date('Y-m-d H:i:s');
                $ObjLog->ocorrencia = 'SUCESSO';
                
                
             }   
    		
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
