<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=SUSE:wght@100..800&display=swap');

    * {
        font-family: "SUSE", sans-serif;
        font-optical-sizing: auto;
        font-weight: 500;
        font-style: normal;
        user-select: none;
    }

    .canvas {
        width: 100%;
        margin: 0;
        padding: 20px;
        display: block;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        /* Pastikan tinggi canvas minimal full screen */
        background-image: url('<?= base_url('asset/img/loginbkg.png') ?>');
        background-size: cover;
        /* Pastikan gambar latar belakang menyesuaikan dengan ukuran layar */
        background-position: center;
        background-blend-mode: multiply;
        background-color: rgba(0, 0, 0, 0.3);
    }

    .rzw-box-profile {
        width: 100%;
        display: block;
        padding: 20px;
        text-align: center;
        background-color: #f9f9f9;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 20%;
        margin-bottom: auto;
    }

    .rzw-box-content {
        width: 100%;
        display: block;
        padding: 20px;
        text-align: center;
        background-color: #f9f9f9;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 7%;
        margin-bottom: auto;
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
        z-index: 3;
    }

    .rzw-input {
        padding-left: 40px;
        border-color: #00b4cd;
        border-radius: 10px !important;
        height: 50px;
    }

    .rzw-btn {
        background-color: #000;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        height: 20%;
        margin-bottom: 10px;
    }

    .rzw-btn-content {
        background-color: #00b4cd;
        font-size: 15px;
        border: none;
        padding: 8px;
    }

    .rzw-profile-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 8px;
        object-fit: cover;
        margin-top: 20px;
    }

    a {
        text-decoration: none;
        color: #000;
    }

    .rzw-keterangan-green {
        background-color: green;
        color: white;
        padding-left: 5px;
        padding-right: 5px;
        padding-top: 6px;
        padding-bottom: 2px;
        border-radius: 5px;
        margin-right: 10px;
    }

    .rzw-keterangan-yellow {
        background-color: #ecd700;
        color: black;
        padding-left: 5px;
        padding-right: 5px;
        padding-top: 6px;
        padding-bottom: 2px;
        border-radius: 5px;
        margin-right: 10px;
    }

    .rzw-keterangan-red {
        background-color: red;
        color: white;
        padding-left: 5px;
        padding-right: 5px;
        padding-top: 6px;
        padding-bottom: 2px;
        border-radius: 5px;
    }
    </style>
</head>

<body>
    <div class="canvas">
        <?= $this->renderSection('content') ?>
    </div>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>