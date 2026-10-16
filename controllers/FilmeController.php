<?php
class FilmeController
{
    private $model;

    public function __construct()
    {
        $this->model = new Filme();
    }

    public function index()
    {
        $filmes = $this->model->listar();
        require __DIR__ . '/../views/filmes/index.php';
    }

    public function adicionar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filme = filter_input(INPUT_POST, 'filme', FILTER_SANITIZE_SPECIAL_CHARS);
            $diretor = filter_input(INPUT_POST, 'diretor', FILTER_SANITIZE_SPECIAL_CHARS);
            $duracao = filter_input(INPUT_POST, 'duracao', FILTER_VALIDATE_INT);
            $imagem = filter_input(INPUT_POST, 'imagem', FILTER_SANITIZE_SPECIAL_CHARS);

            if ($filme && $diretor) {
                $this->model->salvar($filme, $diretor, $duracao, $imagem);
                header('Location: /lp3_projeto/filmes');
                exit();
            }
        }

        require __DIR__ . '/../views/filmes/criar.php';
    }

    public function editar()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /lp3_projeto/filmes');
            exit;
        }

        // Verifica se house post e faz a gravação dos dados no banco
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filme = filter_input(INPUT_POST, 'filme', FILTER_SANITIZE_SPECIAL_CHARS);
            $diretor = filter_input(INPUT_POST, 'diretor', FILTER_SANITIZE_SPECIAL_CHARS);
            $duracao = filter_input(INPUT_POST, 'duracao', FILTER_VALIDATE_INT);
            $imagem = filter_input(INPUT_POST, 'imagem', FILTER_SANITIZE_SPECIAL_CHARS);
           

            if ($filme && $diretor ) {
                $this->model->atualizar($id, $filme, $diretor, $duracao, $imagem);
                header('Location: /lp3_projeto/filmes');
                exit;
            }
        }

        // Busca dados do filme selecionado e carrega tela com os dados
        $filme = $this->model->buscarPorId($id);

        if (!$filme) {
            header('Location: /lp3_projeto/filmes');
            exit;
        }

        require __DIR__ . '/../views/filmes/editar.php';
    }

    public function excluir()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            $this->model->excluir($id);
        }

        header('Location: /lp3_projeto/filmes');
        exit;

    }
}

?>