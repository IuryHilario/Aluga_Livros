<?php

namespace Tests\Unit;

use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UsuarioTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function pode_inserir_usuario()
    {
        $usuario = Usuario::create([
            'nome' => 'João da Silva',
            'email' => 'joao@email.com',
            'telefone' => '11999999999',
        ]);

        $this->assertDatabaseHas('usuario', [
            'email' => 'joao@email.com',
        ]);
    }
}
