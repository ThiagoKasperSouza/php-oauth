<div class="container-fluid">
    <h1>new</h1>
    <?php
       if (isset($_GET['path'])) {
        $conn = getConnection($_SESSION['host'], "meu_db", $_SESSION['user'], $_SESSION['pwd']);

        $query = "SELECT * FROM information_schema.columns WHERE table_name = $1;";
   
        // Preparar a consulta
        $stmt = pg_prepare($conn, "query_data", $query);
        if (!$stmt) {
            echo "Error preparing statement: " . pg_last_error($conn);
            exit;
        }
        // Executar a consulta com os valores
        $result = pg_execute($conn, "query_data",array($_GET['path']));
        if (!$result) {
            echo "Error executing statement: " . pg_last_error($conn);
            exit;
        }

    
        echo '<form class="p-4 p-md-5 border rounded-3 bg-body-tertiary" method="post">';
        while ($row = pg_fetch_assoc($result)) {
            if( htmlspecialchars($row['column_name']) != 'id') {
                $inputType = $row['column_name'] == 'email' ? 'email' : 'text';
                $placeholder = $row['column_name'] == 'email' ? 'email@example.com' : 'John Doe';
                echo '<div class="form-floating mb-3">
                    <input type="'.$inputType .'" class="form-control" name="'.htmlspecialchars($row['column_name']) . 'Input'.'" placeholder="'. $placeholder.'">
                    <label for="hostInput">'. htmlspecialchars($row['column_name']).'</label>
                </div>';
            }
  
        }
        echo '<button class="w-100 btn btn-lg btn-primary" type="submit" name="form_create">Create</button>
        <hr class="my-4">
        </form>';
    
        pg_close($conn);
    }
        
    ?>
</div>