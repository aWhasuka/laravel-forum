<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data =  parent::toArray($request);

        // whenLoaded 判断是否预加载 user 和 category 如果有，则使用对应的 Resource 处理并返回数据。
        $data['user'] = new UserResource($this->whenLoaded('user'));
        $data['category'] = new CategoryResource($this->whenLoaded('category'));

        return $data;
    }
}
