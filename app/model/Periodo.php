<?php

class Periodo extends TRecord
{
    const TABLENAME  = 'periodo';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('codigo');
        parent::addAttribute('data_iniciio');
        parent::addAttribute('data_fim');
    }

    
    /**
     * Method getReconfiles
     */
    public function getReconfiles()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('periodo_id', '=', $this->id));
        return Reconfile::getObjects( $criteria );
    }
}

