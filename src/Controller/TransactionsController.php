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
     * Method for handling
     *
     * @return \Cake\Network\Response|void Renders a json regardless of success or failure
     */
    public function transaction()
    {
        $this->RequestHandler->renderAs($this, 'json');
        /*
        if ($this->request->is('get')) {
            $id = $this->request->query['transaction_id'];
            $transaction = $this->Transactions->get($id);
            $this->set([
                'product_id' => $transaction->product_id,
                'user_id' => $transaction->user_id,
                'amount' => $transaction->amount,
                '_serialize' => ['product_id', 'user_id', 'amount']
            ]);
        } else if ($this->request->is('post')) {*/
            $transaction = $this->Transactions->newEntity();
            $transaction->user_id = isset($this->request->query['user_id']) ? $this->request->query['user_id'] : null;
            $transaction->amount = isset($this->request->query['amount']) ? $this->request->query['amount'] : null;
            $transaction->product_id = isset($this->request->query['product_id']) ? $this->request->query['product_id'] : null;
            if ($this->Transactions->save($transaction)) {
                $this->set('success', 'true');
                $this->set('message', 'Transaction saved successfully.');
                $this->set('_serialize', ['success', 'message']);
            } else {
                $this->set('error', 'true');
                $this->set('message', $transaction->errors());
                $this->set('_serialize', ['error', 'message']);
            }
        //}
    }
}
