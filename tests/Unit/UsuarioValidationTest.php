<?php

namespace Tests\Unit;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UsuarioValidationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function nao_permite_email_duplicado()
    {
        Usuario::create([
            'nome' => 'Usuário 1',
            'email' => 'email@teste.com',
            'telefone' => '111111111',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Usuario::create([
            'nome' => 'Usuário 2',
            'email' => 'email@teste.com',
            'telefone' => '222222222',
        ]);
    }

    #[Test]
    public function valida_campos_obrigatorios_usuario()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        Usuario::create([
            'email' => 'semnome@teste.com',
        ]);
    }
}
