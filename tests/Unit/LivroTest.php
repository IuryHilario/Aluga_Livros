<?php

namespace Tests\Unit;

use App\Models\Livro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LivroTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function pode_inserir_livro()
    {
        $livro = Livro::create([
            'titulo' => 'Livro de Teste',
            'autor' => 'Autor Exemplo',
            'editor' => 'Editora ABC',
            'ano_publicacao' => 2024,
            'quantidade' => 5,
        ]);

        $this->assertDatabaseHas('livro', [
            'titulo' => 'Livro de Teste',
        ]);
    }
}
