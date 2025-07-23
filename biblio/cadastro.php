<?php
session_start();
require 'funcoes.php';

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validar e processar uploads
        $capa = processarUpload('capa', CAPAS_DIR, ['jpg', 'jpeg', 'png']);
        $arquivo = processarUpload('arquivo', LIVROS_DIR, ['pdf', 'epub', 'doc', 'docx']);
        
        // Criar ID único
        $id = uniqid();
        
        // Preparar dados do livro
        $livro = [
            'id' => $id,
            'titulo' => filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING),
            'autor' => filter_input(INPUT_POST, 'autor', FILTER_SANITIZE_STRING),
            'editora' => filter_input(INPUT_POST, 'editora', FILTER_SANITIZE_STRING),
            'ano' => filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_STRING),
            'descricao' => filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING),
            'capa' => $capa,
            'arquivo' => $arquivo,
            'data_cadastro' => date('Y-m-d H:i:s')
        ];
        
        // Salvar no banco
        $livros = carregarLivros();
        $livros[] = $livro;
        salvarLivros($livros);
        
        // Mensagem de sucesso
        $_SESSION['mensagem'] = 'Livro cadastrado com sucesso!';
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
    <title>Cadastrar Livro - Biblioteca Virtual</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #2c3e50; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        textarea { height: 100px; }
        button { background: #27ae60; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
        .erro { color: #e74c3c; margin-top: 5px; }
        .voltar { display: inline-block; margin-top: 20px; color: #3498db; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastrar Novo Livro</h1>
        
        <?php if (isset($erro)): ?>
            <div style="color: red; margin-bottom: 20px;"><?= $erro ?></div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título *</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            
            <div class="form-group">
                <label for="autor">Autor *</label>
                <input type="text" id="autor" name="autor" required>
            </div>
            
            <div class="form-group">
                <label for="editora">Editora *</label>
                <input type="text" id="editora" name="editora" required>
            </div>
            
            <div class="form-group">
                <label for="ano">Ano de Publicação *</label>
                <input type="text" id="ano" name="ano" required>
            </div>
            
            <div class="form-group">
                <label for="descricao">Descrição/Sinopse</label>
                <textarea id="descricao" name="descricao"></textarea>
            </div>
            
            <div class="form-group">
                <label for="capa">Capa do Livro (JPG/PNG) *</label>
                <input type="file" id="capa" name="capa" accept="image/jpeg,image/png" required>
            </div>
            
            <div class="form-group">
                <label for="arquivo">Arquivo do Livro (PDF/EPUB) *</label>
                <input type="file" id="arquivo" name="arquivo" accept=".pdf,.epub,.doc,.docx" required>
            </div>
            
            <button type="submit">Cadastrar Livro</button>
        </form>
        
        <a href="index.php" class="voltar">← Voltar para a lista</a>
    </div>
</body>
</html>