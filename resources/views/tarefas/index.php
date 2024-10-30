<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}

ob_start(); // Inicia o buffer de saída
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo BASE_URL ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tarefas</li>
  </ol>
</nav>

<h2>Lista de Tarefas</h2>

<div class="row">
    <div class="col-md-6">
        <a class="btn btn-success" href="/tarefas/create"><i class="fa fa-plus fa-fw"></i> Criar Nova Tarefa</a>
    </div>
    <div class="col-md-6">
        <form method="GET" action="/tarefas/index">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Pesquisar tarefas por título ou descrição..." value="<?php echo htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES); ?>">
                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Pesquisar</button>
            </div>
            <div class="text-end">
                <a href="/tarefas/index"><small>Limpar Pesquisa</small></a>
            </div>
        </form>
    </div>
</div>

<table class="table table-striped table-bordered table-sm mt-3">
    <thead>
        <th width="70" class="text-center">ID</th>
        <th>Título</th>
        <th>Descrição</th>
        <th>Status</th>
        <th width="130" class="text-center">Ações</th>
    </thead>
    <tbody>
    <?php if (empty($data['tarefas'])): ?>
    <tr>
        <td colspan="5" class="text-center">Nenhum registro encontrado.</td>
    </tr>
        <?php else: ?>
            <?php foreach ($data['tarefas'] as $tarefa): ?>
                <tr>
                    <td class="text-center"><?php echo $tarefa['id']; ?></td>
                    <td><?php echo $tarefa['titulo']; ?></td>
                    <td><?php echo $tarefa['descricao']; ?></td>
                    <td>
                        <?php if ($tarefa['status'] == 'pendente'): ?>
                            <span class="badge bg-danger">Pendente</span>
                        <?php else: ?>
                            <span class="badge bg-success">Concluído</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-warning btn-sm" href="/tarefas/edit/<?php echo $tarefa['id']; ?>"><i class="fa fa-pencil"></i></a>
                        <a class="btn btn-danger btn-sm" href="/tarefas/delete/<?php echo $tarefa['id']; ?>"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<div class="row">
    <div class="col-md-4">
        Mostrando de <?php echo $start; ?> até <?php echo $end; ?> de <?php echo $totalTarefas; ?> registros
    </div>
    <div class="col-md-8">
        <?php if ($totalPages > 1): ?>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&search=<?php echo htmlspecialchars($search, ENT_QUOTES); ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search, ENT_QUOTES); ?>">
                        <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&search=<?php echo htmlspecialchars($search, ENT_QUOTES); ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>



<?php
$content = ob_get_clean(); // Obtém o conteúdo do buffer e limpa o buffer
$title = 'Lista de Tarefas';
require __DIR__ . '/../layouts/main.php'; // Inclui o layout mestre
