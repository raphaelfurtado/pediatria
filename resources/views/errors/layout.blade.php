<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <title>@yield('title', 'Erro') | SOPAPE</title>
    <style>
        *,
        ::before,
        ::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'DM Sans', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #023E8A 0%, #0096C7 100%);
            padding: 24px;
        }

        .card {
            background: #fff;
            border-radius: 28px;
            max-width: 520px;
            width: 100%;
            padding: 48px 40px;
            text-align: center;
            box-shadow: 0 30px 60px -20px rgba(2, 62, 138, .45);
        }

        .mark {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #023E8A, #0096C7);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mark svg {
            width: 34px;
            height: 34px;
        }

        .code {
            font-size: 64px;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -2px;
            background: linear-gradient(135deg, #0096C7, #FFB703);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin: 0;
        }

        h1 {
            font-family: 'Poppins', 'DM Sans', sans-serif;
            font-size: 24px;
            font-weight: 800;
            margin: 10px 0 8px;
            color: #023E8A;
        }

        p.msg {
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 28px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #0096C7;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            padding: 13px 28px;
            border-radius: 999px;
            transition: background .2s;
            box-shadow: 0 10px 25px -8px rgba(0, 150, 199, .5);
        }

        .btn:hover {
            background: #023E8A;
        }

        .foot {
            margin-top: 22px;
            font-size: 12px;
            color: #94a3b8;
            font-weight: 600;
            letter-spacing: .5px;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="mark">
            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M16 26 C 16 26 4 18.5 4 11.5 C 4 8 6.8 5.5 10 5.5 C 12.5 5.5 14.8 7 16 9 C 17.2 7 19.5 5.5 22 5.5 C 25.2 5.5 28 8 28 11.5 C 28 18.5 16 26 16 26 Z"
                    fill="#fff" />
            </svg>
        </div>
        <p class="code">@yield('code')</p>
        <h1>@yield('title')</h1>
        <p class="msg">@yield('message')</p>
        <a class="btn" href="/">&larr; Voltar ao início</a>
        <div class="foot">SOPAPE &middot; Sociedade Paraense de Pediatria</div>
    </div>
</body>

</html>
