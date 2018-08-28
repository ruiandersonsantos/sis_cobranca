<?php
/**
 * LogImportacao Active Record
 * @author  <your-name-here>
 */
class LogImportacao extends TRecord
{
    const TABLENAME = 'log_importacao';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('data_hora');
        parent::addAttribute('nome_classe');
        parent::addAttribute('nome_metodo');
        parent::addAttribute('inicio');
        parent::addAttribute('fim');
        parent::addAttribute('quantidade_registro');
        parent::addAttribute('ocorrencia');
    }


}
