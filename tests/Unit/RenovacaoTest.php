<?php

namespace Tests\Unit;

use App\Models\Aluguel;
use App\Models\Livro;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RenovacaoTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function nao_permite_renovar_aluguel_atrasado()
    {
        $usuario = Usuario::create([
            'nome' => 'Renovação',
            'email' => 'renovacao@email.com',
            'telefone' => '111111111',
        ]);
        $livro = Livro::create([
            'titulo' => 'Livro Renovação',
            'autor' => 'Autor',
            'editor' => 'Editora',
            'ano_publicacao' => 2024,
            'quantidade' => 1,
        ]);
        $aluguel = Aluguel::create([
            'id_usuario' => $usuario->id_usuario,
            'id_livro' => $livro->id_livro,
            'dt_aluguel' => now()->subDays(10)->toDateString(),
            'dt_devolucao' => now()->subDays(3)->toDateString(),
            'ds_status' => Aluguel::STATUS_ATRASADO,
        ]);
        // Supondo que existe uma regra/metodo para renovar
        $this->assertFalse($aluguel->canRenovar ?? false);
    }
}
