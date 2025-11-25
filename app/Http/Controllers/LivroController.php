<?php

namespace App\Http\Controllers;

use App\Http\Requests\LivroRequest;
use App\Models\Livro;
use Illuminate\Http\Request;
use App\Models\Settings;

class LivroController extends Controller
{
    public function index(Request $request)
    {
        $query = Livro::query();
        $settings = Settings::getAllSettings();

        // Aplicar filtros
        if ($request->filled('titulo')) {
            $query->where('titulo', 'LIKE', '%' . $request->titulo . '%');
        }

        if ($request->filled('autor')) {
            $query->where('autor', 'LIKE', '%' . $request->autor . '%');
        }

        if ($request->filled('editor')) {
            $query->where('editor', 'LIKE', '%' . $request->editor . '%');
        }

        if ($request->filled('ano_publicacao')) {
            $query->where('ano_publicacao', $request->ano_publicacao);
        }

        $query->orderBy('id_livro', 'DESC');

        $livros = $query->paginate($settings['items_per_page'])->withQueryString();

        return view('books.index', compact('livros'));
    }
    
    public function show($id)
    {
        $livro = Livro::with(['alugueis.usuario'])->findOrFail($id);
        return view('books.show', compact('livro'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(LivroRequest $request)
    {
        $dados = $request->all();

        if ($request->hasFile('capa')) {
            $capa = $request->file('capa');
            $dados['capa'] = file_get_contents($capa->getRealPath());
        }

        Livro::create($dados);

        return redirect()->route('books.index')
            ->with('success', 'Livro cadastrado com sucesso!');
    }


    public function edit($id)
    {
        $livro = Livro::findOrFail($id);
        return view('books.edit', compact('livro'));
    }

    public function update(LivroRequest $request, $id)
    {
        $livro = Livro::findOrFail($id);
        $dados = $request->except('capa');

        if ($request->hasFile('capa')) {
            $capa = $request->file('capa');
            $dados['capa'] = file_get_contents($capa->getRealPath());
        }

        $livro->update($dados);

        return redirect()->route('books.index')
            ->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $livro = Livro::findOrFail($id);
        $livro->delete();

        return redirect()->route('books.index')
            ->with('success', 'Livro removido com sucesso!');
    }

    public function getCapa($id)
    {
        $livro = Livro::findOrFail($id);

        if (!$livro->capa) {
            abort(404);
        }

        return response($livro->capa)
            ->header('Content-Type', 'image/jpeg');
    }

    public function categories()
    {
        // Get distinct editors from the books
        $editores = Livro::distinct()->pluck('editor')->filter();
        return view('books.categories', compact('editores'));
    }
}