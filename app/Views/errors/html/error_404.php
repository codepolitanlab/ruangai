<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('Errors.pageNotFound') ?></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 600px;
            padding: 20px;
        }

        h1 {
            font-size: 6em;
            margin: 0;
        }

        p {
            font-size: 1.2em;
            margin: 10px 0 30px;
        }

        a {
            text-decoration: none;
            color: #ffffff;
            background-color: #007bff;
            padding: 12px 24px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 4em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://image.web.id/images/page-not-found-min.md.png" alt="page-not-found-min.png" border="0" style="width:100%" />
        <?php if (ENVIRONMENT !== 'production') : ?>
            <?= nl2br(esc($message)) ?>
        <?php else : ?>
            <?= lang('Errors.sorryCannotFind') ?>
            <div style="margin-top: 30px">
                <a href="/">Back to home</a>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>
