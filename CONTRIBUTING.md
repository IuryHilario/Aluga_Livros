# Guia de Contribuição

Obrigado por considerar contribuir com o projeto Aluga Livros! 🎉

## Como Contribuir

### 1. Fork e Clone

```bash
# Fork o repositório através da interface do GitHub
# Clone o seu fork
git clone https://github.com/SEU_USUARIO/Aluga_Livros.git
cd Aluga_Livros
```

### 2. Configure o Ambiente

```bash
# Instale as dependências
composer install
npm install

# Configure o ambiente
cp .env.example .env
php artisan key:generate

# Execute as migrações
php artisan migrate --seed
```

### 3. Crie uma Branch

```bash
# Crie uma branch para sua feature ou correção
git checkout -b feature/nova-funcionalidade
# ou
git checkout -b fix/correcao-bug
```

### 4. Desenvolva e Teste

#### Execute os testes frequentemente:

```bash
php artisan test
```

#### Verifique o estilo do código:

```bash
# Verificar estilo
./vendor/bin/pint --test

# Corrigir automaticamente
./vendor/bin/pint
```

### 5. Faça Commits Significativos

Use mensagens de commit claras e descritivas:

```bash
git commit -m "Adiciona validação de e-mail duplicado no cadastro de usuário"
```

**Boas práticas para mensagens de commit:**
- Use o imperativo ("Adiciona" em vez de "Adicionado")
- Seja específico sobre o que foi alterado
- Referencie issues quando aplicável (ex: "Corrige #123")

### 6. Envie um Pull Request

```bash
git push origin feature/nova-funcionalidade
```

Depois, abra um Pull Request no GitHub com:
- **Título claro**: Descreva brevemente a mudança
- **Descrição detalhada**: Explique o que foi alterado e por quê
- **Screenshots**: Se aplicável, adicione imagens das alterações visuais

## Padrões de Código

### PHP

- Seguimos o padrão **PSR-12**
- Use o **Laravel Pint** para formatar o código
- Evite código duplicado
- Mantenha métodos pequenos e focados

### Testes

- Escreva testes para novas funcionalidades
- Use atributos PHP para testes: `#[Test]`
- Mantenha os testes simples e legíveis
- Organize testes em: `tests/Unit/` e `tests/Feature/`

### Banco de Dados

- Sempre crie migrações para alterações de schema
- Use seeders para dados de teste
- Nunca modifique migrações já enviadas ao repositório

## Processo de Revisão

1. **Automático**: CI verifica testes e estilo de código
2. **Manual**: Revisor analisa a lógica e qualidade do código
3. **Feedback**: Pode haver solicitações de mudanças
4. **Merge**: Após aprovação, o PR será mesclado

## Reportando Bugs

Ao reportar um bug, inclua:
- **Descrição clara** do problema
- **Passos para reproduzir** o erro
- **Comportamento esperado** vs **comportamento atual**
- **Versão do PHP e Laravel**
- **Logs de erro**, se disponíveis

## Sugerindo Melhorias

Para sugerir novas funcionalidades:
- Abra uma issue descrevendo a funcionalidade
- Explique o caso de uso
- Discuta a implementação antes de começar a codificar

## Código de Conduta

- Seja respeitoso com outros contribuidores
- Aceite feedback construtivo
- Foque no que é melhor para o projeto
- Seja paciente com novos contribuidores

## Dúvidas?

Se tiver dúvidas sobre como contribuir:
- Abra uma issue com a tag `question`
- Entre em contato: iuryhilario.dev@gmail.com

Obrigado pela sua contribuição! 💚
