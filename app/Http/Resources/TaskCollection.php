<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'pagination' => [                
                'per_page' => $this->count(),
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
                'has_more_pages' => $this->hasMorePages(),                
                'last_page' => $this->lastPage() ,
                'page_url' => $this->nextPageUrl(),
                'on_first_page' => $this->onFirstPage(),
                'per_page' => $this->perPage(),
                'previous_page' => $this->previousPageUrl(),
                'total' => $this->total(),                
            ],
        ];      
    }
}
