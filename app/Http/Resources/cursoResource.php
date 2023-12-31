<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\cursoEstudiantesResource;

class cursoResource extends JsonResource
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
            'horario' => $this->horario,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,            
            'created_at' => $this->created_at,           
            'updated_at' => $this->updated_at,        
            'estudiante_curso' => cursoEstudiantesResource::collection($this->estudiante_curso),
        ];
    }
}
