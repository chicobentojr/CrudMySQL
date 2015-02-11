<?php
    require_once 'config/conexao.class.php';
    require_once 'config/crud.class.php';

    $con = new conexao(); // instancia classe de conxao
    $con->connect(); // abre conexao com o banco
    @$getId = $_GET['id'];  //pega id para edi�ao caso exista
    if(@$getId){ //se existir recupera os dados e tras os campos preenchidos
        $consulta = mysql_query("SELECT * FROM produto WHERE id = + $getId");
        $campo = mysql_fetch_array($consulta);
    }
    
    if(isset ($_POST['cadastrar'])){  // caso nao seja passado o id via GET cadastra 
        $nome = $_POST['nome'];  //pega o elemento com o pelo NAME 
        $descricao = $_POST['descricao']; //pega o elemento com o pelo NAME 
        $crud = new crud('produto');  // instancia classe com as opera�oes crud, passando o nome da tabela como parametro
        $crud->inserir("nome,descricao", "'$nome','$descricao'"); // utiliza a fun�ao INSERIR da classe crud
        header("Location: index.php"); // redireciona para a listagem
    }

    if(isset ($_POST['editar'])){ // caso  seja passado o id via GET edita 
        $nome = $_POST['nome']; //pega o elemento com o pelo NAME
        $descricao = $_POST['descricao']; //pega o elemento com o pelo NAME
        $crud = new crud('produto'); // instancia classe com as opera�oes crud, passando o nome da tabela como parametro
        $crud->atualizar("nome='$nome',descricao='$descricao'", "id='$getId'"); // utiliza a fun�ao ATUALIZAR da classe crud
        header("Location: index.php"); // redireciona para a listagem
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action="" method="post"><!--   formulario carrega a si mesmo com o action vazio  -->
            
            <label>Nome:</label>
            <input type="text" name="nome" value="<?php echo @$campo['nome']; // trazendo campo preenchido caso esteja no modo de edi�ao ?>" />
            <br />
            <br />
            <label>Descri&ccedil;&atilde;o:</label>
            <input type="text" name="descricao" value="<?php echo @$campo['descricao']; // trazendo campo preenchido caso esteja no modo de edi�ao ?>" />
            <br />
            <br />
            <?php
                if(@!$campo['id']){ // se nao passar o id via GET nao est� editando, mostra o botao de cadastro
            ?>
                <input type="submit" name="cadastrar" value="Cadastrar" />
            <?php }else{ // se  passar o id via GET  est� editando, mostra o botao de edi�ao ?>
                <input type="submit" name="editar" value="Editar" />    
            <?php } ?>
        </form>
    </body>
</html>
<?php $con->disconnect(); // fecha conexao com o banco ?>