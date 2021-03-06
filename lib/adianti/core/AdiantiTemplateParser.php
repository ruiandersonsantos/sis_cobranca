<?php
namespace Adianti\Core;

use Adianti\Control\TPage;
use Adianti\Registry\TSession;
use Exception;

/**
 * Template parser
 *
 * @version    5.0
 * @package    base
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class AdiantiTemplateParser
{
    /**
     * Parse template and replace basic system variables
     * @param $content raw template
     */
    public static function parse($content)
    {
        $ini       = AdiantiApplicationConfig::get();
        $theme     = $ini['general']['theme'];
        $libraries = file_get_contents("app/templates/{$theme}/libraries.html");
        $class     = isset($_REQUEST['class']) ? $_REQUEST['class'] : '';
        
        if ((TSession::getValue('login') == 'admin') && !empty($ini['general']['token']))
        {
            if (file_exists("app/templates/{$theme}/builder-menu.html"))
            {
                $builder_menu = file_get_contents("app/templates/{$theme}/builder-menu.html");
                $content = str_replace('<!--{BUILDER-MENU}-->', $builder_menu, $content);
            }
        }
        
        if (!isset($ini['permission']['user_register']) OR $ini['permission']['user_register'] !== '1')
        {
            $content = str_replace(['<!--[CREATE-ACCOUNT]-->', '<!--[CREATE-ACCOUNT]-->'], ['<!--', '-->'], $content);
        }
        
        if (!isset($ini['permission']['reset_password']) OR $ini['permission']['reset_password'] !== '1')
        {
            $content = str_replace(['<!--[RESET-PASSWORD]-->', '<!--[RESET-PASSWORD]-->'], ['<!--', '-->'], $content);
        }
        
        $content   = str_replace('{LIBRARIES}', $libraries, $content);
        $content   = str_replace('{class}',     $class, $content);
        $content   = str_replace('{template}',  $theme, $content);
        $content   = str_replace('{login}',     TSession::getValue('login'), $content);
        $content   = str_replace('{username}',  TSession::getValue('username'), $content);
        $content   = str_replace('{usermail}',  TSession::getValue('usermail'), $content);
        $content   = str_replace('{frontpage}', TSession::getValue('frontpage'), $content);
        //$content   = str_replace('{query_string}', $_SERVER["QUERY_STRING"], $content);
        
        $css       = TPage::getLoadedCSS();
        $js        = TPage::getLoadedJS();
        $content   = str_replace('{HEAD}', $css.$js, $content);
        
        return $content;
    }
}
