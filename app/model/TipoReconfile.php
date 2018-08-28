<?php

class TipoReconfile extends TRecord
{
    const TABLENAME  = 'tipo_reconfile';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('codigo');
        parent::addAttribute('descricao');
    }

    
    /**
     * Method getReconfiles
     */
    public function getReconfiles()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('tipo_reconfile_id', '=', $this->id));
        return Reconfile::getObjects( $criteria );
    }
}

