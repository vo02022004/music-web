<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SongResourceShow extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // $commentsResource = [];
        // foreach ($comments as  $comment) {
        //     $commentsResource = [...$commentsResource, (object)['user_name' => $comment->user->name, 'content' => $comment->content]];
        // }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'file_path' => $this->file_path,
            'total_time' => $this->total_time,
            'thumbnail' => $this->thumbnail,
            'listens' => $this->listens,
            'packet' => $this->packet,
            'singers' => $this->singers()->get(['name', 'singer_id']),
            'categories' => $this->categories()->get(['name', 'category_id']),
            'comments' => CommentResource::collection($this->comments->sortByDesc('created_at'))
        ];
    }
}
