<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Set;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * View method
     *
     * @param string|null $id User id.
     * @param string|null $action Desired action.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getTransactions($id = null, $action = null)
    {
        $this->RequestHandler->renderAs($this, 'json');
        if ($this->request->is('get')) {
            if ($action == 'Transactions') {
                //$user = $this->Users->get($id);
                
                $query = TableRegistry::get('transactions')->find('all')
                    ->where(['Transactions.user_id =' => (int)$id]);

                $arr = array();
                foreach($query as $row) {
                    $arr[] = $row;
                }
                
                $this->set('data', $arr);
                $this->set('_serialize', ['data']);
            }
        }
    }
}
