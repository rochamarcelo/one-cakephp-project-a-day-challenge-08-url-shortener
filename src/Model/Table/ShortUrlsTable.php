<?php
declare(strict_types=1);

namespace App\Model\Table;

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
        $this->setDisplayField('id');
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
            ->scalar('id')
            ->maxLength('id', 5)
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        return $validator;
    }
}
