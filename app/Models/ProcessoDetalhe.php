<?php

namespace App\Models;

use App\Enums\TipoContratacaoEnum;
use App\Enums\TipoProcedimentoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessoDetalhe extends Model
{
    use HasFactory;

    protected $table = 'processo_detalhes';

    protected $fillable = [
        'processo_id',
        'secretaria',
        'unidade_setor',
        'servidor_responsavel',
        'demanda',
        'justificativa',
        'prazo_entrega',
        'local_entrega',
        'contratacoes_anteriores',
        'fiscais',
        'gestor',
        'instrumento_vinculativo',
        'instrumento_vinculativo_outro',
        'prazo_vigencia',
        'prazo_vigencia_outro',
        'objeto_continuado',
        'itens_e_seus_quantitativos_xml',
        'nome_equipe_planejamento',
        'responsavel_equipe_planejamento',
        'descricao_necessidade',
        'alinhamento_planejamento_anual',
        'problema_resolvido',
        'inversao_fase',
        'descricao_necessidade_autorizacao',
        'solucoes_disponivel_mercado',
        'incluir_requisito_cada_caso_concreto',
        'solucao_escolhida',
        'justificativa_solucao_escolhida',
        'impacto_ambiental',
        'tipo_srp',
        'prevista_plano_anual',
        'encaminhamento_pesquisa_preco',
        'encaminhamento_doacao_orcamentaria',
        'painel_preco_tce',
        'anexo_pdf_analise_mercado',

        'encaminhamento_elaborar_editais',
        'encaminhamento_parecer_juridico',
        'encaminhamento_autorizacao_abertura',
        'valor_estimado',
        'portaria_agente_equipe_pdf',
        'dotacao_orcamentaria',
        'anexar_minuta'
    ];

    protected $casts = [
        'instrumento_vinculativo' => 'array',
        'prazo_vigencia' => 'array',
        'itens_e_seus_quantitativos_xml' => 'array',
    ];

    /**
     * Relação com Processo
     */
    public function processo()
    {
        return $this->belongsTo(Processo::class);
    }
}
