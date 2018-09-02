<?php

class ClienteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bd_cobranca';
    private static $activeRecord = 'Cliente';
    private static $primaryKey = 'id';
    private static $formName = 'form_Cliente';

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
        $this->form->setFormTitle('Cadastro de cliente');


        $id = new TEntry('id');
        $codigo = new TEntry('codigo');
        $razao = new TEntry('razao');
        $nome_fantasia = new TEntry('nome_fantasia');
        $documento = new TEntry('documento');
        $endereco_cliente_cep = new TEntry('endereco_cliente_cep');
        $endereco_cliente_logradouro = new TEntry('endereco_cliente_logradouro');
        $endereco_cliente_numero = new TEntry('endereco_cliente_numero');
        $endereco_cliente_bairro = new TEntry('endereco_cliente_bairro');
        $endereco_cliente_complemento = new TEntry('endereco_cliente_complemento');
        $endereco_cliente_cidade_id = new TDBUniqueSearch('endereco_cliente_cidade_id', 'bd_cobranca', 'Cidade', 'id', 'descricao','id asc'  );
        $contato_cliente_nome = new TEntry('contato_cliente_nome');
        $contato_cliente_email = new TEntry('contato_cliente_email');
        $contato_cliente_telefone = new TEntry('contato_cliente_telefone');
        $contato_cliente_celular = new TEntry('contato_cliente_celular');
        $contato_cliente_observacoes = new TText('contato_cliente_observacoes');
        $endereco_cliente_id = new THidden('endereco_cliente_id');
        $contato_cliente_in = new THidden('contato_cliente_in');

        $endereco_cliente_cidade_id->setMinLength(2);
        $endereco_cliente_cidade_id->setMask('{descricao}');
        $id->setEditable(false);
        $codigo->setEditable(false);

        $id->setSize(100);
        $razao->setSize('40%');
        $codigo->setSize('20%');
        $documento->setSize('40%');
        $nome_fantasia->setSize('40%');
        $endereco_cliente_cep->setSize('10%');
        $contato_cliente_nome->setSize('40%');
        $contato_cliente_email->setSize('40%');
        $endereco_cliente_numero->setSize('10%');
        $endereco_cliente_bairro->setSize('20%');
        $contato_cliente_celular->setSize('20%');
        $contato_cliente_telefone->setSize('20%');
        $endereco_cliente_cidade_id->setSize('40%');
        $endereco_cliente_logradouro->setSize('40%');
        $endereco_cliente_complemento->setSize('40%');
        $contato_cliente_observacoes->setSize('40%', 90);



        $this->form->appendPage('Principal');
        $row1 = $this->form->addFields([new TLabel('Id:', null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel('Código ERP:', null, '14px', null)],[$codigo]);
        $row3 = $this->form->addFields([new TLabel('Razao:', null, '14px', null)],[$razao]);
        $row4 = $this->form->addFields([new TLabel('Nome fantasia:', null, '14px', null)],[$nome_fantasia]);
        $row5 = $this->form->addFields([new TLabel('Documento:', null, '14px', null)],[$documento]);

        $this->form->appendPage('Endereços');
        $row6 = $this->form->addContent([new TFormSeparator('Endereço', '#333333', '18', '#eeeeee')]);
        $row7 = $this->form->addFields([new TLabel('Cep:', null, '14px', null)],[$endereco_cliente_cep]);
        $row8 = $this->form->addFields([new TLabel('Logradouro:', null, '14px', null)],[$endereco_cliente_logradouro]);
        $row9 = $this->form->addFields([new TLabel('Numero:', null, '14px', null)],[$endereco_cliente_numero]);
        $row10 = $this->form->addFields([new TLabel('Bairro:', null, '14px', null)],[$endereco_cliente_bairro]);
        $row11 = $this->form->addFields([new TLabel('Complemento:', null, '14px', null)],[$endereco_cliente_complemento]);
        $row12 = $this->form->addFields([new TLabel('Cidade:', null, '14px', null)],[$endereco_cliente_cidade_id]);
        $row13 = $this->form->addFields([$endereco_cliente_id]);         
        $add_endereco_cliente = new TButton('add_endereco_cliente');

        $action_endereco_cliente = new TAction(array($this, 'onAddEnderecoCliente'));

        $add_endereco_cliente->setAction($action_endereco_cliente, 'Adicionar');
        $add_endereco_cliente->setImage('fa:plus #000000');

        $this->form->addFields([$add_endereco_cliente]);

        $this->endereco_cliente_list = new BootstrapDatagridWrapper(new TQuickGrid);
        $this->endereco_cliente_list->style = 'width:100%';
        $this->endereco_cliente_list->class .= ' table-bordered';
        $this->endereco_cliente_list->disableDefaultClick();
        $this->endereco_cliente_list->addQuickColumn('', 'edit', 'left', 50);
        $this->endereco_cliente_list->addQuickColumn('', 'delete', 'left', 50);

        $column_endereco_cliente_cep = $this->endereco_cliente_list->addQuickColumn('Cep', 'endereco_cliente_cep', 'left');
        $column_endereco_cliente_logradouro = $this->endereco_cliente_list->addQuickColumn('Logradouro', 'endereco_cliente_logradouro', 'left');
        $column_endereco_cliente_numero = $this->endereco_cliente_list->addQuickColumn('Numero', 'endereco_cliente_numero', 'left');
        $column_endereco_cliente_bairro = $this->endereco_cliente_list->addQuickColumn('Bairro', 'endereco_cliente_bairro', 'left');
        $column_endereco_cliente_complemento = $this->endereco_cliente_list->addQuickColumn('Complemento', 'endereco_cliente_complemento', 'left');
        $column_endereco_cliente_cidade_id = $this->endereco_cliente_list->addQuickColumn('Cidade', 'endereco_cliente_cidade_id', 'left');

        $this->endereco_cliente_list->createModel();
        $this->form->addContent([$this->endereco_cliente_list]);

        $this->form->appendPage('Contatos');
        $row14 = $this->form->addContent([new TFormSeparator('Contato', '#333333', '18', '#eeeeee')]);
        $row15 = $this->form->addFields([new TLabel('Nome:', null, '14px', null)],[$contato_cliente_nome]);
        $row16 = $this->form->addFields([new TLabel('Email:', null, '14px', null)],[$contato_cliente_email]);
        $row17 = $this->form->addFields([new TLabel('Telefone:', null, '14px', null)],[$contato_cliente_telefone]);
        $row18 = $this->form->addFields([new TLabel('Celular:', null, '14px', null)],[$contato_cliente_celular]);
        $row19 = $this->form->addFields([new TLabel('Observações:', null, '14px', null)],[$contato_cliente_observacoes]);
        $row20 = $this->form->addFields([$contato_cliente_in]);         
        $add_contato_cliente = new TButton('add_contato_cliente');

        $action_contato_cliente = new TAction(array($this, 'onAddContatoCliente'));

        $add_contato_cliente->setAction($action_contato_cliente, 'Adicionar');
        $add_contato_cliente->setImage('fa:plus #000000');

        $this->form->addFields([$add_contato_cliente]);

        $this->contato_cliente_list = new BootstrapDatagridWrapper(new TQuickGrid);
        $this->contato_cliente_list->style = 'width:100%';
        $this->contato_cliente_list->class .= ' table-bordered';
        $this->contato_cliente_list->disableDefaultClick();
        $this->contato_cliente_list->addQuickColumn('', 'edit', 'left', 50);
        $this->contato_cliente_list->addQuickColumn('', 'delete', 'left', 50);

        $column_contato_cliente_nome = $this->contato_cliente_list->addQuickColumn('Nome', 'contato_cliente_nome', 'left');
        $column_contato_cliente_email = $this->contato_cliente_list->addQuickColumn('Email', 'contato_cliente_email', 'left');
        $column_contato_cliente_telefone = $this->contato_cliente_list->addQuickColumn('Telefone', 'contato_cliente_telefone', 'left');
        $column_contato_cliente_celular = $this->contato_cliente_list->addQuickColumn('Celular', 'contato_cliente_celular', 'left');
        $column_contato_cliente_observacoes = $this->contato_cliente_list->addQuickColumn('Observacoes', 'contato_cliente_observacoes', 'left');

        $this->contato_cliente_list->createModel();
        $this->form->addContent([$this->contato_cliente_list]);

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        // create the form actions
        $btn_onsave = $this->form->addAction('Salvar', new TAction([$this, 'onSave']), 'fa:floppy-o #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction('Limpar formulário', new TAction([$this, 'onClear']), 'fa:eraser #dd5a43');

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
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

            $object = new Cliente(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $contato_cliente_items = $this->storeItems('Contato', 'cliente_id', $object, 'contato_cliente', function($masterObject, $detailObject){ 

                //code here

            }); 

            $endereco_cliente_items = $this->storeItems('Endereco', 'cliente_id', $object, 'endereco_cliente', function($masterObject, $detailObject){ 

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

                $object = new Cliente($key); // instantiates the Active Record 

                $contato_cliente_items = $this->loadItems('Contato', 'cliente_id', $object, 'contato_cliente', function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }); 

                $endereco_cliente_items = $this->loadItems('Endereco', 'cliente_id', $object, 'endereco_cliente', function($masterObject, $detailObject, $objectItems){ 

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

        TSession::setValue('endereco_cliente_items', null);
        TSession::setValue('contato_cliente_items', null);

        $this->onReload();
    }

    public function onAddEnderecoCliente( $param )
    {
        try
        {
            $data = $this->form->getData();

            if(!$data->endereco_cliente_logradouro)
            {
                throw new Exception(AdiantiCoreTranslator::translate('The field ^1 is required', 'Logradouro'));
            }             
            if(!$data->endereco_cliente_cidade_id)
            {
                throw new Exception(AdiantiCoreTranslator::translate('The field ^1 is required', 'Cidade id'));
            }             

            $endereco_cliente_items = TSession::getValue('endereco_cliente_items');
            $key = isset($data->endereco_cliente_id) && $data->endereco_cliente_id ? $data->endereco_cliente_id : uniqid();
            $fields = []; 

            $fields['endereco_cliente_cep'] = $data->endereco_cliente_cep;
            $fields['endereco_cliente_logradouro'] = $data->endereco_cliente_logradouro;
            $fields['endereco_cliente_numero'] = $data->endereco_cliente_numero;
            $fields['endereco_cliente_bairro'] = $data->endereco_cliente_bairro;
            $fields['endereco_cliente_complemento'] = $data->endereco_cliente_complemento;
            $fields['endereco_cliente_cidade_id'] = $data->endereco_cliente_cidade_id;
            $endereco_cliente_items[ $key ] = $fields;

            TSession::setValue('endereco_cliente_items', $endereco_cliente_items);

            $data->endereco_cliente_id = '';
            $data->endereco_cliente_cep = '';
            $data->endereco_cliente_logradouro = '';
            $data->endereco_cliente_numero = '';
            $data->endereco_cliente_bairro = '';
            $data->endereco_cliente_complemento = '';
            $data->endereco_cliente_cidade_id = '';

            $this->form->setData($data);

            $this->onReload( $param );
        }
        catch (Exception $e)
        {
            $this->form->setData( $this->form->getData());

            new TMessage('error', $e->getMessage());
        }
    }

    public function onEditEnderecoCliente( $param )
    {
        $data = $this->form->getData();

        // read session items
        $items = TSession::getValue('endereco_cliente_items');

        // get the session item
        $item = $items[$param['endereco_cliente_id_row_id']];

        $data->endereco_cliente_cep = $item['endereco_cliente_cep'];
        $data->endereco_cliente_logradouro = $item['endereco_cliente_logradouro'];
        $data->endereco_cliente_numero = $item['endereco_cliente_numero'];
        $data->endereco_cliente_bairro = $item['endereco_cliente_bairro'];
        $data->endereco_cliente_complemento = $item['endereco_cliente_complemento'];
        $data->endereco_cliente_cidade_id = $item['endereco_cliente_cidade_id'];

        $data->endereco_cliente_id = $param['endereco_cliente_id_row_id'];

        // fill product fields
        $this->form->setData( $data );

        $this->onReload( $param );
    }

    public function onDeleteEnderecoCliente( $param )
    {
        $data = $this->form->getData();

        $data->endereco_cliente_cep = '';
        $data->endereco_cliente_logradouro = '';
        $data->endereco_cliente_numero = '';
        $data->endereco_cliente_bairro = '';
        $data->endereco_cliente_complemento = '';
        $data->endereco_cliente_cidade_id = '';

        // clear form data
        $this->form->setData( $data );

        // read session items
        $items = TSession::getValue('endereco_cliente_items');

        // delete the item from session
        unset($items[$param['endereco_cliente_id_row_id']]);
        TSession::setValue('endereco_cliente_items', $items);

        // reload sale items
        $this->onReload( $param );
    }

    public function onReloadEnderecoCliente( $param )
    {
        $items = TSession::getValue('endereco_cliente_items'); 

        $this->endereco_cliente_list->clear(); 

        if($items) 
        { 
            $cont = 1; 
            foreach ($items as $key => $item) 
            {
                $rowItem = new StdClass;

                $action_del = new TAction(array($this, 'onDeleteEnderecoCliente')); 
                $action_del->setParameter('endereco_cliente_id_row_id', $key);   

                $action_edi = new TAction(array($this, 'onEditEnderecoCliente'));  
                $action_edi->setParameter('endereco_cliente_id_row_id', $key);  

                $button_del = new TButton('delete_endereco_cliente'.$cont);
                $button_del->class = 'btn btn-default btn-sm';
                $button_del->setAction($action_del, '');
                $button_del->setImage('fa:trash-o'); 
                $button_del->setFormName($this->form->getName());

                $button_edi = new TButton('edit_endereco_cliente'.$cont);
                $button_edi->class = 'btn btn-default btn-sm';
                $button_edi->setAction($action_edi, '');
                $button_edi->setImage('bs:edit');
                $button_edi->setFormName($this->form->getName());

                $rowItem->edit = $button_edi;
                $rowItem->delete = $button_del;

                $rowItem->endereco_cliente_cep = isset($item['endereco_cliente_cep']) ? $item['endereco_cliente_cep'] : '';
                $rowItem->endereco_cliente_logradouro = isset($item['endereco_cliente_logradouro']) ? $item['endereco_cliente_logradouro'] : '';
                $rowItem->endereco_cliente_numero = isset($item['endereco_cliente_numero']) ? $item['endereco_cliente_numero'] : '';
                $rowItem->endereco_cliente_bairro = isset($item['endereco_cliente_bairro']) ? $item['endereco_cliente_bairro'] : '';
                $rowItem->endereco_cliente_complemento = isset($item['endereco_cliente_complemento']) ? $item['endereco_cliente_complemento'] : '';
                $rowItem->endereco_cliente_cidade_id = '';
                if(isset($item['endereco_cliente_cidade_id']) && $item['endereco_cliente_cidade_id'])
                {
                    TTransaction::open('bd_cobranca');
                    $cidade = Cidade::find($item['endereco_cliente_cidade_id']);
                    if($cidade)
                    {
                        $rowItem->endereco_cliente_cidade_id = $cidade->render('{descricao}');
                    }
                    TTransaction::close();
                }

                $row = $this->endereco_cliente_list->addItem($rowItem);

                $cont++;
            } 
        } 
    } 

    public function onAddContatoCliente( $param )
    {
        try
        {
            $data = $this->form->getData();

            $contato_cliente_items = TSession::getValue('contato_cliente_items');
            $key = isset($data->contato_cliente_in) && $data->contato_cliente_in ? $data->contato_cliente_in : uniqid();
            $fields = []; 

            $fields['contato_cliente_nome'] = $data->contato_cliente_nome;
            $fields['contato_cliente_email'] = $data->contato_cliente_email;
            $fields['contato_cliente_telefone'] = $data->contato_cliente_telefone;
            $fields['contato_cliente_celular'] = $data->contato_cliente_celular;
            $fields['contato_cliente_observacoes'] = $data->contato_cliente_observacoes;
            $contato_cliente_items[ $key ] = $fields;

            TSession::setValue('contato_cliente_items', $contato_cliente_items);

            $data->contato_cliente_in = '';
            $data->contato_cliente_nome = '';
            $data->contato_cliente_email = '';
            $data->contato_cliente_telefone = '';
            $data->contato_cliente_celular = '';
            $data->contato_cliente_observacoes = '';

            $this->form->setData($data);

            $this->onReload( $param );
        }
        catch (Exception $e)
        {
            $this->form->setData( $this->form->getData());

            new TMessage('error', $e->getMessage());
        }
    }

    public function onEditContatoCliente( $param )
    {
        $data = $this->form->getData();

        // read session items
        $items = TSession::getValue('contato_cliente_items');

        // get the session item
        $item = $items[$param['contato_cliente_in_row_id']];

        $data->contato_cliente_nome = $item['contato_cliente_nome'];
        $data->contato_cliente_email = $item['contato_cliente_email'];
        $data->contato_cliente_telefone = $item['contato_cliente_telefone'];
        $data->contato_cliente_celular = $item['contato_cliente_celular'];
        $data->contato_cliente_observacoes = $item['contato_cliente_observacoes'];

        $data->contato_cliente_in = $param['contato_cliente_in_row_id'];

        // fill product fields
        $this->form->setData( $data );

        $this->onReload( $param );
    }

    public function onDeleteContatoCliente( $param )
    {
        $data = $this->form->getData();

        $data->contato_cliente_nome = '';
        $data->contato_cliente_email = '';
        $data->contato_cliente_telefone = '';
        $data->contato_cliente_celular = '';
        $data->contato_cliente_observacoes = '';

        // clear form data
        $this->form->setData( $data );

        // read session items
        $items = TSession::getValue('contato_cliente_items');

        // delete the item from session
        unset($items[$param['contato_cliente_in_row_id']]);
        TSession::setValue('contato_cliente_items', $items);

        // reload sale items
        $this->onReload( $param );
    }

    public function onReloadContatoCliente( $param )
    {
        $items = TSession::getValue('contato_cliente_items'); 

        $this->contato_cliente_list->clear(); 

        if($items) 
        { 
            $cont = 1; 
            foreach ($items as $key => $item) 
            {
                $rowItem = new StdClass;

                $action_del = new TAction(array($this, 'onDeleteContatoCliente')); 
                $action_del->setParameter('contato_cliente_in_row_id', $key);   

                $action_edi = new TAction(array($this, 'onEditContatoCliente'));  
                $action_edi->setParameter('contato_cliente_in_row_id', $key);  

                $button_del = new TButton('delete_contato_cliente'.$cont);
                $button_del->class = 'btn btn-default btn-sm';
                $button_del->setAction($action_del, '');
                $button_del->setImage('fa:trash-o'); 
                $button_del->setFormName($this->form->getName());

                $button_edi = new TButton('edit_contato_cliente'.$cont);
                $button_edi->class = 'btn btn-default btn-sm';
                $button_edi->setAction($action_edi, '');
                $button_edi->setImage('bs:edit');
                $button_edi->setFormName($this->form->getName());

                $rowItem->edit = $button_edi;
                $rowItem->delete = $button_del;

                $rowItem->endereco_cliente_cep = isset($item['endereco_cliente_cep']) ? $item['endereco_cliente_cep'] : '';
                $rowItem->endereco_cliente_logradouro = isset($item['endereco_cliente_logradouro']) ? $item['endereco_cliente_logradouro'] : '';
                $rowItem->endereco_cliente_numero = isset($item['endereco_cliente_numero']) ? $item['endereco_cliente_numero'] : '';
                $rowItem->endereco_cliente_bairro = isset($item['endereco_cliente_bairro']) ? $item['endereco_cliente_bairro'] : '';
                $rowItem->endereco_cliente_complemento = isset($item['endereco_cliente_complemento']) ? $item['endereco_cliente_complemento'] : '';
                $rowItem->endereco_cliente_cidade_id = '';
                if(isset($item['endereco_cliente_cidade_id']) && $item['endereco_cliente_cidade_id'])
                {
                    TTransaction::open('bd_cobranca');
                    $cidade = Cidade::find($item['endereco_cliente_cidade_id']);
                    if($cidade)
                    {
                        $rowItem->endereco_cliente_cidade_id = $cidade->render('{descricao}');
                    }
                    TTransaction::close();
                }

                $rowItem->contato_cliente_nome = isset($item['contato_cliente_nome']) ? $item['contato_cliente_nome'] : '';
                $rowItem->contato_cliente_email = isset($item['contato_cliente_email']) ? $item['contato_cliente_email'] : '';
                $rowItem->contato_cliente_telefone = isset($item['contato_cliente_telefone']) ? $item['contato_cliente_telefone'] : '';
                $rowItem->contato_cliente_celular = isset($item['contato_cliente_celular']) ? $item['contato_cliente_celular'] : '';
                $rowItem->contato_cliente_observacoes = isset($item['contato_cliente_observacoes']) ? $item['contato_cliente_observacoes'] : '';

                $row = $this->contato_cliente_list->addItem($rowItem);

                $cont++;
            } 
        } 
    } 

    public function onShow($param = null)
    {
        TSession::setValue('endereco_cliente_items', null);
        TSession::setValue('contato_cliente_items', null);

        $this->onReload();

    } 

    public function onReload($params = null)
    {
        $this->loaded = TRUE;

        $this->onReloadEnderecoCliente($params);
        $this->onReloadContatoCliente($params);
    }

    public function show() 
    { 
        $param = func_get_arg(0);
        if(!empty($param['current_tab']))
        {
            $this->form->setCurrentPage($param['current_tab']);
        }
        if (!$this->loaded AND (!isset($_GET['method']) OR $_GET['method'] !== 'onReload') ) 
        { 
            $this->onReload( func_get_arg(0) );
        }
        parent::show();
    }

}

