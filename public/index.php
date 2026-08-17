<?php

require_once '../src/HeartRateCalculator.php';
require_once '../src/KarvonenCalculator.php';

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $age = (int)($_POST['age'] ?? 0);
    $resting = (int)($_POST['resting'] ?? 0);

    $fcm = HeartRateCalculator::calculateTanaka($age);

    $result = [
        'fcm' => $fcm,
        'zones' => KarvonenCalculator::calculateZones(
            $fcm,
            $resting
        )
    ];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Running Zones Pro</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
      rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>

:root {

    --bg:#0f172a;
    --card:#1e293b;
    --card2:#0f172a;

    --text:#f8fafc;
    --muted:#94a3b8;

    --primary:#38bdf8;
    --secondary:#2563eb;

    --z1:#22c55e;
    --z2:#84cc16;
    --z3:#facc15;
    --z4:#fb923c;
    --z5:#ef4444;
}

* {
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body {

    font-family:'Inter',sans-serif;

    background:
        linear-gradient(
            135deg,
            #020617,
            #0f172a,
            #1e293b
        );

    color:white;

    min-height:100vh;
}

.container {

    max-width:1400px;

    margin:auto;

    padding:40px 20px;
}

.hero {

    text-align:center;

    margin-bottom:50px;
}

.hero h1 {

    font-size:4rem;
    font-weight:800;

    background:
        linear-gradient(
            90deg,
            #38bdf8,
            #60a5fa
        );

    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.hero p {

    color:var(--muted);

    font-size:1.2rem;

    margin-top:10px;
}

.grid {

    display:grid;

    grid-template-columns:
        400px
        1fr;

    gap:30px;
}

.card {

    background:
        rgba(255,255,255,0.05);

    backdrop-filter:blur(20px);

    border:1px solid rgba(255,255,255,0.1);

    border-radius:24px;

    padding:30px;

    box-shadow:
        0 20px 40px rgba(0,0,0,.25);
}

label {

    display:block;

    margin-bottom:8px;

    color:#cbd5e1;
}

input {

    width:100%;

    padding:15px;

    border:none;

    border-radius:12px;

    background:#334155;

    color:white;

    font-size:16px;

    margin-bottom:20px;
}

input:focus {

    outline:none;

    box-shadow:0 0 0 3px #38bdf880;
}

.btn {

    width:100%;

    padding:15px;

    border:none;

    border-radius:12px;

    color:white;

    font-weight:700;

    font-size:16px;

    cursor:pointer;

    background:
        linear-gradient(
            90deg,
            #06b6d4,
            #2563eb
        );
}

.btn:hover {

    transform:translateY(-2px);

    transition:.2s;
}

.result-top {

    display:grid;

    grid-template-columns:repeat(3,1fr);

    gap:20px;

    margin-bottom:30px;
}

.metric {

    text-align:center;

    padding:25px;

    border-radius:20px;

    background:#0f172a;
}

.metric-title {

    color:#94a3b8;
    font-size:.9rem;
}

.metric-value {

    font-size:2.2rem;
    font-weight:800;

    margin-top:10px;
}

.zone {

    margin-bottom:20px;

    background:#0f172a;

    border-radius:18px;

    padding:18px;
}

.zone-header {

    display:flex;

    justify-content:space-between;

    margin-bottom:10px;
}

.zone-name {

    font-weight:700;
}

.zone-range {

    color:#cbd5e1;
}

.progress {

    width:100%;
    height:14px;

    background:#1e293b;

    border-radius:20px;

    overflow:hidden;
}

.progress-bar {

    height:100%;
    border-radius:20px;
}

.chart-card {

    margin-top:25px;
}

.empty {

    text-align:center;

    color:#94a3b8;

    padding:60px;
}

@media (max-width:1000px) {

    .grid {

        grid-template-columns:1fr;
    }

    .result-top {

        grid-template-columns:1fr;
    }

    .hero h1 {

        font-size:2.5rem;
    }

}

</style>

</head>

<body>

<div class="container">

    <div class="hero">

        <h1>🏃 Running Zones Pro</h1>

        <p>
            Calcula tus zonas de entrenamiento mediante
            frecuencia cardíaca de reserva (Karvonen)
        </p>

    </div>

    <div class="grid">

        <div class="card">

            <form method="post">

                <label>Edad</label>

                <input
                    type="number"
                    min="1"
                    max="100"
                    name="age"
                    required
                >

                <label>Frecuencia Cardíaca en Reposo</label>

                <input
                    type="number"
                    min="30"
                    max="100"
                    name="resting"
                    required
                >

                <button class="btn">
                    Calcular Zonas
                </button>

            </form>

        </div>

        <div class="card">

        <?php if($result): ?>

            <?php

            $zones = array_values($result['zones']);

            ?>

            <div class="result-top">

                <div class="metric">

                    <div class="metric-title">
                        FCM Estimada
                    </div>

                    <div class="metric-value">
                        <?= $result['fcm'] ?>
                    </div>

                </div>

                <div class="metric">

                    <div class="metric-title">
                        Método
                    </div>

                    <div class="metric-value">
                        Tanaka
                    </div>

                </div>

                <div class="metric">

                    <div class="metric-title">
                        Zonas
                    </div>

                    <div class="metric-value">
                        5
                    </div>

                </div>

            </div>

            <?php

            $colors = [
                '#22c55e',
                '#84cc16',
                '#facc15',
                '#fb923c',
                '#ef4444'
            ];

            $i=0;

            foreach($result['zones'] as $name => $zone):

            ?>

            <div class="zone">

                <div class="zone-header">

                    <span class="zone-name">
                        <?= $name ?>
                    </span>

                    <span class="zone-range">
                        <?= $zone[0] ?>
                        -
                        <?= $zone[1] ?>
                        bpm
                    </span>

                </div>

                <div class="progress">

                    <div
                        class="progress-bar"
                        style="
                            width:<?= 20 + ($i * 15) ?>%;
                            background:<?= $colors[$i] ?>
                        ">
                    </div>

                </div>

            </div>

            <?php
            $i++;
            endforeach;
            ?>

            <div class="chart-card">

                <canvas id="zonesChart"></canvas>

            </div>

        <?php else: ?>

            <div class="empty">

                <h2>
                    Introduce tus datos
                </h2>

                <p style="margin-top:15px;">
                    Calcularemos automáticamente tus
                    zonas de entrenamiento.
                </p>

            </div>

        <?php endif; ?>

        </div>

    </div>

</div>

<?php if($result): ?>

<script>

new Chart(

document.getElementById('zonesChart'),

{
    type: 'bar',

    data: {

        labels: [
            'Z1',
            'Z2',
            'Z3',
            'Z4',
            'Z5'
        ],

        datasets: [{

            label: 'Límite superior BPM',

            data: [

                <?= $zones[0][1] ?>,
                <?= $zones[1][1] ?>,
                <?= $zones[2][1] ?>,
                <?= $zones[3][1] ?>,
                <?= $zones[4][1] ?>

            ],

            backgroundColor: [

                '#22c55e',
                '#84cc16',
                '#facc15',
                '#fb923c',
                '#ef4444'

            ]
        }]
    },

    options: {

        responsive:true,

        plugins: {

            legend: {

                labels: {

                    color:'white'
                }
            }
        },

        scales: {

            x: {

                ticks: {

                    color:'white'
                }
            },

            y: {

                ticks: {

                    color:'white'
                }
            }
        }
    }
});

</script>

<?php endif; ?>

</body>

</html>
