<?php

class Reconfile extends TRecord
{
    const TABLENAME  = 'reconfile';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    
    private $tipo_reconfile;
    private $periodo;
    private $fabricante;
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('codigo');
        parent::addAttribute('descricao');
        parent::addAttribute('fabricante_id');
        parent::addAttribute('periodo_id');
        parent::addAttribute('tipo_reconfile_id');
        parent::addAttribute('nome_arquivo');
        parent::addAttribute('data_arquivo');
    }

    /**
     * Method set_tipo_reconfile
     * Sample of usage: $var->tipo_reconfile = $object;
     * @param $object Instance of TipoReconfile
     */
    public function set_tipo_reconfile(TipoReconfile $object)
    {
        $this->tipo_reconfile = $object;
        $this->tipo_reconfile_id = $object->id;
    }
    
    /**
     * Method get_tipo_reconfile
     * Sample of usage: $var->tipo_reconfile->attribute;
     * @returns TipoReconfile instance
     */
    public function get_tipo_reconfile()
    {
        
        // loads the associated object
        if (empty($this->tipo_reconfile))
            $this->tipo_reconfile = new TipoReconfile($this->tipo_reconfile_id);
        
        // returns the associated object
        return $this->tipo_reconfile;
    }
    /**
     * Method set_periodo
     * Sample of usage: $var->periodo = $object;
     * @param $object Instance of Periodo
     */
    public function set_periodo(Periodo $object)
    {
        $this->periodo = $object;
        $this->periodo_id = $object->id;
    }
    
    /**
     * Method get_periodo
     * Sample of usage: $var->periodo->attribute;
     * @returns Periodo instance
     */
    public function get_periodo()
    {
        
        // loads the associated object
        if (empty($this->periodo))
            $this->periodo = new Periodo($this->periodo_id);
        
        // returns the associated object
        return $this->periodo;
    }
    /**
     * Method set_fabricante
     * Sample of usage: $var->fabricante = $object;
     * @param $object Instance of Fabricante
     */
    public function set_fabricante(Fabricante $object)
    {
        $this->fabricante = $object;
        $this->fabricante_id = $object->id;
    }
    
    /**
     * Method get_fabricante
     * Sample of usage: $var->fabricante->attribute;
     * @returns Fabricante instance
     */
    public function get_fabricante()
    {
        
        // loads the associated object
        if (empty($this->fabricante))
            $this->fabricante = new Fabricante($this->fabricante_id);
        
        // returns the associated object
        return $this->fabricante;
    }
    
}

