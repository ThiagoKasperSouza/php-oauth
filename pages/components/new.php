<div class="container-fluid p-4">
    <?php
       if (isset($_GET['path'])) {
        echo "<h1>" .$_GET['path'].": new</h1>";
        
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

    
        echo '<form class="p-4 p-md-5 border rounded-3 bg-body-tertiary needs-validation form_create" novalidate method="post">';
        while ($row = pg_fetch_assoc($result)) {
            if( htmlspecialchars($row['column_name']) != 'id') {
                $inputType = $row['column_name'] == 'email' ? 'email' : 'text';
                $placeholder = $row['column_name'] == 'email' ? 'email@example.com' : 'John Doe';


                echo '<div>
                    <label for="validationCustomUsername" class="form-label">'.htmlspecialchars($row['column_name']).'</label>
                    <div class="input-group has-validation">
                    <input type="'.$inputType.'" class="form-control"  name="'.htmlspecialchars($row['column_name']) . 'Input'.'" id="validationCustom'.htmlspecialchars($row['column_name']).'" aria-describedby="inputGroupPrepend" placeholder="'. $placeholder.'" required>
                    <div class="invalid-feedback">
                        Please fill your '.htmlspecialchars($row['column_name']). '
                    </div>
                    </div>
                </div><br>';

                // echo '<div class="form-floating mb-3">
                //     <input type="'.$inputType .'" class="form-control" name="'.htmlspecialchars($row['column_name']) . 'Input'.'" placeholder="'. $placeholder.'">
                //     <label for="hostInput">'. htmlspecialchars($row['column_name']).'</label>
                // </div>';
            }
  
        }
        echo '<button class="btn w-100 btn-primary" type="submit" name="form_create">Create</button>
        <hr class="my-4">
        </form>';
    
        pg_close($conn);
    }
        
    ?>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
<style>
    .form_create {
        width: 50%;
    }
    @media (max-width: 480px) {
        .form_create {
         width: 100%;
        }
    }

</style>

</div>