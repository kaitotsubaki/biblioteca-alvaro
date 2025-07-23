<?php
session_start();
require 'funcoes.php';

$livros = carregarLivros();
$livro = null;

// Buscar livro pelo ID
if (isset($_GET['id'])) {
    foreach ($livros as $l) {
        if ($l['id'] === $_GET['id']) {
            $livro = $l;
            break;
        }
    }
}

// Se não encontrar, redireciona
if (!$livro) {
    $_SESSION['mensagem'] = 'Livro não encontrado!';
    $_SESSION['tipo'] = 'erro';
    header('Location: index.php');
    exit;
}

// Processar exclusão
if (isset($_POST['excluir'])) {
    try {
        // Remover arquivos
        if (file_exists(CAPAS_DIR . '/' . $livro['capa'])) {
            unlink(CAPAS_DIR . '/' . $livro['capa']);
        }
        if (file_exists(LIVROS_DIR . '/' . $livro['arquivo'])) {
            unlink(LIVROS_DIR . '/' . $livro['arquivo']);
        }
        
        // Remover do banco
        $novosLivros = array_filter($livros, function($l) use ($livro) {
            return $l['id'] !== $livro['id'];
        });
        
        salvarLivros($novosLivros);
        
        $_SESSION['mensagem'] = 'Livro excluído com sucesso!';
        $_SESSION['tipo'] = 'sucesso';
        
        header('Location: index.php');
        exit;
        
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($livro['titulo']) ?> - Biblioteca Virtual</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; }
        .livro-capa { float: left; margin-right: 30px; margin-bottom: 20px; }
        .livro-capa img { max-width: 250px; height: auto; box-shadow: 0 2px 10px rgba(0,0,0,0.2); }
        .livro-info { overflow: hidden; }
        .livro-info p { margin: 10px 0; }
        .livro-info strong { display: inline-block; width: 120px; }
        .btn { display: inline-block; padding: 8px 15px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; margin-top: 10px; }
        .btn-excluir { background: #e74c3c; }
        .btn-voltar { background: #7f8c8d; }
        .erro { color: #e74c3c; margin-top: 20px; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="container">
        <div class="livro-capa">
            <img src="capas/<?= htmlspecialchars($livro['capa']) ?>" alt="Capa do Livro">
        </div>
        
        <div class="livro-info">
            <h1><?= htmlspecialchars($livro['titulo']) ?></h1>
            <p><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
            <p><strong>Editora:</strong> <?= htmlspecialchars($livro['editora']) ?></p>
            <p><strong>Ano:</strong> <?= htmlspecialchars($livro['ano']) ?></p>
            <p><strong>Cadastrado em:</strong> <?= date('d/m/Y H:i', strtotime($livro['data_cadastro'])) ?></p>
            
            <?php if ($livro['descricao']): ?>
                <h3>Sinopse</h3>
                <p><?= nl2br(htmlspecialchars($livro['descricao'])) ?></p>
            <?php endif; ?>
            
            <a href="livros/<?= htmlspecialchars($livro['arquivo']) ?>" class="btn" download>Baixar Livro</a>
            <a href="index.php" class="btn btn-voltar">Voltar</a>
            
            <form method="post" style="margin-top: 20px;" onsubmit="return confirm('Tem certeza que deseja excluir este livro?');">
                <button type="submit" name="excluir" class="btn btn-excluir">Excluir Livro</button>
            </form>
            
            <?php if (isset($erro)): ?>
                <div class="erro"><?= $erro ?></div>
            <?php endif; ?>
        </div>
        
        <div class="clear"></div>
    </div>
</body>
</html>