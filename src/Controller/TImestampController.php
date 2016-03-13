<?php
    
namespace App\Controller;

use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
    
    
class TimestampController extends AppController
{
    
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
    
    public function getUnixTime()
    {
        if ($this->request->is('get')) {
            $this->RequestHandler->renderAs($this, 'json');
            $this->set([
                'Timestamp' => time(),
                '_serialize' => ['Timestamp']
            ]);
        }
    }
}