<?php

declare(strict_types=1);

namespace JGI\Ratsit\Model;

class SearchResult implements \IteratorAggregate, \Countable
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var int
     */
    protected $totalRecordsFound = 0;

    /**
     * @return array
     */
    public function getIterator()
    {
        return $this->data;
    }

    /**
     * @param $item
     */
    public function add($item)
    {
        $this->data[] = $item;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getTotalRecordsFound(): int
    {
        return $this->totalRecordsFound;
    }

    /**
     * @param int $totalRecordsFound
     */
    public function setTotalRecordsFound(int $totalRecordsFound): void
    {
        $this->totalRecordsFound = $totalRecordsFound;
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        if ($this->data) {
            return current($this->data);
        }

        return null;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }
}
