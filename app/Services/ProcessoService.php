<?php

namespace App\Services;

use App\Models\Processo;
use App\enums\ModalidadeEnum;

class ProcessoService
{
    /**
     * Cria um novo processo
     */
    public function create(array $data): Processo
    {
        // Converte a modalidade para enum caso necessário
        if (isset($data['modalidade']) && is_int($data['modalidade'])) {
            $data['modalidade'] = ModalidadeEnum::from($data['modalidade']);
        }

        return Processo::create($data);
    }

    /**
     * Atualiza um processo existente
     */
    public function update(Processo $processo, array $data): Processo
    {
        if (isset($data['modalidade']) && is_int($data['modalidade'])) {
            $data['modalidade'] = ModalidadeEnum::from($data['modalidade']);
        }

        $processo->update($data);

        return $processo;
    }

    /**
     * Remove um processo
     */
    public function delete(Processo $processo): bool
    {
        return $processo->delete();
    }
}
