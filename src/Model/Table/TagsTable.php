<?php
namespace Tags\Model\Table;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\ORM\Table;
use RuntimeException;

/**
 * @method \Tags\Model\Entity\Tag get($primaryKey, $options = [])
 * @method \Tags\Model\Entity\Tag newEntity($data = null, array $options = [])
 * @method \Tags\Model\Entity\Tag[] newEntities(array $data, array $options = [])
 * @method \Tags\Model\Entity\Tag|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Tags\Model\Entity\Tag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Tags\Model\Entity\Tag[] patchEntities($entities, array $data, array $options = [])
 * @method \Tags\Model\Entity\Tag findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TagsTable extends Table {

	/**
	 * Initialize table config.
	 *
	 * @param array $config Config options
	 * @return void
	 */
	public function initialize(array $config) {
		$this->table('tags_tags');
		$this->displayField('label'); // Change to name?
		$this->addBehavior('Timestamp');

		$slugger = Configure::read('Tags.slugBehavior');
		if (!$slugger) {
			return;
		}
		if ($slugger === true) {
			if (Plugin::loaded('Tools')) {
				$this->addBehavior('Tools.Slugged');
				return;
			}
			if (Plugin::loaded('Muffin/Slug')) {
				$this->addBehavior('Muffin/Slug.Slug');
				return;
			}

			throw new RuntimeException('Auto-slug behaviors not found');
		}

		$this->addBehavior($slugger);
	}

}
