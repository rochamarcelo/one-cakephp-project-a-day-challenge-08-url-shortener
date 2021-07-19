<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ShortUrls Controller
 *
 * @property \App\Model\Table\ShortUrlsTable $ShortUrls
 * @method \App\Model\Entity\ShortUrl[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShortUrlsController extends AppController
{
    /**
     * View method
     *
     * @param string|null $id Short Url id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shortUrl = $this->ShortUrls->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('shortUrl'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shortUrl = $this->ShortUrls->newEmptyEntity();
        if ($this->request->is('post')) {
            $url = trim($this->request->getData('url'));
            $shortUrlExisting = $this->ShortUrls->find()
                ->where(['url' => $url])
                ->first();
            if ($shortUrlExisting) {
                return $this->redirect([
                    'action' => 'view',
                    $shortUrlExisting->id
                ]);
            }
            $shortUrl = $this->ShortUrls->patchEntity($shortUrl, [
                'url' => $url,
            ]);
            if ($this->ShortUrls->save($shortUrl)) {
                return $this->redirect([
                    'action' => 'view',
                    $shortUrl->id
                ]);
            }
            $this->Flash->error(__('The short url could not be saved. Please, try again.'));
        }
        $this->set(compact('shortUrl'));
    }

    public function goToUrl()
    {
        $code = $this->request->getParam('code');
        $entity = $this->ShortUrls->get($code);

        return $this->redirect($entity->url);
    }
}
