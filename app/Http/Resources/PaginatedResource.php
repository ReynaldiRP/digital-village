<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class PaginatedResource extends JsonResource
{
    /**
     * Create new resource instance
     * 
     * @param mixed $resource
     * @return void
     */
    public function __construct($resource, public $resourceClass = null)
    {
        parent::__construct($resource);
    }

    public function collect($resource)
    {
        if ($this->resourceClass) {
            return $this->resourceClass::collection($resource);
        }

        return $resource;
    }


    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return JsonSerializable
     */
    public function toArray(Request $request)
    {
        $items = method_exists($this->resource, 'items') ? $this->items() : $this->resource;
        // FIXME: fix the structure response in paginated 
        return [
            'data' => $this->collect($items),
            'meta' => [
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'path' => $this->path(),
                'per_page' => $this->perPage(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ],
        ];
    }
}
