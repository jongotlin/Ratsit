<?php

declare(strict_types=1);

namespace JGI\Ratsit\Event;

use JGI\Ratsit\Model\SearchResult;
use Symfony\Contracts\EventDispatcher\Event;

class PersonSearchResultEvent extends Event
{
    const NAME = 'ratsit.person_search_result';

    /**
     * @var SearchResult
     */
    private $searchResult;

    /**
     * @param SearchResult $searchResult
     */
    public function __construct(SearchResult $searchResult)
    {
        $this->searchResult = $searchResult;
    }

    /**
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult
    {
        return $this->searchResult;
    }
}
