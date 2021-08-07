<?php

namespace App\Http\Resources;

use App\Models\Colleague;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @property-read Collection<Colleague> $resource
 */
class ColleagueCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return $this->resource->map(function (Colleague $colleague) {
            return [
                'id'    => $colleague->id,
                'name'  => $colleague->name,
                'email' => $colleague->email,
            ];
        })->toArray();
    }
}
