<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Informasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/logo.png') ?>">
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: #ffffff; /* Background putih */
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background: linear-gradient(135deg, #4e73df,rgb(166, 202, 240)); /* Gradasi warna biru */
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2);
            border-radius: 20px;
            color: #fff;
            text-align: center;
            padding: 40px 30px;
        }

        .login-container h3 {
            margin-bottom: 2rem;
            font-weight: bold;
            color: #ffffff;
        }

        .logo {
            width: 70px;
            height: 70px;
            margin-bottom: 15px;
        }

        .form-control {
            border-radius: 12px;
            padding: 14px;
            font-size: 15px;
            width: 100%;
            box-sizing: border-box;
        }

        .input-group-custom {
            margin-bottom: 20px;
        }

        .btn-login {
            background-color: #ffffff;
            color: #0056b3;
            border: 2px solid #007bff;
            padding: 12px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #007bff;
            color: #fff;
        }

        small.text-muted {
            display: block;
            margin-top: 1.5rem;
            color: #e0e0e0 !important;
        }
    </style>
</head>
<body>

<div class="login-container">
    <img src="<?= base_url('assets/img/logo.png') ?>" class="logo" alt="Logo">
    <h3>Login Admin</h3>

    <?php if ($this->session->flashdata('error')): ?>
        <p style="color: red; margin-bottom: 20px;">
            <?= $this->session->flashdata('error'); ?>
        </p>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
        <p style="color: green; margin-bottom: 20px;">
            <?= $this->session->flashdata('success'); ?>
        </p>
    <?php endif; ?>

    <form action="<?= base_url('auth/login') ?>" method="post">
        <div class="input-group-custom">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="input-group-custom">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="input-group-custom">
            <button type="submit" class="btn-login">Login</button>
        </div>
    </form>
</div>

</body>
</html>
