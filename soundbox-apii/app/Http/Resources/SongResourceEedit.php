<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SongResourceEedit extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'file' => $this->file_path,
            'thumbnail' => $this->thumbnail,
            // 'singers' => $this->singers()->pluck('singer_id')->all(),
            // 'categories' => $this->categories()->pluck('category_id')->all(),
            'packet' => $this->packet,
            'singers' => $this->singers()->pluck('singer_id')->all(),
            'categories' => $this->categories()->pluck('category_id')->all(),
        ];
    }
}
