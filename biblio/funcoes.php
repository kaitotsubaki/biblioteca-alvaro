<?php
// Configurações
define('BASE_DIR', __DIR__);
define('CAPAS_DIR', BASE_DIR . '/capas');
define('LIVROS_DIR', BASE_DIR . '/livros');
define('BANCO_FILE', BASE_DIR . '/banco.txt');

// Carregar livros do banco
function carregarLivros() {
    if (!file_exists(BANCO_FILE)) {
        file_put_contents(BANCO_FILE, '[]');
        return [];
    }
    
    $conteudo = file_get_contents(BANCO_FILE);
    if (empty($conteudo)) return [];
    
    $livros = json_decode($conteudo, true);
    return is_array($livros) ? $livros : [];
}

// Salvar livros no banco
function salvarLivros($livros) {
    file_put_contents(BANCO_FILE, json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Processar upload de arquivo
function processarUpload($campo, $pastaDestino, $extensoesPermitidas = []) {
    if (!isset($_FILES[$campo]) || $_FILES[$campo]['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Erro no upload do arquivo $campo");
    }
    
    $arquivo = $_FILES[$campo];
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    
    // Verificar extensão
    if (!empty($extensoesPermitidas) && !in_array($extensao, $extensoesPermitidas)) {
        throw new Exception("Tipo de arquivo não permitido para $campo. Use: " . implode(', ', $extensoesPermitidas));
    }
    
    // Verificar tamanho (máximo 5MB)
    if ($arquivo['size'] > 5000000) {
        throw new Exception("Arquivo $campo muito grande (máximo 5MB)");
    }
    
    // Criar nome único
    $nomeArquivo = uniqid() . '.' . $extensao;
    $caminhoDestino = $pastaDestino . '/' . $nomeArquivo;
    
    // Mover arquivo
    if (!move_uploaded_file($arquivo['tmp_name'], $caminhoDestino)) {
        throw new Exception("Erro ao salvar arquivo $campo");
    }
    
    return $nomeArquivo;
}