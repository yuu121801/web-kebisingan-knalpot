<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard - Motorcycle Noise Monitoring</title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-database-compat.js"></script>
<style>
body{
  background:#0f1724;
  color:#eef4ff;
  font-family:"Segoe UI",Tahoma,Geneva,Verdana,sans-serif;
}
.sidebar{
  position:fixed;
  top:0;
  left:-260px;
  width:260px;
  height:100%;
  background:#121c2c;
  border-right:1px solid #25344b;
  transition:.3s;
  z-index:9999;
  padding-top:70px;
}
.sidebar.active{
  left:0;
}
.sidebar a{
  display:block;
  color:#dbe8ff;
  text-decoration:none;
  padding:16px 24px;
  border-bottom:1px solid #223147;
}
.sidebar a:hover{
  background:#1a2638;
  color:#fff;
}
.topbar{
  background:#162132;
  border:1px solid #243247;
  border-radius:14px;
  padding:16px 20px;
  margin-bottom:22px;
}
.menu-btn{
  font-size:26px;
  cursor:pointer;
  color:#fff;
  margin-right:14px;
}
.card-dark{
  background:#162132;
  border:1px solid #243247;
  border-radius:14px;
  padding:20px;
  height:100%;
}
.card-title-small{
  color:#8ea1bc;
  font-size:13px;
  text-transform:uppercase;
  letter-spacing:1px;
  margin-bottom:10px;
}
.card-number{
  font-size:22px;
  font-weight:700;
}
.yellow{
  color:#ffb020;
}
.blue{
  color:#37b7ff;
}
.gray{
  color:#dde7f5;
}
.section-box{
  background:#162132;
  border:1px solid #243247;
  border-radius:14px;
  overflow:hidden;
  margin-top:22px;
}
.table-dark-custom{
  color:#eaf2ff;
  margin-bottom:0;
}
.table-dark-custom th{
  color:#8ea1bc;
  font-size:13px;
  border-bottom:1px solid #243247;
  padding:16px 18px;
}
.table-dark-custom td{
  border-top:1px solid #223146;
  padding:16px 18px;
  vertical-align:middle;
}
.badge-level{
  display:inline-block;
  padding:5px 10px;
  border-radius:8px;
  font-size:11px;
  font-weight:700;
}
.badge-normal{
  color:#37b7ff;
  border:1px solid rgba(55,183,255,.35);
  background:rgba(55,183,255,.10);
}
.badge-bising{
  color:#ff5e62;
  border:1px solid rgba(255,102,106,.35);
  background:rgba(255,102,106,.10);
}
</style>
</head>
<body>
<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">
  <a href="index.php">Dashboard</a>
  <a href="log.php">Log</a>
</div>

<div class="container py-4">
<!-- TOPBAR -->
<div class="topbar d-flex justify-content-between align-items-center">
  <div class="d-flex align-items-center">
    <span class="menu-btn" onclick="toggleSidebar()">☰</span>
    <div>
      <h1 style="font-size:20px;margin:0">Motorcycle Noise Monitoring</h1>
      <div style="color:#90a4bf;font-size:13px">IoT-Based Detection System</div>
    </div>
  </div>
</div>

<!-- STATISTICS -->
<div class="row g-3">
  <div class="col-lg-4 col-md-6">
    <div class="card-dark">
      <div class="card-title-small">Total Events</div>
      <div class="card-number yellow" id="statTotal">0</div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="card-dark">
      <div class="card-title-small">Avg Noise Level</div>
      <div class="card-number blue" id="statAvg">0 dB</div>
    </div>
  </div>
  <div class="col-lg-4 col-md-12">
    <div class="card-dark">
      <div class="card-title-small">Current Time</div>
      <div class="card-number gray" id="liveClock">--:--:--</div>
    </div>
  </div>
</div>

<!-- CHART -->
<div class="section-box">
  <div style="padding:20px">
    <canvas id="noiseChart" height="110"></canvas>
  </div>
</div>

<!-- TABLE -->
<div class="section-box">
  <div class="table-responsive">
    <table class="table table-dark-custom align-middle">
      <thead>
        <tr>
          <th>No</th>
          <th>Tanggal & Waktu Deteksi</th>
          <th>Noise Level</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        <tr>
          <td colspan="4" class="text-center text-muted py-4">
            Memuat data dari Firebase...
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
</div>

<script>
// =====================================================
// SIDEBAR & LIVE CLOCK
// =====================================================
function toggleSidebar(){
  document.getElementById("sidebar").classList.toggle("active");
}

function updateLiveClock(){
  const now = new Date();
  document.getElementById("liveClock").textContent =
    String(now.getHours()).padStart(2,"0") + ":" +
    String(now.getMinutes()).padStart(2,"0") + ":" +
    String(now.getSeconds()).padStart(2,"0");
}
updateLiveClock();
setInterval(updateLiveClock, 1000);

// =====================================================
// FORMAT WAKTU NOTIFIKASI
// =====================================================
function formatNotificationTime(timestamp){
  let date;
  if(typeof timestamp === "number" && timestamp > 1000000000000){
    date = new Date(timestamp);
  }else if(typeof timestamp === "string" && !isNaN(Date.parse(timestamp))){
    date = new Date(timestamp);
  }else{
    date = new Date();
  }
  const day = String(date.getDate()).padStart(2,"0");
  const month = String(date.getMonth()+1).padStart(2,"0");
  const year = date.getFullYear();
  const hour = String(date.getHours()).padStart(2,"0");
  const minute = String(date.getMinutes()).padStart(2,"0");
  const second = String(date.getSeconds()).padStart(2,"0");
  return `${day}/${month}/${year} ${hour}:${minute}:${second}`;
}

// =====================================================
// IZIN NOTIFIKASI SECARA AMAN (TANPA MENGHENTIKAN SCRIPT)
// =====================================================
function requestNotificationAccess() {
  if ("Notification" in window && Notification.permission === "default") {
    Notification.requestPermission().catch(() => {});
  }
}
window.addEventListener("click", requestNotificationAccess, { once: true });
window.addEventListener("keydown", requestNotificationAccess, { once: true });
window.addEventListener("scroll", requestNotificationAccess, { once: true });

// =====================================================
// POPUP NOTIFIKASI (AUTO-CLOSE 2 DETIK DI POPUP, TETAP DI TAB NOTIFIKASI OS)
// =====================================================
function kirimPopup(noiseLevel, timestamp, jarak, key){
  if(!("Notification" in window) || Notification.permission !== "granted"){
    return;
  }

  const dbValue = Number.parseFloat(noiseLevel);
  const dbTampil = Number.isFinite(dbValue) ? dbValue.toFixed(2) : "--";
  const waktu = formatNotificationTime(timestamp);
  const isBising = Number.isFinite(dbValue) && dbValue >= 80;
  const status = isBising ? "BISING" : "Normal";

  let pesan = `Waktu: ${waktu}\nLevel: ${dbTampil} dB [${status}]`;
  if(jarak !== undefined && jarak !== null && jarak !== ""){
    const jarakValue = Number.parseFloat(jarak);
    if(Number.isFinite(jarakValue)){
      pesan += `\nJarak: ${jarakValue.toFixed(1)} cm`;
    }
  }

  try {
    const notification = new Notification(`🚨 Kebisingan: ${dbTampil} dB`, {
      body: pesan,
      tag: "kebisingan-" + key,
      requireInteraction: false
    });

    notification.onclick = () => {
      window.focus();
      notification.close();
    };

    setTimeout(() => {
      notification.close();
    }, 2000);
  } catch(e) {
    console.warn("[NOTIFICATION SKIPPED]", e);
  }
}

// =====================================================
// CHART.JS INITIALIZATION
// =====================================================
const ctx = document.getElementById("noiseChart").getContext("2d");
const noiseChart = new Chart(ctx, {
  type: "line",
  data: {
    labels: [],
    datasets: [{
      label: "Noise Level (dB)",
      data: [],
      borderColor: "#37b7ff",
      backgroundColor: "rgba(55,183,255,.15)",
      tension: .35,
      fill: true,
      pointRadius: 4,
      pointBackgroundColor: "#ffb020"
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        labels: { color: "#8ea1bc" }
      }
    },
    scales: {
      x: {
        ticks: { color: "#8ea1bc" },
        grid: { color: "rgba(255,255,255,.05)" }
      },
      y: {
        min: 50,
        max: 110,
        ticks: { color: "#8ea1bc" },
        grid: { color: "rgba(255,255,255,.05)" }
      }
    }
  }
});

// =====================================================
// FORMAT TANGGAL & WAKTU DASHBOARD
// =====================================================
let eventTimestampCache = {};
try {
  eventTimestampCache = JSON.parse(localStorage.getItem("noise_log_datetime_cache") || "{}");
} catch(e) {
  eventTimestampCache = {};
}

function resolveDashboardTime(key, timestamp){
  if(typeof timestamp === "number" && timestamp > 1000000000000){
    const d = new Date(timestamp);
    const day = String(d.getDate()).padStart(2, "0");
    const month = String(d.getMonth() + 1).padStart(2, "0");
    const year = d.getFullYear();
    const time = String(d.getHours()).padStart(2, "0") + ":" +
                 String(d.getMinutes()).padStart(2, "0") + ":" +
                 String(d.getSeconds()).padStart(2, "0");
    return `${day}/${month}/${year} ${time}`;
  }

  if(eventTimestampCache[key]){
    return eventTimestampCache[key];
  }

  const d = new Date();
  const day = String(d.getDate()).padStart(2, "0");
  const month = String(d.getMonth() + 1).padStart(2, "0");
  const year = d.getFullYear();
  const time = String(d.getHours()).padStart(2, "0") + ":" +
                 String(d.getMinutes()).padStart(2, "0") + ":" +
                 String(d.getSeconds()).padStart(2, "0");
  const fullDateTime = `${day}/${month}/${year} ${time}`;
  eventTimestampCache[key] = fullDateTime;
  try {
    localStorage.setItem("noise_log_datetime_cache", JSON.stringify(eventTimestampCache));
  } catch(e) {}
  return fullDateTime;
}

// =====================================================
// FIREBASE CONFIG & INITIALIZATION
// =====================================================
const firebaseConfig = {
  apiKey: "AIzaSyAplOuPmhgb90eXkt-4jI-GmXbAsBTjfMg",
  authDomain: "monitoring-kebisingan-bec3a.firebaseapp.com",
  databaseURL: "https://monitoring-kebisingan-bec3a-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "monitoring-kebisingan-bec3a",
  storageBucket: "monitoring-kebisingan-bec3a.firebasestorage.app",
  messagingSenderId: "501410348811",
  appId: "1:501410348811:web:c53aa54f3570c292a1ac0e",
  measurementId: "G-RCMSBYHHPV"
};

try {
  firebase.initializeApp(firebaseConfig);
} catch(err) {
  console.error("Firebase Init Error:", err);
}

const db = firebase.database();
const historyRef = db.ref("riwayat_kebisingan");

// =====================================================
// DETEKSI DATA BARU UNTUK NOTIFIKASI
// =====================================================
const knownKeys = {};

historyRef.once("value")
  .then(snapshot => {
    if (snapshot.exists()) {
      snapshot.forEach(child => {
        knownKeys[child.key] = true;
      });
    }

    historyRef.on("child_added", snapshotBaru => {
      const key = snapshotBaru.key;
      const data = snapshotBaru.val();

      if(knownKeys[key]){
        return;
      }
      knownKeys[key] = true;

      const noiseLevel = Number.parseFloat(data.noise_level);
      const jarak = data.distance_trigger_cm;

      kirimPopup(noiseLevel, data.timestamp, jarak, key);
    });
  })
  .catch(error => {
    console.error("[FIREBASE INIT ONCE ERROR]", error);
  });

// =====================================================
// UPDATE DASHBOARD (TABEL, CHART & STATS)
// =====================================================
historyRef.on("value", snapshot => {
  const tableBody = document.getElementById("tableBody");

  if(!snapshot.exists()){
    tableBody.innerHTML = `
      <tr>
        <td colspan="4" class="text-center text-muted py-4">
          Belum ada data kebisingan di database.
        </td>
      </tr>
    `;
    document.getElementById("statTotal").textContent = "0";
    document.getElementById("statAvg").textContent = "0 dB";
    return;
  }

  const entries = [];
  snapshot.forEach(child => {
    const value = child.val();
    entries.push({
      id: child.key,
      eventTime: resolveDashboardTime(child.key, value.timestamp),
      ...value
    });
  });

  // 1. Statistik
  const total = entries.length;
  let sum = 0;
  entries.forEach(item => {
    sum += parseFloat(item.noise_level) || 0;
  });
  document.getElementById("statTotal").textContent = total;
  document.getElementById("statAvg").textContent = total ? (sum/total).toFixed(1) + " dB" : "0 dB";

  // 2. Chart (10 data terakhir)
  const chartEntries = entries.slice(-10);
  noiseChart.data.labels = chartEntries.map(item => {
    return item.eventTime.includes(" ") ? item.eventTime.split(" ")[1] : item.eventTime;
  });
  noiseChart.data.datasets[0].data = chartEntries.map(item => parseFloat(item.noise_level) || 0);
  noiseChart.update();

  // 3. Tabel (5 data terbaru)
  const recent = [...entries].reverse().slice(0, 5);
  let html = "";
  recent.forEach((row, index) => {
    const value = parseFloat(row.noise_level) || 0;
    const bising = value >= 80;
    html += `
      <tr>
        <td>${index + 1}</td>
        <td class="fw-bold font-monospace">${row.eventTime}</td>
        <td>${value.toFixed(2)} dB</td>
        <td>
          <span class="badge-level ${bising ? "badge-bising" : "badge-normal"}">
            ${bising ? "Bising" : "Normal"}
          </span>
        </td>
      </tr>
    `;
  });
  tableBody.innerHTML = html;
}, error => {
  console.error("[FIREBASE DATABASE ERROR]", error);
  document.getElementById("tableBody").innerHTML = `
    <tr>
      <td colspan="4" class="text-center text-danger py-4">
        Gagal memuat data: ${error.message}. Periksa Rules database Firebase.
      </td>
    </tr>
  `;
});
</script>
</body>
</html>