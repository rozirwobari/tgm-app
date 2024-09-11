<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/111b8c6336.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=SUSE:wght@100..800&display=swap');

        * {
            font-family: "SUSE", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }

        .canvas {
            width: 100%;
            margin: auto;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('<?= base_url('asset/img/loginbkg.png') ?>');
            background-size: cover;
            background-position: center;
        }

        .rzw-box-login {
            width: 100%;
            padding: 20px;
            justify-content: center;
            text-align: center;
            background-color: #f9f9f9;
            border-radius: 20px;
            margin: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .rzw-icon-input {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px;
            z-index: 999;
        }

        .rzw-input {
            padding-left: 40px;
            border-color: #00b4cd;
            border-radius: 10px !important;
            height: 50px;
            /* Tidak ada perubahan tinggi input */
        }

        .rzw-btn {
            background-color: #00b4cd;
            border: none;
            border-radius: 10px;
            height: 46px;
        }
    </style>
</head>

<body>
    <div class="canvas">
    <?= $this->renderSection('content') ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php
        if (session('alert') && session('alert')['type']) {
    ?>
        <script>
        Swal.fire({
            title: "<?= session('alert')['title'] ?>",
            text: "<?= session('alert')['message'] ?>",
            icon: "<?= session('alert')['type'] ?>"
        });
        </script>
    <?php
        }
    ?>
</body>

</html>