<?php

namespace Framework\Http\Template;

class Paginator extends \Illuminate\Pagination\Paginator
{
    public function __construct($query, $perPage, $currentPage = null, array $options = [])
    {
        $this->perPage = $perPage;
        $this->currentPage = $this->setCurrentPage($currentPage);
        $this->path = $this->path !== '/' ? rtrim($this->path, '/') : $this->path;
        
        $this->setItems($query);
    }
    
    protected function setItems($query)
    {
        $count = $query->count();

        $this->hasMore = $count > ($this->perPage * $this->currentPage);

        $query = $query->limit($this->perPage)->offset($this->perPage * ($this->currentPage - 1));
        
        $this->items = $query->get();
        
    }
}
