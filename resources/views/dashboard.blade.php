<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard KPI — Suivi Académique</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f1f5f9; }
        header { background: linear-gradient(135deg, #1e3a5f, #2d6a9f); color: white; padding: 20px 40px; display: flex; align-items: center; gap: 16px; }
        header h1 { font-size: 22px; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom:30px; }
        .card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-top: 4px solid #2d6a9f; display: flex; align-items: center; gap: 16px; }
        .card-icon { font-size: 36px; }
        .card-value { font-size: 32px; font-weight: 700; color: #1e3a5f; }
        .card-label { font-size: 13px; color: #666; margin-top: 2px; }
        .charts { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .chart-box { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .chart-box h3 { margin-bottom: 16px; color: #1e3a5f; font-size: 15px; }
        .system-box { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 20px; }
        .system-box h3 { color: #1e3a5f; margin-bottom: 16px; }
        .system-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .sys-item { background: #f8fafc; border-radius: 8px; padding: 12px; text-align: center;}
        .sys-value { font-size: 18px; font-weight: 700; color: #2d6a9f; }
        .sys-label { font-size: 12px; color: #666; margin-top: 4px; }
    </style>
</head>
<body>
<header>
    <span style="font-size:32px">🎓</span>
    <div>
        <h1>Dashboard KPI — Suivi Académique</h1>
        <p style="font-size:13px;opacity:0.8">Indicateurs clés en temps réel — Mis à jour toutes les 30s</p>
    </div>
    <span id="last-update" style="margin-left:auto;font-size:12px;opacity:0.7"></span>
</header>
<div class="container">
    <div class="grid" id="kpi-cards"></div>
    <div class="charts">
        <div class="chart-box"><h3>📊 Répartition des entités académiques</h3><canvas id="barChart"></canvas></div>
        <div class="chart-box"><h3>🥧 Distribution</h3><canvas id="pieChart"></canvas></div>
    </div>
    <div class="system-box">
        <h3>⚙️ Informations système</h3>
        <div class="system-grid" id="sys-info"></div>
    </div>
</div>
<script>
const icons = { filieres:'📚', niveaux:'🎯', ues:'📖', ecs:'📝', personnels:'👨‍🏫', salles:'🏛️', programmations:'📅' };
const labels = { filieres:'Filières', niveaux:'Niveaux', ues:"Unités d'Ens.", ecs:'Éléments Const.', personnels:'Personnels', salles:'Salles', programmations:'Programmations' };
const colors = ['#3b82f6','#10b981','#f59e0b','#8b5cf6','#ef4444','#06b6d4','#f97316'];
let barChart, pieChart;
async function loadKPI() {
    const res = await fetch('/api/kpi');
    const data = await res.json();
    const kpis = data.kpis;
    const sys = data.system;
    document.getElementById('kpi-cards').innerHTML = Object.entries(kpis).map(([k,v]) =>
        `<div class="card"><div class="card-icon">${icons[k]||'📌'}</div><div><div class="card-value">${v}</div><div class="card-label">${labels[k]||k}</div></div></div>`
    ).join('');
    const keys = Object.keys(kpis);
    const values = Object.values(kpis);
    if (barChart) barChart.destroy();
    if (pieChart) pieChart.destroy();
    barChart = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: { labels: keys.map(k=>labels[k]||k), datasets: [{ data: values, backgroundColor: colors, borderRadius: 6 }] },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });
    pieChart = new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: { labels: keys.map(k=>labels[k]||k), datasets: [{ data: values, backgroundColor: colors }] },
        options: { plugins: { legend: { position: 'bottom' } } }
    });
    document.getElementById('sys-info').innerHTML = `
        <div class="sys-item"><div class="sys-value">${sys.memory_usage_mb} MB</div><div class="sys-label">Mémoire</div></div>
        <div class="sys-item"><div class="sys-value">PHP ${sys.php_version}</div><div class="sys-label">Version PHP</div></div>
        <div class="sys-item"><div class="sys-value">Laravel ${sys.laravel_version}</div><div class="sys-label">Framework</div></div>
        <div class="sys-item"><div class="sys-value">${sys.environment}</div><div class="sys-label">Environnement</div></div>
    `;
    document.getElementById('last-update').textContent = 'Mis à jour : ' + new Date().toLocaleTimeString();
}
loadKPI();
setInterval(loadKPI, 30000);
</script>
</body>
</html>
