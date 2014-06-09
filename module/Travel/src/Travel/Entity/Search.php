<?php
namespace Travel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Search
 *
 * @ORM\Table(name="search")
 * @ORM\Entity
 */
class Search
{
    /**
     * @var integer
     *
     * @ORM\Column(name="search_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $searchId;

    /**
     * @var string
     *
     * @ORM\Column(name="search_query", type="string", length=255, nullable=false)
     */
    private $searchQuery;

    /**
     * @var integer
     *
     * @ORM\Column(name="search_hits", type="integer", nullable=true)
     */
    private $searchHits;

    /**
     * @var integer
     *
     * @ORM\Column(name="search_results", type="integer", nullable=true)
     */
    private $searchResults;
	/**
	 * @return the $searchId
	 */
	public function getSearchId() {
		return $this->searchId;
	}

	/**
	 * @param number $searchId
	 */
	public function setSearchId($searchId) {
		$this->searchId = $searchId;
	}

	/**
	 * @return the $searchQuery
	 */
	public function getSearchQuery() {
		return $this->searchQuery;
	}

	/**
	 * @param string $searchQuery
	 */
	public function setSearchQuery($searchQuery) {
		$this->searchQuery = $searchQuery;
	}

	/**
	 * @return the $searchHits
	 */
	public function getSearchHits() {
		return $this->searchHits;
	}

	/**
	 * @param number $searchHits
	 */
	public function setSearchHits($searchHits) {
		$this->searchHits = $searchHits;
	}

	/**
	 * @return the $searchResults
	 */
	public function getSearchResults() {
		return $this->searchResults;
	}

	/**
	 * @param number $searchResults
	 */
	public function setSearchResults($searchResults) {
		$this->searchResults = $searchResults;
	}
}
