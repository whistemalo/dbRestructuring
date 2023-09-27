<?php

namespace App\Http\Resources\Request;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PendingRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'next_states'=> [[
                'id' => 1,
                'name' => 'Aprobar',
            ],[
                'id' => 2,
                'name' => 'Rechazar',
            ]
            ],
            'id_request_status' => $this->id_request_status,
            'project_code' => $this->project->code,
            'project' => $this->project->name,
            // forma la estructura para la relacion de uno a mucho de items
            'items' => $this->items->map(function ($item) {
                return [
                    'id' => $item->id_item,
                    'item'=> $item->item->name,
                    'quantity' => $item->quantity,
                    'measure_unit' => $item->measureUnit->name,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                    'specifications'=> $item->specifications, 
                    'justification'=> $item->justification, 
                    'next_states'=> [[
                        'id' => 1,
                        'name' => 'Aprobar',
                    ],[
                        'id' => 2,
                        'name' => 'Rechazar',
                    ]
                    ],
                ];
            }),



            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
