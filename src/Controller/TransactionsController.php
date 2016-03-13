<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Transactions Controller
 *
 * @property \App\Model\Table\TransactionsTable $Transactions
 */
class TransactionsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->RequestHandler->renderAs($this, 'json');
        $this->paginate = [
            'contain' => ['Users', 'Products']
        ];
        $transactions = $this->paginate($this->Transactions);

        $this->set(compact('transactions'));
        $this->set('_serialize', ['transactions']);
    }

    /**
     * View method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->RequestHandler->renderAs($this, 'json');
        $transaction = $this->Transactions->get($id, [
            'contain' => ['Users', 'Products']
        ]);

        $this->set('transaction', $transaction);
        $this->set('_serialize', ['transaction']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function transaction()
    {
        $this->RequestHandler->renderAs($this, 'json');
        
        if ($this->request->is('get')) {
            $id = $this->request->query['transaction_id'];
            $transaction = $this->Transactions->get($id);
            $this->set([
                'product_id' => $transaction->product_id,
                'user_id' => $transaction->user_id,
                'amount' => $transaction->amount,
                '_serialize' => ['product_id', 'user_id', 'amount']
            ]);
        } else if ($this->request->is('post')) {
            //$transaction = $this->Transactions->patchEntity($transaction, $this->request->data);
            //die();
            if ($this->Transactions->save($transaction)) {
                $transaction = $this->Transactions->newEntity();
                //debug($this->request->query['user_id']);
                //die();
                //$transaction->id = 111333;
                $transaction->user_id = $this->request->query['user_id'];
                //isset($this->request->query['user_id']) ? $this->request->query['user_id'] : null;
                $transaction->amount = $this->request->query['amount'];
                //isset($this->request->query['amount']) ? $this->request->query['amount'] : null;
                $transaction->product_id = $this->request->query['product_id'];
                //isset($this->request->query['product_id']) ? $this->request->query['product_id'] : null;
                
                //$this->Flash->success(__('The transaction has been saved.'));
                $this->set('success', 'true');
                $this->set('message', 'Transaction saved successfully.');
                $this->set('_serialize', ['success', 'message']);
                //return $this->redirect(['action' => 'index']);
            } else {
                //$this->Flash->error(__('The transaction could not be saved. Please, try again.'));
                //debug($this->Transactions->invalidFields());
                $this->set('error', 'true');
                $this->set('message', $transaction->errors());
                $this->set('_serialize', ['error', 'message']);
            }
        }
        //$users = $this->Transactions->Users->find('list', ['limit' => 200]);
        //$products = $this->Transactions->Products->find('list', ['limit' => 200]);
        //$this->set(compact('transaction', 'users', 'products'));
        //$this->set('_serialize', ['transaction']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transaction = $this->Transactions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->data);
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
            }
        }
        $users = $this->Transactions->Users->find('list', ['limit' => 200]);
        $products = $this->Transactions->Products->find('list', ['limit' => 200]);
        $this->set(compact('transaction', 'users', 'products'));
        $this->set('_serialize', ['transaction']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transaction = $this->Transactions->get($id);
        if ($this->Transactions->delete($transaction)) {
            $this->Flash->success(__('The transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
