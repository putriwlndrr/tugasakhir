<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <!-- Tabler CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <!-- Custom fonts -->
    <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">

    <style>
        /* Warna teks default untuk menu */
        .navbar-nav .nav-item .nav-link {
            color: black;
        }

        /* Warna teks saat hover */
        .navbar-nav .nav-item .nav-link:hover {
            color: #007bff;
        }

        /* Flexbox Setup */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #wrapper {
            display: flex;
            flex: 1;
        }

        /* Sidebar Adjustment */
        #sidebarHorizontal {
            min-width: 250px;
            z-index: 100;
            position: fixed;
        }

        #content-wrapper {
            flex: 1;
            margin-left: 250px;
            padding: 30px 20px;
            background-color: #f8f9fa;
            overflow: auto;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            #content-wrapper {
                margin-left: 0;
            }

            .navbar-collapse {
                display: none;
            }

            .navbar-toggler {
                display: block;
            }
        }

        /* Navbar Styling */
        .navbar {
            z-index: 1050;
        }

        /* Box layout for the content */
        .container-box {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Page title styling */
        .judul-halaman {
            font-family: 'Arial Rounded MT Bold', 'Segoe UI', sans-serif;
            font-weight: 700;
            color: #2c3e50;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        /* Button Group Styling */
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-group button {
            flex: 0 1 200px;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            text-align: center;
        }

        /* Button Styling */
        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

  

    <!-- Tabler JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
</body>

</html>
