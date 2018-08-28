<?php

class BancoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bd_cobranca';
    private static $activeRecord = 'Banco';
    private static $primaryKey = 'id';
    private static $formName = 'form_Banco';

    use Adianti\Base\AdiantiMasterDetailTrait;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle('Cadastro de banco');


        $id = new TEntry('id');
        $codigo = new TEntry('codigo');
        $nome_banco = new TEntry('nome_banco');
        $nome_banco_completo = new TEntry('nome_banco_completo');
        $agencia_banco_codigo = new TEntry('agencia_banco_codigo');
        $agencia_banco_nome_agencia = new TEntry('agencia_banco_nome_agencia');
        $agencia_banco_cidade_id = new TDBUniqueSearch('agencia_banco_cidade_id', 'bd_cobranca', 'Cidade', 'id', 'descricao','id asc'  );
        $agencia_banco_id = new THidden('agencia_banco_id');

        $codigo->addValidation('Código', new TRequiredValidator()); 
        $nome_banco->addValidation('nome', new TRequiredValidator()); 

        $id->setEditable(false);
        $agencia_banco_cidade_id->setMinLength(2);
        $agencia_banco_cidade_id->setMask('{descricao}');
        $id->setSize(100);
        $codigo->setSize('20%');
        $nome_banco->setSize('40%');
        $nome_banco_completo->setSize('40%');
        $agencia_banco_codigo->setSize('20%');
        $agencia_banco_cidade_id->setSize('41%');
        $agencia_banco_nome_agencia->setSize('40%');



        $row1 = $this->form->addFields([new TLabel('Id:', null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel('Codigo:', null, '14px', null)],[$codigo]);
        $row3 = $this->form->addFields([new TLabel('Nome banco:', null, '14px', null)],[$nome_banco]);
        $row4 = $this->form->addFields([new TLabel('Nome banco completo:', null, '14px', null)],[$nome_banco_completo]);
        $row5 = $this->form->addContent([new TFormSeparator('Agencia', '#333333', '18', '#eeeeee')]);
        $row6 = $this->form->addFields([new TLabel('Codigo:', null, '14px', null)],[$agencia_banco_codigo]);
        $row7 = $this->form->addFields([new TLabel('Nome agencia:', null, '14px', null)],[$agencia_banco_nome_agencia]);
        $row8 = $this->form->addFields([new TLabel('Cidade:', null, '14px', null)],[$agencia_banco_cidade_id]);
        $row9 = $this->form->addFields([$agencia_banco_id]);         
        $add_agencia_banco = new TButton('add_agencia_banco');

        $action_agencia_banco = new TAction(array($this, 'onAddAgenciaBanco'));

        $add_agencia_banco->setAction($action_agencia_banco, 'Adicionar');
        $add_agencia_banco->setImage('fa:plus #000000');

        $this->form->addFields([$add_agencia_banco]);

        $this->agencia_banco_list = new BootstrapDatagridWrapper(new TQuickGrid);
        $this->agencia_banco_list->style = 'width:100%';
        $this->agencia_banco_list->class .= ' table-bordered';
        $this->agencia_banco_list->disableDefaultClick();
        $this->agencia_banco_list->addQuickColumn('', 'edit', 'left', 50);
        $this->agencia_banco_list->addQuickColumn('', 'delete', 'left', 50);

        $column_agencia_banco_codigo = $this->agencia_banco_list->addQuickColumn('Codigo', 'agencia_banco_codigo', 'left');
        $column_agencia_banco_nome_agencia = $this->agencia_banco_list->addQuickColumn('Nome agencia', 'agencia_banco_nome_agencia', 'left');
        $column_agencia_banco_cidade_id = $this->agencia_banco_list->addQuickColumn('Cidade', 'agencia_banco_cidade_id', 'left');

        $this->agencia_banco_list->createModel();
        $this->form->addContent([$this->agencia_banco_list]);

        // create the form actions
        $btn_onsave = $this->form->addAction('Salvar', new TAction([$this, 'onSave']), 'fa:floppy-o #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction('Limpar formulário', new TAction([$this, 'onClear']), 'fa:eraser #dd5a43');

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        $container->add(TBreadCrumb::create(['Cadastros Iniciais','Cadastro de banco']));
        $container->add($this->form);

        parent::add($container);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Banco(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $agencia_banco_items = $this->storeItems('Agencia', 'banco_id', $object, 'agencia_banco', function($masterObject, $detailObject){ 

                //code here

            }); 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            /**
            // To define an action to be executed on the message close event:
            $messageAction = new TAction(['className', 'methodName']);
            **/

            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'), $messageAction);

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Banco($key); // instantiates the Active Record 

                $agencia_banco_items = $this->loadItems('Agencia', 'banco_id', $object, 'agencia_banco', function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }); 

                $this->form->setData($object); // fill the form 

                    $this->onReload();

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

        TSession::setValue('agencia_banco_items', null);

        $this->onReload();
    }

    public function onAddAgenciaBanco( $param )
    {
        try
        {
            $data = $this->form->getData();

            if(!$data->agencia_banco_codigo)
            {
                throw new Exception(AdiantiCoreTranslator::translate('The field ^1 is required', 'Código da agencia'));
            }             
            if(!$data->agencia_banco_nome_agencia)
            {
                throw new Exception(AdiantiCoreTranslator::translate('The field ^1 is required', 'nome da agencia'));
            }             
            if(!$data->agencia_banco_cidade_id)
            {
                throw new Exception(AdiantiCoreTranslator::translate('The field ^1 is required', 'Cidade id'));
            }             

            $agencia_banco_items = TSession::getValue('agencia_banco_items');
            $key = isset($data->agencia_banco_id) && $data->agencia_banco_id ? $data->agencia_banco_id : uniqid();
            $fields = []; 

            $fields['agencia_banco_codigo'] = $data->agencia_banco_codigo;
            $fields['agencia_banco_nome_agencia'] = $data->agencia_banco_nome_agencia;
            $fields['agencia_banco_cidade_id'] = $data->agencia_banco_cidade_id;
            $agencia_banco_items[ $key ] = $fields;

            TSession::setValue('agencia_banco_items', $agencia_banco_items);

            $data->agencia_banco_id = '';
            $data->agencia_banco_codigo = '';
            $data->agencia_banco_nome_agencia = '';
            $data->agencia_banco_cidade_id = '';

            $this->form->setData($data);

            $this->onReload( $param );
        }
        catch (Exception $e)
        {
            $this->form->setData( $this->form->getData());

            new TMessage('error', $e->getMessage());
        }
    }

    public function onEditAgenciaBanco( $param )
    {
        $data = $this->form->getData();

        // read session items
        $items = TSession::getValue('agencia_banco_items');

        // get the session item
        $item = $items[$param['agencia_banco_id_row_id']];

        $data->agencia_banco_codigo = $item['agencia_banco_codigo'];
        $data->agencia_banco_nome_agencia = $item['agencia_banco_nome_agencia'];
        $data->agencia_banco_cidade_id = $item['agencia_banco_cidade_id'];

        $data->agencia_banco_id = $param['agencia_banco_id_row_id'];

        // fill product fields
        $this->form->setData( $data );

        $this->onReload( $param );
    }

    public function onDeleteAgenciaBanco( $param )
    {
        $data = $this->form->getData();

        $data->agencia_banco_codigo = '';
        $data->agencia_banco_nome_agencia = '';
        $data->agencia_banco_cidade_id = '';

        // clear form data
        $this->form->setData( $data );

        // read session items
        $items = TSession::getValue('agencia_banco_items');

        // delete the item from session
        unset($items[$param['agencia_banco_id_row_id']]);
        TSession::setValue('agencia_banco_items', $items);

        // reload sale items
        $this->onReload( $param );
    }

    public function onReloadAgenciaBanco( $param )
    {
        $items = TSession::getValue('agencia_banco_items'); 

        $this->agencia_banco_list->clear(); 

        if($items) 
        { 
            $cont = 1; 
            foreach ($items as $key => $item) 
            {
                $rowItem = new StdClass;

                $action_del = new TAction(array($this, 'onDeleteAgenciaBanco')); 
                $action_del->setParameter('agencia_banco_id_row_id', $key);   

                $action_edi = new TAction(array($this, 'onEditAgenciaBanco'));  
                $action_edi->setParameter('agencia_banco_id_row_id', $key);  

                $button_del = new TButton('delete_agencia_banco'.$cont);
                $button_del->class = 'btn btn-default btn-sm';
                $button_del->setAction($action_del, '');
                $button_del->setImage('fa:trash-o'); 
                $button_del->setFormName($this->form->getName());

                $button_edi = new TButton('edit_agencia_banco'.$cont);
                $button_edi->class = 'btn btn-default btn-sm';
                $button_edi->setAction($action_edi, '');
                $button_edi->setImage('bs:edit');
                $button_edi->setFormName($this->form->getName());

                $rowItem->edit = $button_edi;
                $rowItem->delete = $button_del;

                $rowItem->agencia_banco_codigo = isset($item['agencia_banco_codigo']) ? $item['agencia_banco_codigo'] : '';
                $rowItem->agencia_banco_nome_agencia = isset($item['agencia_banco_nome_agencia']) ? $item['agencia_banco_nome_agencia'] : '';
                $rowItem->agencia_banco_cidade_id = '';
                if(isset($item['agencia_banco_cidade_id']) && $item['agencia_banco_cidade_id'])
                {
                    TTransaction::open('bd_cobranca');
                    $cidade = Cidade::find($item['agencia_banco_cidade_id']);
                    if($cidade)
                    {
                        $rowItem->agencia_banco_cidade_id = $cidade->render('{descricao}');
                    }
                    TTransaction::close();
                }

                $row = $this->agencia_banco_list->addItem($rowItem);

                $cont++;
            } 
        } 
    } 

    public function onShow($param = null)
    {
        TSession::setValue('agencia_banco_items', null);

        $this->onReload();

    } 

    public function onReload($params = null)
    {
        $this->loaded = TRUE;

        $this->onReloadAgenciaBanco($params);
    }

    public function show() 
    { 
        if (!$this->loaded AND (!isset($_GET['method']) OR $_GET['method'] !== 'onReload') ) 
        { 
            $this->onReload( func_get_arg(0) );
        }
        parent::show();
    }

}

