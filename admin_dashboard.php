<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>لوحة التحكم | وصّلني</title>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-color: #0056b3;
        --secondary-color: #007bff;
        --sidebar-bg: #1a252f;
        --bg-color: #f4f7f6;
        --text-dark: #333;
        --text-light: #fff;
        --danger: #dc3545;
        --success: #28a745;
        --warning: #ffc107;
    }

    body {
        font-family: 'Tajawal', sans-serif; 
        background: var(--bg-color); 
        margin: 0; 
        display: flex;
        color: var(--text-dark);
    }

    /* تصميم القائمة الجانبية */
    .sidebar {
        width: 250px; 
        background: var(--sidebar-bg); 
        color: var(--text-light); 
        height: 100vh; 
        padding: 20px 0;
        box-shadow: -2px 0 10px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
    }
    .sidebar h2 {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .sidebar button {
        width: 100%; 
        padding: 15px 20px; 
        margin-bottom: 5px; 
        border: none; 
        background: transparent; 
        color: var(--text-light); 
        cursor: pointer;
        text-align: right;
        font-size: 16px;
        font-family: 'Tajawal', sans-serif;
        transition: all 0.3s;
    }
    .sidebar button:hover, .sidebar button.active-btn {
        background: var(--primary-color);
        padding-right: 25px;
    }
    .sidebar .logout-btn {
        margin-top: auto;
        background: rgba(220, 53, 69, 0.1);
        color: #ff6b6b;
    }
    .sidebar .logout-btn:hover {
        background: var(--danger);
        color: var(--text-light);
    }

    /* تصميم المحتوى */
    .content {
        flex: 1; 
        padding: 30px;
        height: 100vh;
        overflow-y: auto;
    }
    .section {
        display: none;
        animation: fadeIn 0.4s ease-in-out;
    }
    .section.active {
        display: block;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* الكروت والعناصر */
    .card {
        background: white; 
        padding: 25px; 
        margin-bottom: 20px; 
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .card h3 { margin-top: 0; color: var(--primary-color); border-bottom: 2px solid #eee; padding-bottom: 10px;}
    
    input, select {
        width: 100%; 
        padding: 10px 15px; 
        margin-top: 10px; 
        border: 1px solid #ddd;
        border-radius: 6px;
        font-family: 'Tajawal', sans-serif;
        box-sizing: border-box;
    }
    input:focus, select:focus {
        border-color: var(--secondary-color);
        outline: none;
    }

    button.action {
        background: var(--secondary-color); 
        color: white; 
        margin-top: 15px; 
        padding: 10px 20px; 
        border: none; 
        border-radius: 6px;
        cursor: pointer;
        font-family: 'Tajawal', sans-serif;
        font-weight: bold;
        transition: 0.3s;
    }
    button.action:hover { background: var(--primary-color); }

    .list-item {
        display: flex; 
        justify-content: space-between; 
        align-items: center;
        padding: 12px 15px; 
        background: #f8f9fa; 
        margin-top: 8px;
        border-radius: 6px;
        border: 1px solid #eee;
    }
    .list-item button {
        background: var(--danger); 
        border: none; 
        color: white; 
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-family: 'Tajawal', sans-serif;
    }

    /* الإحصائيات المحسنة */
    .stats-header {
        margin-bottom: 15px;
        color: var(--sidebar-bg);
        font-weight: bold;
    }
    .stats-container { 
        display: flex; 
        gap: 20px; 
        margin-bottom: 30px; 
        flex-wrap: wrap; 
    }
    .stat-card { 
        background: #fff; 
        padding: 20px; 
        flex: 1; 
        min-width: 200px; 
        border-radius: 10px; 
        text-align: center; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 4px;
    }
    .stat-card.driver::before { background: var(--secondary-color); }
    .stat-card.passenger::before { background: var(--success); }

    .stat-card h4 { margin: 0; color: #7f8c8d; font-size: 15px; font-weight: 500;}
    .stat-card .value { font-size: 28px; font-weight: bold; margin: 15px 0 5px; color: var(--sidebar-bg); }
    .stat-card .sub-value { font-size: 13px; color: #95a5a6; }

    /* الجداول */
    table { 
        width: 100%; 
        border-collapse: collapse; 
        background: white; 
        border-radius: 8px; 
        overflow: hidden; 
    }
    table th, table td { 
        padding: 15px; 
        text-align: right; 
        border-bottom: 1px solid #eee; 
    }
    table th { background: var(--sidebar-bg); color: white; font-weight: normal;}
    table tr:hover { background: #f1f4f8; }
    
    .btn-delete {
        background: var(--danger); 
        color: white; 
        border: none; 
        padding: 6px 12px; 
        border-radius: 4px; 
        cursor: pointer;
        font-family: 'Tajawal', sans-serif;
    }
    .btn-delete:hover { background: #c82333; }
</style>
</head>
<body>

<div class="sidebar">
    <h2>لوحة الإدارة</h2>
    <button onclick="showSection('dashboard', this)" class="active-btn">📊 الإحصائيات</button>
    <button onclick="showSection('routes', this)">🛣️ الخطوط</button>
    <button onclick="showSection('stations', this)">🚏 المحطات</button>
    <button onclick="showSection('drivers', this)">🚕 السائقين</button>
    <button onclick="showSection('passengers', this)">👥 الركاب</button>
    <button class="logout-btn" onclick="logout()">🚪 تسجيل الخروج</button>
</div>

<div class="content">

    <div id="dashboard" class="section active">
        <h2 class="stats-header">إحصائيات السائقين</h2>
        <div class="stats-container">
            <div class="stat-card driver">
                <h4>إجمالي السائقين</h4>
                <div class="value" id="stat-total-drivers">0</div>
                <div class="sub-value">سائق مسجل بالأنظمة</div>
            </div>
            <div class="stat-card driver">
                <h4>السائقين المعينين على خطوط</h4>
                <div class="value" id="stat-assigned-drivers" style="color: var(--success);">0</div>
                <div class="sub-value" id="stat-unassigned-drivers">0 غير معينين</div>
            </div>
        </div>

        <h2 class="stats-header">إحصائيات الركاب</h2>
        <div class="stats-container">
            <div class="stat-card passenger">
                <h4>إجمالي الركاب</h4>
                <div class="value" id="stat-total-passengers">0</div>
                <div class="sub-value">مستخدم مسجل للتطبيق</div>
            </div>
            <div class="stat-card passenger">
                <h4>نسبة الطلاب</h4>
                <div class="value" id="stat-student-perc">0%</div>
                <div class="sub-value">من إجمالي الركاب</div>
            </div>
            <div class="stat-card passenger">
                <h4>النوع (ذكر/أنثى)</h4>
                <div class="value" id="stat-gender-ratio" style="font-size: 22px;">0 / 0</div>
                <div class="sub-value">توزيع المستخدمين</div>
            </div>
        </div>
    </div>

    <div id="routes" class="section">
        <div class="card">
            <h3>إضافة خط جديد</h3>
            <input id="routeName" placeholder="اسم الخط (مثلاً: رمسيس - التجمع)">
            <button class="action" onclick="addRoute()">إضافة الخط</button>
        </div>
        <div class="card">
            <h3>الخطوط الحالية</h3>
            <div id="routesList"></div>
        </div>
    </div>

    <div id="stations" class="section">
        <div class="card">
            <h3>إضافة محطة لخط سير</h3>
            <select id="stationRoute"></select>
            <input id="stationName" placeholder="اسم المحطة">
            <input id="stationOrder" type="number" placeholder="ترتيب المحطة">
            <button class="action" onclick="addStation()">حفظ المحطة</button>
        </div>
        <div class="card">
            <h3>استعراض محطات الخط</h3>
            <select onchange="loadStations(this.value)" id="viewStationsSelect"></select>
            <div id="stationsList"></div>
        </div>
    </div>

    <div id="drivers" class="section">
        <div class="card">
            <h3>قائمة السائقين</h3>
            <select id="filterDriverRoute" onchange="loadDrivers(this.value)" style="margin-bottom: 15px; max-width: 300px;">
                <option value="">كل الخطوط</option>
            </select>
            <input 
    type="text" 
    id="driverSearch" 
    placeholder="🔍 ابحث بالاسم أو رقم التليفون..." 
    oninput="filterDrivers()" 
    style="margin-bottom:15px; max-width:300px;">
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr><th>الاسم</th><th>الهاتف</th><th>السيارة</th><th>اللوحة</th><th>إجراء</th></tr>
                    </thead>
                    <tbody id="driversTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="passengers" class="section">
        <div class="card">
            <h3>قائمة الركاب</h3>
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr><th>الاسم</th><th>الهاتف</th><th>النوع</th><th>الفئة</th><th>إجراء</th></tr>
                    </thead>
                    <tbody id="passengersTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>
  
</div>

<script>
const API = "http://localhost/wasalni/api/";


let allDrivers = [];

// دالة التنقل بين الأقسام
function showSection(id, btnElement = null){
    document.querySelectorAll(".section").forEach(s => s.classList.remove("active"));
    document.getElementById(id).classList.add("active");
    
    // تغيير لون الزر النشط في القائمة الجانبية
    if(btnElement) {
        document.querySelectorAll(".sidebar button").forEach(b => b.classList.remove("active-btn"));
        btnElement.classList.add("active-btn");
    }
}

async function loadRoutes(){
    const res = await fetch(API + "get_routes.php");
    const data = await res.json();
    const list = document.getElementById("routesList");
    const addSelect = document.getElementById("stationRoute"); 
    const viewSelect = document.querySelector("#viewStationsSelect"); 

    list.innerHTML = ""; 
    addSelect.innerHTML = "<option value=''>اختر الخط</option>";
    if(viewSelect) viewSelect.innerHTML = "<option value=''>اختر الخط لعرض المحطات</option>";

    data.forEach(r=>{
        const div = document.createElement("div");
        div.className="list-item";
        div.innerHTML = `<span>${r.name}</span> <button onclick="deleteRoute(${r.id})">حذف</button>`;
        list.appendChild(div);
        
        const opt = new Option(r.name, r.id);
        addSelect.add(opt);
        if(viewSelect) viewSelect.add(new Option(r.name, r.id));
    });
}

async function addRoute(){
    const name = document.getElementById("routeName").value;
    if(!name) return alert("يرجى إدخال اسم الخط");
    await fetch(API + "add_route.php",{method:"POST",body:new URLSearchParams({name})});
    document.getElementById("routeName").value = "";
    loadRoutes();
    refreshDashboard();
}

async function deleteRoute(id){
    if(confirm("هل أنت متأكد من حذف هذا الخط؟ سيتم حذف جميع المحطات المرتبطة به!")) {
        await fetch(API + "delete_route.php?id=" + id);
        loadRoutes();
        refreshDashboard();
    }
}

async function addStation(){
    const route_id = document.getElementById("stationRoute").value;
    const station_name = document.getElementById("stationName").value;
    const station_order = document.getElementById("stationOrder").value;

    if(!route_id || !station_name || !station_order) return alert("يرجى تعبئة جميع الحقول");

    const res = await fetch(API + "add_station.php", {
        method: "POST",
        body: new URLSearchParams({ route_id, station_name, station_order })
    });

    const data = await res.json(); 

    if (data.status === "success") {
        alert("تمت إضافة المحطة بنجاح");
        document.getElementById("stationName").value = "";
        document.getElementById("stationOrder").value = "";
        document.getElementById("viewStationsSelect").value = route_id;
        loadStations(route_id); 
    } else {
        alert("فشلت الإضافة: " + data.message); 
    }
}

async function loadStations(routeId){
    if(!routeId) {
        document.getElementById("stationsList").innerHTML="";
        return;
    }
    const res = await fetch(API+"get_stations.php?route_id="+routeId);
    const data = await res.json();
    const list=document.getElementById("stationsList"); 
    list.innerHTML="";
    data.forEach(s=>{
        const div=document.createElement("div");
        div.className="list-item";
        div.innerHTML=`<span><b>المحطة ${s.station_order}:</b> ${s.station_name}</span> <button onclick="deleteStation(${s.id}, ${routeId})">حذف</button>`;
        list.appendChild(div);
    });
}

async function deleteStation(id, routeId){ 
    if(confirm("تأكيد حذف المحطة؟")) {
        await fetch(API+"delete_station.php?id="+id); 
        loadStations(routeId);
    }
}

// دالة تحديث الإحصائيات (مفصلة للسائقين والركاب)
function updateStats(drivers, passengers) {
    // إحصائيات السائقين
    const totalDrivers = drivers.length;
    // تم التعديل هنا ليفحص عمود route
    const assignedDrivers = drivers.filter(d => d.route && d.route.trim() !== '').length;
    const unassignedDrivers = totalDrivers - assignedDrivers;

    document.getElementById("stat-total-drivers").textContent = totalDrivers;
    document.getElementById("stat-assigned-drivers").textContent = assignedDrivers;
    document.getElementById("stat-unassigned-drivers").textContent = `${unassignedDrivers} سائق غير معين`;

    // إحصائيات الركابة (كما هي)
    const totalPassengers = passengers.length;
    const students = passengers.filter(p => p.passenger_type === 'student').length;
    const males = passengers.filter(p => p.gender === 'male').length;
    const females = passengers.filter(p => p.gender === 'female').length;

    document.getElementById("stat-total-passengers").textContent = totalPassengers;
    document.getElementById("stat-student-perc").textContent = totalPassengers ? Math.round((students/totalPassengers)*100) + "%" : "0%";
    document.getElementById("stat-gender-ratio").textContent = `👨 ${males} | 👩 ${females}`;
}

// تحميل السائقين مع الفلترة
async function loadDrivers(routeId = "") {
    try {
        const res = await fetch(API + "get_drivers.php" + (routeId ? "?route_id=" + routeId : ""));
        const data = await res.json();

        // 🔴 مهم: تأكد إن الداتا Array
        if (!Array.isArray(data)) {
            console.error("Data مش Array:", data);
            return;
        }

        allDrivers = data;
        renderDrivers(data);

        return data;

    } catch (error) {
        console.error("Error loading drivers:", error);
    }
}

function renderDrivers(drivers) {
    const tbody = document.getElementById("driversTableBody");
    tbody.innerHTML = "";

    drivers.forEach(d => {
        tbody.innerHTML += `
            <tr>
                <td>${d.name}</td>
                <td dir="ltr" style="text-align: right;">${d.phone}</td>
                <td>${d.vehicle_type}</td>
                <td>${d.plate_number}</td>
                <td><button class="btn-delete" onclick="deleteUser('drivers', ${d.id})">حذف</button></td>
            </tr>`;
    });
}
// دالة البحث
function filterDrivers() {
    const input = document.getElementById("driverSearch");

    // لو input مش موجود متكسرش الكود
    if (!input) return;

    const value = input.value.toLowerCase();

    const filtered = allDrivers.filter(d => 
        d.name.toLowerCase().includes(value) || 
        d.phone.includes(value)
    );

    renderDrivers(filtered);
}

// تحميل الركاب
async function loadPassengers() {
    const res = await fetch(API + "get_passengers.php");
    const data = await res.json();
    const tbody = document.getElementById("passengersTableBody");
    tbody.innerHTML = "";

    data.forEach(p => {
        tbody.innerHTML += `
            <tr>
                <td>${p.name}</td>
                <td dir="ltr" style="text-align: right;">${p.phone}</td>
                <td>${p.gender === 'male' ? 'ذكر' : 'أنثى'}</td>
                <td>${p.passenger_type === 'student' ? 'طالب' : 'عادي'}</td>
                <td><button class="btn-delete" onclick="deleteUser('passengers', ${p.id})">حذف</button></td>
            </tr>`;
    });
    return data;
}

// دالة التشغيل المركزية لتحديث كل اللوحة
async function refreshDashboard() {
    const [routes, drivers, passengers] = await Promise.all([
        fetch(API + "get_routes.php").then(r => r.json()),
        loadDrivers(),
        loadPassengers()
    ]);
    
    const filterSelect = document.getElementById("filterDriverRoute");
    const currentVal = filterSelect.value;
    filterSelect.innerHTML = '<option value="">كل الخطوط</option>';
    routes.forEach(r => filterSelect.add(new Option(r.name, r.id)));
    filterSelect.value = currentVal;

    updateStats(drivers, passengers);
}

// دالة حذف مستخدم مركزي
async function deleteUser(table, id) {
    if (confirm("هل أنت متأكد من حذف هذا المستخدم نهائياً؟")) {
        await fetch(`${API}delete_user.php?table=${table}&id=${id}`);
        refreshDashboard(); 
    }
}

function logout(){ 
    fetch(API+"logout.php").then(()=>window.location.href="admin_login.php"); 
}

// التهيئة الأولية
loadRoutes(); 
refreshDashboard();

</script>

</body>
</html>