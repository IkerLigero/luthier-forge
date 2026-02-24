<?php
session_start();
$conn = new mysqli("localhost", "root", "", "luthier_forge");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM Usuario WHERE email='$email' AND id_rol=2";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();

        if ($password == $usuario["contraseña_hash"]) { // temporal
            $_SESSION["admin"] = $usuario["id_usuario"];
            header("Location: admin_inicio.php");
            exit();
        }
    }
}
?>

<h2>Login Admin</h2>
<form method="POST">
    Email: <input type="text" name="email"><br><br>
    Password: <input type="password" name="password"><br><br>
    <button type="submit">Entrar</button>
</form>