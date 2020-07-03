<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'price'=>$this->price,
            'is_new'=>$this->is_new,
            'discount'=>$this->discount,
            'size'=>$this->size,
            'color'=>$this->color,
            'category_id'=>$this->category_id,
            'child_category'=>$this->child_category,
            'image1'=>$this->when($this->image1 != null, $this->image1 ),
            'image2'=>$this->when($this->image2 != null, $this->image2 ),
            'image3'=>$this->when($this->image3 != null, $this->image3 ),
            'image4'=>$this->when($this->image4 != null, $this->image4 ),
            ];
    }
}
