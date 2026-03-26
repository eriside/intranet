<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Seite nicht gefunden</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f8f8, #eaeaea);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .page_404 {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            text-align: center;
        }

        .four_zero_four_bg {
            background-image: url("https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif");
            background-size: cover;
            background-position: center;
            height: 250px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .four_zero_four_bg h1 {
            font-size: 90px;
            color: #fff;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
            padding-top: 60px;
        }

        .contant_box_404 h3 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .link_404 {
            text-decoration: none;
            color: #fff;
            background: #39ac31;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .link_404:hover {
            background: #2e8b27;
        }
    </style>
</head>
<body>
<div class="page_404">
    <div class="four_zero_four_bg">
        <h1>404</h1>
    </div>
    <div class="contant_box_404">
        <h3>Na du kleiner Losty 😅</h3>
        <p>Was suchst du hier? Irgendwas ist wohl schiefgelaufen, wenn du hier gelandet bist.</p>
        <a href="{{url('/intranet')}}" class="link_404">Zurück ins Intranet</a>
    </div>
</div>
</body>
</html>
