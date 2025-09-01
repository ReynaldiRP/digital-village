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
        // FIXME: fix the structure response in paginated 
        return [
            'items' => $this->collect($this->items()),
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
