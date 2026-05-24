<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class AntrianResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'poli' => $this->poli,
            'no_antrian' => $this->no_antrian,
            'nama' => $this->nama,
            'no_ktp' => $this->no_ktp,
            'alamat' => $this->alamat,
            'jenis_kelamin' => $this->jenis_kelamin,
            'no_hp' => $this->no_hp,
            'tgl_lahir' => $this->tgl_lahir,
            'pekerjaan' => $this->pekerjaan,
            'tanggal_daftar' => $this->tanggal_daftar?->toDateString(),
            'status' => $this->status,
            'diagnosa' => $this->whenPivotLoaded('diagnosa', $this->diagnosa),
            'catatan_dokter' => $this->catatan_dokter,
            'dokter' => $this->whenLoaded('dokter', fn () => new UserResource($this->dokter)),
            'user' => $this->whenLoaded('user', fn () => new UserResource($this->user)),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}