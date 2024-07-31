<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'trancation_id' => $this->transaction_id,
            'product' => $this->product->name,
            'category' => $this->product->category->name,
            'price' => $this->product->price,
            'status' => $this->payment_status,
            'created_at' => Carbon::parse($this->created_at)->format('d M Y H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d M Y H:i:s')
        ];
    }
}
