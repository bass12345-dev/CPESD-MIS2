<?php for ($i = 2023; $i <= 2050; $i++) {

    $selected = $i == date('Y') ? "selected" : "";

    echo '<option ' . $selected . '>' . $i . '</option>';

} ?>