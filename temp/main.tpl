<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>%title%</title>
    <meta name="description" content="%meta_desc%">
    <meta name="keywords" content="%meta_key%">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f4f6f9; color: #333; }
        header { background: #1e3a8a; color: #fff; padding: 20px; text-align: center; }
        nav { background: #2563eb; padding: 10px 20px; text-align: center; }
        nav a { color: #fff; text-decoration: none; margin: 0 15px; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        .wrapper { display: flex; max-width: 1000px; margin: 20px auto; gap: 20px; padding: 0 15px; }
        aside { width: 280px; background: #fff; padding: 15px; border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
        main { flex: 1; background: #fff; padding: 20px; border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
        .article { border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px; }
        .banner-box { background: #e0f2fe; border: 1px solid #bae6fd; padding: 10px; margin-top: 10px; border-radius: 4px; font-size: 14px; }
        footer { text-align: center; padding: 15px; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <header>
        <h1>%title%</h1>
        <p>Адреса сайту: %address%</p>
    </header>
    <nav>%menu%</nav>
    <div class="wrapper">
        <aside>
            %auth_user%
            <h3>Рекламний блок</h3>
            %banners%
        </aside>
        <main>
            %top%
            %middle%
            %bottom%
        </main>
    </div>
    <footer>
        &copy; 2026 Власний шаблонізатор PHP (Лабораторна робота №17)
    </footer>
</body>
</html>