<?php
/**
 * ICliente Active Record
 * @author  <your-name-here>
 */
class ICliente extends TRecord
{
    use UtilImportDataTrait;
    
    const TABLENAME = 'i_cliente';
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
        parent::addAttribute('codigo');
        parent::addAttribute('razao');
        parent::addAttribute('nome_fantasia');
        parent::addAttribute('documento');
        parent::addAttribute('endereco');
        parent::addAttribute('bairro');
        parent::addAttribute('complemento');
        parent::addAttribute('ddd');
        parent::addAttribute('telefone');
        parent::addAttribute('contato');
        parent::addAttribute('email');
        parent::addAttribute('chave_pais');
        parent::addAttribute('chave_estado');
        parent::addAttribute('chave_municipio');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
    }
    
    
     
     
     public static function getClienteByTitulosAbertos()
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
        	
        	$sqlstring = " SELECT A03.UKEY CHAVE_PRIMARIA_ORIGEM
                            	,A03_001_C CODIGO
                            	,A03_002_C RAZAO
                            	,A03_003_C NOME_FANTASIA
                            	,A03_010_C DOCUMENTO
                            	,A03_005_C ENDERECO
                            	,A03_004_C BAIRRO
                            	,A03_158_C COMPLEMENTO
                            	,A03_034_C DDD
                            	,A03_035_C TELEFONE
                            	,A03_037_C CONTATO
                            	,A03_043_C EMAIL
                            	,A22_UKEY CHAVE_PAIS
                            	,A23_UKEY CHAVE_ESTADO
                            	,A24_UKEY CHAVE_MUNICIPIO
                            FROM F13(NOLOCK)
                            INNER JOIN F12(NOLOCK) ON F12.UKEY = F13.F12_UKEY
                            INNER JOIN A03(NOLOCK) ON A03.UKEY = F12.F12_UKEYP
                            WHERE (F13_009_B - F13_021_B - F13_029_B - F13_025_B) > 0.10 -- PARCELA EM ABERTO
                            	AND F13_003_D < GETDATE() -- VENCIMENTO MENOR QUE HOJE
                            	AND F12_016_C = '001'
                            	AND ISNULL(F13_997_D, '19990101') < GETDATE() -- PRORROGAÇÃO MENOR QUE HOJE
                            GROUP BY A03.UKEY
                            	,A03_001_C
                            	,A03_002_C
                            	,A03_003_C
                            	,A03_010_C
                            	,A03_005_C
                            	,A03_004_C
                            	,A03_158_C
                            	,A03_034_C
                            	,A03_035_C
                            	,A03_037_C
                            	,A03_043_C
                            	,A22_UKEY
                            	,A23_UKEY
                            	,A24_UKEY ";
                          
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
     
     
     public static function setClienteImportedInRepository($objects)
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
                  
                    
                    $obj = new ICliente();
                    
                    $objRetorno = $obj->getImportedByOrigem($object->CHAVE_PRIMARIA_ORIGEM,'ICliente');
                    
                    if(isset($objRetorno->id))
                    {
                        $obj = $objRetorno;
                    }
                                   
                    
                    $obj->chave_origem = $object->CHAVE_PRIMARIA_ORIGEM ;
                    $obj->codigo = $object->CODIGO ;
                    $obj->razao = $object->RAZAO ;
                    $obj->nome_fantasia = $object->NOME_FANTASIA ;
                    $obj->documento = $object->DOCUMENTO ;
                    $obj->endereco = $object->ENDERECO ;
                    $obj->bairro = $object->BAIRRO ;
                    $obj->complemento = $object->COMPLEMENTO ;
                    $obj->ddd = $object->DDD ;
                    $obj->telefone = $object->TELEFONE ;
                    $obj->contato = $object->CONTATO ;
                    $obj->email = $object->EMAIL ;
                    $obj->chave_pais = $object->CHAVE_PAIS ;
                    $obj->chave_estado = $object->CHAVE_ESTADO ;
                    $obj->chave_municipio = $object->CHAVE_MUNICIPIO ;
                    
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
