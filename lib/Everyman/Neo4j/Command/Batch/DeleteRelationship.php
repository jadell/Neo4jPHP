<?php
namespace Everyman\Neo4j\Command\Batch;
use Everyman\Neo4j\Client,
	Everyman\Neo4j\Relationship,
	Everyman\Neo4j\Command\DeleteRelationship as SingleDeleteRelationship;

/**
 * Delete a relationship in a batch
 */
class DeleteRelationship extends Command
{
	protected $opId = null;
	protected $base = null;

	/**
	 * Set the operation to drive the command
	 *
	 * @param Client $client
	 * @param Relationship $rel
	 * @param integer $opId
	 */
	public function __construct(Client $client, Relationship $rel, $opId)
	{
		parent::__construct($client);
		$this->base = new SingleDeleteRelationship($client, $rel);
		$this->opId = $opId;
	}

	/**
	 * Return the data to pass
	 *
	 * @return array
	 */
	protected function getData()
	{
		$opData = array(array(
			'method' => strtoupper($this->base->getMethod()),
			'to' => $this->base->getPath(),
			'id' => $this->opId,
		));
		return $opData;
	}
}

