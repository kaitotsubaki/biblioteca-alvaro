<?php
// Configurações iniciais
session_start();
define('BASE_DIR', __DIR__);
define('CAPAS_DIR', BASE_DIR . '/capas');
define('LIVROS_DIR', BASE_DIR . '/livros');
define('BANCO_FILE', BASE_DIR . '/banco.txt');

// Criar diretórios se não existirem
if (!file_exists(CAPAS_DIR)) mkdir(CAPAS_DIR, 0777, true);
if (!file_exists(LIVROS_DIR)) mkdir(LIVROS_DIR, 0777, true);
if (!file_exists(BANCO_FILE)) file_put_contents(BANCO_FILE, '[]');

// Função para carregar livros
function carregarLivros() {
    $conteudo = file_get_contents(BANCO_FILE);
    return $conteudo ? json_decode($conteudo, true) : [];
}

// Processar busca
$livros = carregarLivros();
$resultados = [];
$termoBusca = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($termoBusca) {
    foreach ($livros as $livro) {
        if (stripos($livro['titulo'], $termoBusca) !== false || 
            stripos($livro['autor'], $termoBusca) !== false) {
            $resultados[] = $livro;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca Virtual</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; }
        header { background: #2c3e50; color: white; padding: 20px; text-align: center; margin-bottom: 30px; }
        .busca { background: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .livro { background: white; padding: 15px; margin-bottom: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; }
        .livro img { width: 120px; height: 160px; object-fit: cover; margin-right: 20px; }
        .livro-info { flex: 1; }
        .btn { display: inline-block; padding: 8px 15px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; margin-top: 10px; }
        .btn-cadastro { background: #27ae60; }
        input[type="text"] { padding: 10px; width: 70%; border: 1px solid #ddd; border-radius: 4px; }
        button { padding: 10px 15px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .mensagem { padding: 10px; margin-bottom: 20px; border-radius: 4px; }
        .sucesso { background: #d4edda; color: #155724; }
        .erro { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Biblioteca Virtual</h1>
        </header>

        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="mensagem <?= $_SESSION['tipo'] ?>">
                <?= $_SESSION['mensagem'] ?>
            </div>
            <?php unset($_SESSION['mensagem']); unset($_SESSION['tipo']); ?>
        <?php endif; ?>

        <div class="busca">
            <form method="get">
                <input type="text" name="q" placeholder="Busque por título ou autor..." value="<?= htmlspecialchars($termoBusca) ?>">
                <button type="submit">Buscar</button>
            </form>
            <a href="cadastro.php" class="btn btn-cadastro">Cadastrar Novo Livro</a>
        </div>

        <?php if ($termoBusca && empty($resultados)): ?>
            <p>Nenhum livro encontrado para "<?= htmlspecialchars($termoBusca) ?>"</p>
        <?php elseif ($termoBusca): ?>
            <h2>Resultados para "<?= htmlspecialchars($termoBusca) ?>"</h2>
            <?php foreach ($resultados as $livro): ?>
                <div class="livro">
                    <img src="capas/<?= htmlspecialchars($livro['capa']) ?>" alt="Capa do Livro">
                    <div class="livro-info">
                        <h3><?= htmlspecialchars($livro['titulo']) ?></h3>
                        <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
                        <p><strong>Editora:</strong> <?= htmlspecialchars($livro['editora']) ?></p>
                        <a href="livro.php?id=<?= urlencode($livro['id']) ?>" class="btn">Ver Detalhes</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h2>Todos os Livros</h2>
            <?php if (empty($livros)): ?>
                <p>Nenhum livro cadastrado ainda.</p>
            <?php else: ?>
                <?php foreach ($livros as $livro): ?>
                    <div class="livro">
                        <img src="capas/<?= htmlspecialchars($livro['capa']) ?>" alt="Capa do Livro">
                        <div class="livro-info">
                            <h3><?= htmlspecialchars($livro['titulo']) ?></h3>
                            <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
                            <p><strong>Editora:</strong> <?= htmlspecialchars($livro['editora']) ?></p>
                            <a href="livro.php?id=<?= urlencode($livro['id']) ?>" class="btn">Ver Detalhes</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>