<?php
namespace Everyman\Neo4j\Cypher;

use Everyman\Neo4j;

/**
 * Represents a Cypher query string and variables
 * Query the database using Cypher. For query syntax, please refer
 * to the Cypher documentation for your server version.
 *
 * Latest documentation:
 * http://docs.neo4j.org/chunked/snapshot/cypher-query-lang.html
 */
class Query implements Neo4j\Query
{
	protected $client = null;
	protected $template = null;
	protected $vars = array();

	protected $result = null;

	/**
	 * @var bool
	 */
	private $stats;

	/**
	 * Set the template to use
	 *
	 * @param Neo4j\Client $client
	 * @param string $template A Cypher query string or template
	 * @param array $vars Replacement vars to inject into the query
	 * @param bool $stats Set to TRUE to return query statistics
	 */
	public function __construct(Neo4j\Client $client, $template, $vars=array(), $stats=false)
	{
		$this->client = $client;
		$this->template = $template;
		$this->vars = $vars;
		$this->stats = $stats;
	}

	/**
	 * Get the query script
	 *
	 * @return string
	 */
	public function getQuery()
	{
		return $this->template;
	}

	/**
	 * Get the template parameters
	 *
	 * @return array
	 */
	public function getParameters()
	{
		return $this->vars;
	}

	/**
	 * @return bool
	 */
	public function includeStats()
	{
		return $this->stats;
	}

	/**
	 * Retrieve the query results
	 *
	 * @return Neo4j\Query\ResultSet
	 */
	public function getResultSet()
	{
		if ($this->result === null) {
			$this->result = $this->client->executeCypherQuery($this);
		}

		return $this->result;
	}
}
