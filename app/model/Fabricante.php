<?php

class Fabricante extends TRecord
{
    const TABLENAME  = 'fabricante';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('codigo');
        parent::addAttribute('cnpj');
    }

    
    /**
     * Method getReconfiles
     */
    public function getReconfiles()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('fabricante_id', '=', $this->id));
        return Reconfile::getObjects( $criteria );
    }
}

