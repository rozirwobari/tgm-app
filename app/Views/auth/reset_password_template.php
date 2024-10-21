<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        .reset-password-btn {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 1vh;
            display: inline-block;
            font-size: 16px;
            font-weight: bold;
        }
        .rzw-center {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="rzw-center">
        <a href="<?= base_url('reset_password/'.$token) ?>" class="reset-password-btn">Reset Password</a>
    </div>
</body>
</html>
