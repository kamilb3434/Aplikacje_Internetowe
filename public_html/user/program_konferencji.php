<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Program konferencji</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
      background-color: #f8f9fa;
      color: #333;
    }

    header {
      background-color: #007bff;
      color: white;
      padding: 20px 0;
      text-align: center;
    }

    .container {
      max-width: 900px;
      margin: 0 auto;
      padding: 40px 20px;
    }

    h2 {
      font-size: 32px;
      margin-bottom: 10px;
      text-align: center;
    }

    .subtitle {
      text-align: center;
      color: #666;
      margin-bottom: 40px;
    }

    .day-block {
      background: #fff;
      border-radius: 12px;
      padding: 30px;
      margin-bottom: 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .day-block h3 {
      font-size: 20px;
      margin-bottom: 20px;
      color: #007bff;
    }

    .schedule {
      list-style: none;
      padding-left: 0;
    }

    .schedule li {
      padding: 12px 0;
      border-bottom: 1px solid #eee;
      display: flex;
      justify-content: space-between;
      font-size: 16px;
    }

    .schedule li .time {
      font-weight: bold;
      color: #333;
      min-width: 160px;
    }

    footer {
      background-color: #f1f1f1;
      text-align: center;
      padding: 20px;
      font-size: 14px;
      color: #777;
    }
  </style>
</head>
<body>

  <header>
    <h1>Program konferencji naukowej</h1>
  </header>

  <div class="container">
    <h2>Harmonogram wydarzenia</h2>
    <p class="subtitle">Sprawdź szczegółowy plan sesji i wystąpień</p>

    <div class="day-block">
      <h3>Dzień 1 – 15 września 2025 (poniedziałek)</h3>
      <ul class="schedule">
        <li><span class="time">09:00 – 09:30</span> Rejestracja uczestników</li>
        <li><span class="time">09:30 – 10:00</span> Otwarcie konferencji</li>
        <li><span class="time">10:00 – 11:30</span> Sesja I: Nowe technologie w nauce</li>
        <li><span class="time">11:30 – 12:00</span> Przerwa kawowa</li>
        <li><span class="time">12:00 – 13:30</span> Sesja II: Innowacje w edukacji</li>
        <li><span class="time">13:30 – 14:30</span> Przerwa obiadowa</li>
        <li><span class="time">14:30 – 16:00</span> Sesja III: Sztuczna inteligencja i etyka</li>
        <li><span class="time">16:15 – 17:00</span> Panel dyskusyjny z ekspertami</li>
      </ul>
    </div>

    <div class="day-block">
      <h3>Dzień 2 – 16 września 2025 (wtorek)</h3>
      <ul class="schedule">
        <li><span class="time">09:00 – 10:30</span> Sesja IV: Badania interdyscyplinarne</li>
        <li><span class="time">10:30 – 11:00</span> Przerwa kawowa</li>
        <li><span class="time">11:00 – 12:30</span> Sesja V: Młodzi naukowcy – prezentacje referatów</li>
        <li><span class="time">12:30 – 13:30</span> Przerwa obiadowa</li>
        <li><span class="time">13:30 – 15:00</span> Warsztaty tematyczne</li>
        <li><span class="time">15:15 – 16:00</span> Zakończenie i wręczenie certyfikatów</li>
      </ul>
    </div>
  </div>

  <footer>
    &copy; 2025 Serwis konferencyjny.
  </footer>

</body>
</html>
