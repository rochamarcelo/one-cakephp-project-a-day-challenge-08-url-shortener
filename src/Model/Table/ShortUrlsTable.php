<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\ShortUrl;
use Cake\Event\Event;
use Cake\Http\Client;
use Cake\Log\Log;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShortUrls Model
 *
 * @method \App\Model\Entity\ShortUrl newEmptyEntity()
 * @method \App\Model\Entity\ShortUrl newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ShortUrl[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShortUrl get($primaryKey, $options = [])
 * @method \App\Model\Entity\ShortUrl findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ShortUrl patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShortUrl[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShortUrl|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShortUrl saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShortUrl[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ShortUrl[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ShortUrl[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ShortUrl[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ShortUrlsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('short_urls');
        $this->setDisplayField('url');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('url')
            ->url('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        return $validator;
    }

    /**
     * Before save set random id to be used as short url code
     *
     * @param \Cake\Event\Event $event
     * @param ShortUrl $entity
     */
    public function beforeSave(Event  $event, ShortUrl $entity)
    {
        if ($entity->isNew()) {
            while(true) {
                $ids = $this->filterAvailableIds(
                    $this->generateCodes(10)
                );
                if ($ids) {
                    $entity->set('id', $ids[0]);
                    break;
                }
            }
        }
    }

    /**
     * Create N codes to use as ID
     *
     * @param int $quantity
     * @return array
     */
    protected function generateCodes($quantity): array
    {
        $result = [];
        while($quantity > 0) {
            $result[] = substr(
                str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz"),
                0,
                5
            );
            $quantity--;
        }

        return $result;
    }

    /**
     * @param array $newIds
     * @return array
     */
    protected function filterAvailableIds(array $newIds): array
    {
        $existing = $this->find()
            ->where(['id IN' => $newIds])
            ->all()
            ->extract('id')
            ->toArray();

        $available = array_filter($newIds, function ($id) use ($existing) {
            return !in_array($id, $existing);
        });

        return array_values($available);
    }

    /**
     * Set rule to check url
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add(function(ShortUrl  $shortUrl) {
            if ($shortUrl->isDirty('url')) {
                try {
                    $client = Client::createFromUrl($shortUrl->url);

                    return $client->get('')->isOk();

                } catch (\Exception $e) {
                    return false;
                }
            }
        }, 'canAccessUrl', [
            'errorField' => 'url',
            'message' => __('The provided value is invalid'),
        ]);
        return $rules;
    }


}
