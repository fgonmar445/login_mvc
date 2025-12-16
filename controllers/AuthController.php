<?php
// controllers/AuthController.php

class AuthController
{
    private $userModel;

    public function __construct()
    {
        // Crear el modelo Usuario
        $this->userModel = new Usuario();
    }

    public function login()
    {
        // Cargar la vista del formulario de login
        include 'views/login.php';
    }

    public function authenticate()
    {
        /******************************************************
         * SOLO ACEPTAR PETICIONES POST
         ******************************************************/
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = "Debes hacer login para acceder.";
            header("Location: index.php?action=login");
            exit();
        }

        /******************************************************
         * CONTROL DE INTENTOS FALLIDOS
         ******************************************************/
        if (!isset($_SESSION['login_attempts'])) {
            $_SESSION['login_attempts'] = 0;
        }

        $max_attempts = 5;

        if ($_SESSION['login_attempts'] >= $max_attempts) {
            $_SESSION['error'] = "Has superado el número máximo de intentos. Inténtalo más tarde.";
            header("Location: index.php?action=login");
            exit();
        }

        /******************************************************
         * VALIDACIÓN CSRF
         ******************************************************/
        if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token'])) {
            die("Solicitud no válida. Token CSRF ausente.");
        }

        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Solicitud no válida. Token CSRF incorrecto.");
        }

        /******************************************************
         * RECOGER DATOS DEL FORMULARIO
         ******************************************************/
        $username = trim($_POST['user'] ?? '');
        $password = trim($_POST['pass'] ?? '');

        if ($username === '' || $password === '') {
            $_SESSION['error'] = "Debes rellenar todos los campos.";
            header("Location: index.php?action=login");
            exit();
        }

        /******************************************************
         * AUTENTICACIÓN USANDO TU MÉTODO login()
         ******************************************************/
        if ($this->userModel->login($username, $password)) {

            // Autenticación exitosa
            $_SESSION['idusuario'] = $username;
            $_SESSION['usuario_logueado'] = true;

            // Regenerar ID para evitar fijación de sesión
            session_regenerate_id(true);

            header('Location: index.php?action=dashboard');
            exit();
        } else {

            // Autenticación fallida
            $_SESSION['login_attempts']++;
            $_SESSION['error'] = "Usuario o contraseña incorrectos.";

            header("Location: index.php?action=login");
            exit();
        }
    }

    public function dashboard()
    {
        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['idusuario'])) {
            $_SESSION['error'] = "Debes iniciar sesión.";
            header('Location: index.php?action=login');
            exit();
        }

        include 'views/dashboard.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: index.php?action=login');
        exit();
    }
}
