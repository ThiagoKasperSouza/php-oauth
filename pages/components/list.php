
<div class="container-fluid" style="padding: 2em">
    <?php 
        if(isset($_GET['path'])) {
            echo  '<h1>'.$_GET['path']. ' list</h1>';
            $conn =getConnection($_SESSION['host'], "meu_db", $_SESSION['user'], $_SESSION['pwd']);
            // Escapar o nome da tabela para evitar SQL Injection
            $tableName = pg_escape_identifier($conn,$_GET['path']);

            // Executar a consulta
            $result = pg_query($conn, "SELECT * FROM " . $tableName);

            if (!$result) {
                echo "Erro ao executar a consulta: " . pg_last_error($conn);
                exit;
            }
           // Iniciar a tabela HTML
            echo '
            <table class="table-bordered">
            <thead>
                <tr>
                <th class="col-md-1" scope="col">ID</th>
                <th class="col-md-2" scope="col">Name</th>
                <th class="col-md-5" scope="col">Email</th>
                </tr>
            </thead>
            <tbody>';


            // Exibir os resultados

            while ($row = pg_fetch_assoc($result)) {

                echo '<tr>
                    <td scope="row" style="padding: 0.5em" >' . htmlspecialchars($row['id']) . '</td>
                    <td scope="row" style="padding: 0.5em" >' . htmlspecialchars($row['name']) . '</td>
                    <td scope="row" style="padding: 0.5em" >' . htmlspecialchars($row['email']) . '</td>
                </tr>';

            }
            echo '</tbody>
            </table>';

            // Fechar a conexão
            pg_close($conn);
        }
    

    
    ?>
</div>
