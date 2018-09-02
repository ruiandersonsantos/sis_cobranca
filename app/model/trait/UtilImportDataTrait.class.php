<?php

trait UtilImportDataTrait
{

    public function getImportedByOrigem($chave_origem, $class)
    {
        $IPais = new stdClass;
        
        try
        {
            TTransaction::open('bd_cobranca');
            
                $repository = new TRepository($class);
                $repository->where('chave_origem','=',$chave_origem);
                
                $objects = $repository->load();
                
                if($objects)
                {
                    foreach($objects as $obj)
                    {
                        $IPais = $obj;
                    }
                } 
            
            TTransaction::close();
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
        
        return $IPais;
    }
    
    
    public static function setLogImported($objLog)
    {    
               
        try
        {
            TTransaction::open('bd_cobranca');
            
            $objLog->store();
                                      
            TTransaction::close();
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    
    
    }
    
    public static function getObjetcNoImported()
    {    
       
        try
        {
            TTransaction::open(self::$database);
             
            $criteria = new TCriteria;
            $criteria->add(new TFilter('importado', '=', 0));
            
            $classe = get_class();
           
            $objs =  $classe::getObjects( $criteria );
            
            TTransaction::close();
            
            return $objs;
            
        }
        catch(Exception $e)
        {
            TTransaction::rollback();
                                  
            throw new Exception("Problemas carregando dados do Repositorio! ".$e->getMessage());
           
        }
        
        
       
       
    }
    
    public static function getObjetcParentNoImported($coluna_referencia,$objectParent)
    {    
        try
        {
            TTransaction::open(self::$database);
             
            $criteria = new TCriteria;
            $criteria->add(new TFilter($coluna_referencia, '=', $objectParent->chave_origem));
           
            $classe = get_class();
            
            $objs =  $classe::getObjects( $criteria );
            
            TTransaction::close();
             
            return $objs;
        }
        catch(Exception $e)
        {
            TTransaction::rollback();
                                  
            throw new Exception("Problemas carregando dados do Parent! ".$e->getMessage());
           
        }
       
    }
    
    public static function getObjetcChild($chave_origem)
    {    
        try
        {
            TTransaction::open(self::$database);
             
            $criteria = new TCriteria;
            $criteria->add(new TFilter('chave_origem', '=', $chave_origem));
           
            $classe = get_class();
            
            $objs =  $classe::getObjects( $criteria );
            
            TTransaction::close();
            
            foreach($objs as $obj)
            {
                return $obj;
            } 
            
        }
        catch(Exception $e)
        {
            TTransaction::rollback();
                                  
            throw new Exception("Problemas carregando dados do Parent! ".$e->getMessage());
           
        }
       
    }
    
    public static function getObjetcChildByChave($coluna,$chave)
    {    
        try
        {
            TTransaction::open(self::$database);
             
            $criteria = new TCriteria;
            $criteria->add(new TFilter($coluna, '=', $chave));
           
            $classe = get_class();
            
            $objs =  $classe::getObjects( $criteria );
            
            TTransaction::close();
            
            foreach($objs as $obj)
            {
                return $obj;
            } 
            
        }
        catch(Exception $e)
        {
            TTransaction::rollback();
                                  
            throw new Exception("Problemas carregando dados do Parent! ".$e->getMessage());
           
        }
       
    }
    
    public static function setObjetcFlagImported($object)
    {    
        try
        {
            TTransaction::open(self::$database);
            
            $object->importado = 1;
            $object->store();   
            
            TTransaction::close();
             
            return $object;
        }
        catch(Exception $e)
        {
            TTransaction::rollback();
                                  
            throw new Exception("Problemas atualizando objeto para importado! ".$e->getMessage());
           
        }
       
    }
    

}
?>