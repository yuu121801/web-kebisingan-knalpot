<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Log Data - Motorcycle Noise Monitoring</title>

<link rel="stylesheet" href="css/bootstrap.min.css"/>
<script src="js/bootstrap.bundle.min.js"></script>

<!-- Firebase SDK (Compat Mode) -->
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
.sidebar.active{ left:0; }
.sidebar a{
  display:block;
  color:#dbe8ff;
  text-decoration:none;
  padding:16px 24px;
  border-bottom:1px solid #223147;
}
.sidebar a:hover{ background:#1a2638; color:#fff; }

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

/* Toolbar Aksi Pilihan Data */
.action-toolbar{
  display:flex;
  gap:10px;
  flex-wrap:wrap;
  align-items:center;
  margin-bottom:16px;
}

.btn-custom{
  padding:8px 16px;
  border-radius:8px;
  font-size:13px;
  font-weight:600;
  border:none;
  transition: opacity 0.2s;
}
.btn-custom:hover{ opacity: 0.88; }
.btn-select-mode{ background:#2980b9; color:#fff; }

/* Tombol Mode Pilihan */
.btn-confirm-export{ background:#00b894; color:#fff; }
.btn-confirm-delete{ background:#e67e22; color:#fff; }
.btn-cancel-mode{ background:#636e72; color:#fff; }

/* Tombol Hapus Satuan */
.btn-delete-single {
  background: rgba(231, 76, 60, 0.15);
  color: #ff6b6b;
  border: 1px solid rgba(231, 76, 60, 0.4);
  padding: 4px 10px;
  border-radius: 6px;
  font-size: 12px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-delete-single:hover {
  background: #e74c3c;
  color: #fff;
}

.section-box{
  background:#162132;
  border:1px solid #243247;
  border-radius:14px;
  overflow:hidden;
  margin-top:10px;
}

.section-header{
  padding:18px 20px;
  border-bottom:1px solid #243247;
  font-size:16px;
  font-weight:700;
  text-transform:uppercase;
  letter-spacing:1px;
}

.table-dark-custom{ color:#eaf2ff; margin-bottom:0; }
.table-dark-custom th{
  color:#8ea1bc;
  font-size:13px;
  border-bottom:1px solid #243247;
  padding:14px 16px;
}
.table-dark-custom td{
  border-top:1px solid #223146;
  padding:14px 16px;
  vertical-align:middle;
}

.badge-level{
  display:inline-block;
  padding:5px 10px;
  border-radius:8px;
  font-size:11px;
  font-weight:700;
}
.badge-normal{ color:#37b7ff; border:1px solid rgba(55,183,255,.35); background:rgba(55,183,255,.10); }
.badge-bising{ color:#ff5e62; border:1px solid rgba(255,102,106,.35); background:rgba(255,102,106,.10); }

/* Kolom Centang Dinamis */
.col-select {
  display: none;
  text-align: center;
  width: 90px;
}

.custom-checkbox {
  width: 22px;
  height: 22px;
  cursor: pointer;
  accent-color: #37b7ff;
  vertical-align: middle;
}
</style>
</head>

<body>

<div id="sidebar" class="sidebar">
  <a href="index.php">Dashboard</a>
  <a href="log.php">Log</a>
</div>

<div class="container py-4">

  <div class="topbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <span class="menu-btn" onclick="toggleSidebar()">☰</span>
      <div>
        <h1 style="font-size:20px;margin:0;">System Logs</h1>
        <div class="brand-sub" style="color:#90a4bf;font-size:13px;">Riwayat Lengkap Data Deteksi Kebisingan</div>
      </div>
    </div>
  </div>

  <!-- Toolbar Kontrol Ekspor dan Hapus Terpilih -->
  <div class="action-toolbar">
    <!-- Tombol Masuk Mode Centang -->
    <button id="btnPilihData" class="btn-custom btn-select-mode" onclick="aktifkanModeCentang()">
      ☑️ Pilih Data
    </button>

    <!-- Tindakan Saat Mode Centang Aktif -->
    <div id="groupModeCentang" style="display: none;" class="d-flex gap-2">
      <button class="btn-custom btn-confirm-export" onclick="eksekusiExportCentang()">
        📥 Export Data Terpilih (<span class="countSelected">0</span>)
      </button>
      <button class="btn-custom btn-confirm-delete" onclick="eksekusiHapusCentang()">
        🗑️ Hapus Data Terpilih (<span class="countSelected">0</span>)
      </button>
      <button class="btn-custom btn-cancel-mode" onclick="matikanModeCentang()">
        Batal
      </button>
    </div>
  </div>

  <div class="section-box">
    <div class="section-header d-flex justify-content-between align-items-center">
      <span>Semua Riwayat Data (Log)</span>
      <span style="font-size:13px; color:#8ea1bc; font-weight:normal;">Total: <strong id="totalRecordsText">0</strong> Data</span>
    </div>

    <div class="table-responsive">
      <table class="table table-dark-custom align-middle">
        <thead>
          <tr>
            <th style="width: 60px;">No</th>
            <th>Tanggal & Waktu Deteksi</th>
            <th>Tingkat Kebisingan</th>
            <th>Kategori Status</th>
            <th style="width: 110px; text-align: center;">Aksi</th>
            <th class="col-select">
              <label style="cursor:pointer; font-size:11px; display:block; margin-bottom:2px;">Semua</label>
              <input type="checkbox" class="custom-checkbox" id="checkAll" onclick="toggleSelectAll(this)">
            </th>
          </tr>
        </thead>
        <tbody id="logTableBody">
          <tr>
            <td colspan="5" class="text-center text-muted py-4">Memuat data log dari Firebase...</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script>
function toggleSidebar(){
  document.getElementById("sidebar").classList.toggle("active");
}

// ==========================================
// KONFIGURASI FIREBASE
// ==========================================
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

firebase.initializeApp(firebaseConfig);
const db = firebase.database();

let globalEntries = [];
let isSelectionMode = false;

// Format Waktu & Tanggal: DD/MM/YYYY HH:mm:ss
const eventTimestampCache = JSON.parse(localStorage.getItem("noise_log_datetime_cache") || "{}");

function formatTanggalWaktuLokal(dateObj) {
  const tgl = String(dateObj.getDate()).padStart(2, '0');
  const bln = String(dateObj.getMonth() + 1).padStart(2, '0');
  const thn = dateObj.getFullYear();
  const jam = String(dateObj.getHours()).padStart(2, '0');
  const mnt = String(dateObj.getMinutes()).padStart(2, '0');
  const dtk = String(dateObj.getSeconds()).padStart(2, '0');
  return `${tgl}/${bln}/${thn} ${jam}:${mnt}:${dtk}`;
}

function resolveTimestamp(itemKey, rawTimestamp) {
  // Jika rawTimestamp adalah UNIX epoch milliseconds aktual (misal: > 10^12)
  if (typeof rawTimestamp === "number" && rawTimestamp > 1000000000000) {
    return formatTanggalWaktuLokal(new Date(rawTimestamp));
  }

  // Jika sudah tersimpan di cache browser untuk key ini
  if (eventTimestampCache[itemKey]) {
    return eventTimestampCache[itemKey];
  }

  // Fallback: Catat waktu saat data pertama kali diterima browser lengkap dengan tanggal
  const currentFormatted = formatTanggalWaktuLokal(new Date());
  eventTimestampCache[itemKey] = currentFormatted;
  localStorage.setItem("noise_log_datetime_cache", JSON.stringify(eventTimestampCache));
  return currentFormatted;
}

db.ref("riwayat_kebisingan").on("value", (snapshot) => {
  const rawData = snapshot.val();
  const logTableBody = document.getElementById("logTableBody");
  const totalText = document.getElementById("totalRecordsText");

  if (!rawData) {
    globalEntries = [];
    logTableBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">Belum ada riwayat log data.</td></tr>';
    totalText.textContent = "0";
    return;
  }

  const entries = Object.keys(rawData).map(key => ({
    firebaseKey: key,
    formattedTime: resolveTimestamp(key, rawData[key].timestamp),
    ...rawData[key]
  }));

  entries.reverse();
  globalEntries = entries;
  totalText.textContent = entries.length;

  let html = "";
  entries.forEach((row, i) => {
    const noiseVal = parseFloat(row.noise_level) || 0;
    const isBising = noiseVal >= 80.0;
    const badgeClass = isBising ? "badge-bising" : "badge-normal";
    const statusLabel = isBising ? "Bising" : "Normal";

    html += `<tr>
      <td>${i + 1}</td>
      <td class="font-monospace fw-semibold">${row.formattedTime}</td>
      <td><strong>${noiseVal.toFixed(2)} dB</strong></td>
      <td>
        <span class="badge-level ${badgeClass}">${statusLabel}</span>
      </td>
      <td style="text-align: center;">
        <button class="btn-delete-single" onclick="hapusSatuData('${row.firebaseKey}', '${row.formattedTime}', '${noiseVal.toFixed(2)}')">
          🗑️ Hapus
        </button>
      </td>
      <td class="col-select">
        <input type="checkbox" class="custom-checkbox row-checkbox" value="${row.firebaseKey}" data-index="${i}" onchange="updateSelectedCount()">
      </td>
    </tr>`;
  });

  logTableBody.innerHTML = html;
  terapkanVisibilitasKolom();
});

// ==========================================
// HAPUS DATA SATUAN
// ==========================================
function hapusSatuData(key, waktu, dbVal) {
  if (confirm(`Hapus data kebisingan ${dbVal} dB pada waktu [${waktu}]?`)) {
    db.ref(`riwayat_kebisingan/${key}`).remove()
      .then(() => {
        if (eventTimestampCache[key]) {
          delete eventTimestampCache[key];
          localStorage.setItem("noise_log_datetime_cache", JSON.stringify(eventTimestampCache));
        }
      })
      .catch(err => {
        alert("Gagal menghapus data: " + err.message);
      });
  }
}

// ==========================================
// KONTROL MODE CENTANG
// ==========================================
function terapkanVisibilitasKolom() {
  const colElements = document.querySelectorAll(".col-select");
  colElements.forEach(el => {
    el.style.display = isSelectionMode ? "table-cell" : "none";
  });
}

function aktifkanModeCentang() {
  if (globalEntries.length === 0) {
    alert("Belum ada data untuk dipilih!");
    return;
  }
  isSelectionMode = true;
  document.getElementById("btnPilihData").style.display = "none";
  document.getElementById("groupModeCentang").style.display = "flex";
  terapkanVisibilitasKolom();
  updateSelectedCount();
}

function matikanModeCentang() {
  isSelectionMode = false;
  document.getElementById("btnPilihData").style.display = "inline-block";
  document.getElementById("groupModeCentang").style.display = "none";
  
  const checkboxes = document.querySelectorAll(".row-checkbox");
  checkboxes.forEach(cb => cb.checked = false);
  const checkAll = document.getElementById("checkAll");
  if (checkAll) checkAll.checked = false;

  terapkanVisibilitasKolom();
}

function toggleSelectAll(master) {
  const checkboxes = document.querySelectorAll(".row-checkbox");
  checkboxes.forEach(cb => cb.checked = master.checked);
  updateSelectedCount();
}

function updateSelectedCount() {
  const selected = document.querySelectorAll(".row-checkbox:checked").length;
  document.querySelectorAll(".countSelected").forEach(el => el.innerText = selected);
}

// ==========================================
// LOGIKA EKSPOR CSV TERPILIH
// ==========================================
function downloadCSV(dataArray, filenamePrefix) {
  let csv = "No,Tanggal_Dan_Waktu,Tingkat_Kebisingan_dB,Status\r\n";

  dataArray.forEach((item, idx) => {
    const waktu = item.formattedTime;
    const dbVal = (parseFloat(item.noise_level) || 0).toFixed(2);
    const label = parseFloat(item.noise_level) >= 80.0 ? "Bising" : "Normal";

    csv += `${idx + 1},"${waktu}",${dbVal},"${label}"\r\n`;
  });

  const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = `${filenamePrefix}_${new Date().toISOString().slice(0, 10)}.csv`;
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
}

function eksekusiExportCentang() {
  const checkedBoxes = document.querySelectorAll(".row-checkbox:checked");
  if (checkedBoxes.length === 0) {
    alert("Silakan centang data yang ingin diexport terlebih dahulu!");
    return;
  }

  const selectedData = [];
  checkedBoxes.forEach(cb => {
    const idx = parseInt(cb.getAttribute("data-index"));
    selectedData.push(globalEntries[idx]);
  });

  downloadCSV(selectedData, `log_kebisingan_terpilih_${selectedData.length}_data`);
  matikanModeCentang();
}

function eksekusiHapusCentang() {
  const checkedBoxes = document.querySelectorAll(".row-checkbox:checked");
  if (checkedBoxes.length === 0) {
    alert("Silakan centang data yang ingin dihapus terlebih dahulu!");
    return;
  }

  if (confirm(`Yakin ingin menghapus ${checkedBoxes.length} data terpilih dari database?`)) {
    const promises = [];
    checkedBoxes.forEach(cb => {
      const key = cb.value;
      promises.push(db.ref(`riwayat_kebisingan/${key}`).remove());
      if (eventTimestampCache[key]) {
        delete eventTimestampCache[key];
      }
    });

    Promise.all(promises)
      .then(() => {
        localStorage.setItem("noise_log_datetime_cache", JSON.stringify(eventTimestampCache));
        alert("Data terpilih berhasil dihapus!");
        matikanModeCentang();
      })
      .catch(err => {
        alert("Gagal menghapus beberapa data: " + err.message);
      });
  }
}
</script>

</body>
</html>