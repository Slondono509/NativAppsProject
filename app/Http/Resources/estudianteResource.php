<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\estudianteCursosResource;

class estudianteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,          
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'edad' => $this->edad,
            'email' => $this->email,           
            'created_at' => $this->created_at,           
            'updated_at' => $this->updated_at,           
            'updated_at' => $this->updated_at,           
            'estudiante_curso' => estudianteCursosResource::collection($this->estudiante_curso),
        ];
    }
}
