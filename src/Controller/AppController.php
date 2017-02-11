<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $helpers = [
        'Html' => [
            'className' => 'Bootstrap.BootstrapHtml'
        ],
        'Form' => [
            'className' => 'Bootstrap.BootstrapForm'
        ],
        'Paginator' => [
            'className' => 'Bootstrap.BootstrapPaginator'
        ],
        'Modal' => [
            'className' => 'Bootstrap.BootstrapModal'
        ]
    ];


    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'loginRedirect' => [
                '_name' => 'admin_home'
            ],
            'logoutRedirect' => [
                '_name' => 'home'
            ],
            'authError' => 'Vous n\'êtes pas autorisé à accéder ici.',
            'authorize' => ['Controller'],
            'unauthorizedRedirect' => false
        ]);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
        Time::setDefaultLocale('fr-FR'); // For any mutable DateTime
        Time::setToStringFormat('dd/MM/yyyy HH:mm');
        FrozenTime::setDefaultLocale('fr-FR'); // For any mutable DateFrozenTime
        FrozenTime::setToStringFormat('dd/MM/yyyy HH:mm');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }


    }

    public function beforeFilter(Event $event)
    {

        if($this->request->param('prefix') === 'admin'){
            $this->Auth->deny();
            $this->Auth->allow(['logout']);
        }
        else $this->Auth->allow();


        $this->set('userDetails', $this->Auth->user());
    }

    public function isAuthorized($user){

        if($this->request->param('prefix') === 'admin') return isset($user['role']) && $user['role'] === 'admin';

        return parent::isAuthorized($user);

    }
}
