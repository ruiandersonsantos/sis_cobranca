<?php
/**
 * ITitulo Active Record
 * @author  <your-name-here>
 */
class ITitulo extends TRecord
{
    use UtilImportDataTrait;
     
    const TABLENAME = 'i_titulo';
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
        parent::addAttribute('numero');
        parent::addAttribute('serie');
        parent::addAttribute('emissao');
        parent::addAttribute('valor');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
    }
    
    
    
     public static function getTituloByTitulosAbertos()
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
        	
        	$sqlstring = " SELECT    F12.UKEY CHAVE_PRIMARIA_ORIGEM
                                	,F12_001_C NUMERO_TITULO
                                	,F12_019_C SERIE_TITULO
                                	,CAST(F12_002_D AS DATE) EMISSAO
                                	,CAST(F12_013_B AS MONEY) VALOR
                                FROM F13(NOLOCK)
                                INNER JOIN f12(NOLOCK) ON f12.ukey = f13.F12_UKEY
                                WHERE (F13_009_B - F13_021_B - F13_029_B - F13_025_B) > 0.10 -- PARCELA EM ABERTO
                                	AND F13_003_D < GETDATE() -- VENCIMENTO MENOR QUE HOJE
                                	AND F12_016_C = '001'
                                	AND ISNULL(F13_997_D, '19990101') < GETDATE() -- PRORROGAÇÃO MENOR QUE HOJE
                                GROUP BY F12.UKEY
                                	,F12_001_C
                                	,F12_019_C
                                	,F12_002_D
                                	,F12_013_B ";
                          
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
     
     
     public static function setTituloImportedInRepository($objects)
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
                  
                    
                    $obj = new ITitulo();
                    
                    $objRetorno = $obj->getImportedByOrigem($object->CHAVE_PRIMARIA_ORIGEM,'ITitulo');
                    
                    if(isset($objRetorno->id))
                    {
                        $obj = $objRetorno;
                    }
                                   
                    
                    $obj->chave_origem = $object->CHAVE_PRIMARIA_ORIGEM ;
                    $obj->numero = $object->NUMERO_TITULO ;
                    $obj->serie = $object->SERIE_TITULO ;
                    $obj->emissao = $object->EMISSAO ;
                    $obj->valor = $object->VALOR ;
                                        
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
