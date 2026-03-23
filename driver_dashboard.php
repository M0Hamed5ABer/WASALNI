<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>لوحة تحكم السائق - موقفك الرقمي</title>
    <style>
        :root {
            --primary: #0066cc;
            --secondary: #28a745; /* لون الركوب المؤكد */
            --danger: #dc3545; /* لون الحجز (لم يركب بعد) */
            --available: #e0e0e0;
            --driver: #343a40;
            --bg: #f4f7f6;
            --white: #ffffff;
            --text: #333;
        }

        * {
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, sans-serif;
        }

        body {
            background-color: var(--bg);
            margin: 0;
            padding: 0;
            color: var(--text);
        }

        /* الهيدر */
        header {
            background: var(--primary);
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: var(--white);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            text-align: center;
            color: var(--driver);
            margin-top: 0;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        /* الفورم */
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        .btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            transition: 0.3s;
        }
        .btn-start { background: var(--primary); color: white; }
        .btn-end { background: var(--danger); color: white; margin-top: 20px; }

        /* تنسيق بيانات الرحلة */
        .trip-info {
            background: #e9ecef;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-right: 5px solid var(--primary);
            display: flex;
            justify-content: space-between;
        }

        /* تنسيق العربية والمقاعد */
        .car-layout {
            background-color: #fff; border: 3px solid #444; border-radius: 30px 30px 10px 10px;
            padding: 25px; width: 280px; margin: 20px auto; display: flex; flex-direction: column; gap: 15px; direction: ltr;
        }
        .seat-row { display: flex; justify-content: space-around; gap: 10px; }
        
        .seat {
            width: 55px; height: 55px; border-radius: 8px; display: flex; flex-direction: column;
            justify-content: center; align-items: center; font-size: 0.7rem; font-weight: bold;
            cursor: pointer; transition: 0.3s; position: relative; text-align: center;
        }
        .seat.driver { background: var(--driver); color: white; cursor: default; }
        .seat.available { background: var(--available); color: #888; border: 1px dashed #ccc; }
        .seat.booked { background: var(--danger); color: white; box-shadow: 0 4px 0 #b32432; }
        .seat.boarded { background: var(--secondary); color: white; box-shadow: 0 4px 0 #1e7e34; }
        .seat.boarded::after { content: "✅"; position: absolute; top: -5px; right: -5px; font-size: 0.8rem; }
        .seat span { display: block; width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; padding: 0 2px; }

        /* مفتاح الخريطة */
        .legend { display: flex; justify-content: center; gap: 10px; margin-bottom: 20px; font-size: 0.8rem; flex-wrap: wrap; }
        .legend-item { display: flex; align-items: center; gap: 5px; }
        .box { width: 15px; height: 15px; border-radius: 3px; }

        /* تفاصيل الراكب المختار من العربية */
        #passenger-detail-card {
            display: none; background: #fffde7; border: 1px solid #fbc02d;
            padding: 15px; border-radius: 10px; margin-top: 20px; margin-bottom: 20px;
        }
        .btn-confirm {
            background: var(--secondary); color: white; border: none; padding: 10px;
            width: 100%; border-radius: 5px; cursor: pointer; font-weight: bold; margin-top: 10px;
        }

        /* ---------------------------------------------------
           تنسيق قائمة الركاب على الطريق (الجديد)
           --------------------------------------------------- */
        .road-passengers-section {
            margin-top: 30px;
            border-top: 2px dashed #ddd;
            padding-top: 20px;
        }
        .passenger-list-item {
            background: #f8f9fa;
            border-right: 5px solid var(--danger); /* أحمر لأنهم لسه ماركبوش */
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .p-details {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: 0.9rem;
        }
        .p-details strong { font-size: 1.1rem; color: var(--text); }
        .p-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .btn-call {
            background: var(--primary); color: white; text-decoration: none;
            padding: 8px 12px; border-radius: 5px; text-align: center; font-size: 0.85rem; font-weight: bold;
        }
        .btn-board {
            background: var(--secondary); color: white; border: none;
            padding: 8px 12px; border-radius: 5px; cursor: pointer; font-size: 0.85rem; font-weight: bold;
        }
        .empty-road-msg {
            text-align: center; color: var(--secondary); font-weight: bold; padding: 20px;
            background: #e8f5e9; border-radius: 8px;
        }

        .hidden { display: none !important; }
    </style>
</head>
<body>
    <header>
        <h2 id="driverNameHeader" style="color: white; border:none;">كابتن: محمد علي</h2>
        <p id="vehicleInfo">ميكروباص تربو - ط س ر 1234</p>
    </header>

    <div class="container" id="setup-section">
        <h3>بدء رحلة جديدة</h3>
        <div class="form-group">
            <label>خط السير</label>
            <select id="routeSelect">
                <option value="رمسيس - المعادي">رمسيس - المعادي</option>
                <option value="الجيزة - أكتوبر">الجيزة - أكتوبر</option>
                <option value="مدينة نصر - التجمع">مدينة نصر - التجمع</option>
            </select>
        </div>
        <div class="form-group">
            <label>وقت التحرك التقريبي</label>
            <input type="time" id="departureTime" />
        </div>
        <button class="btn btn-start" onclick="startTrip()">
            فتح باب الحجز ومتابعة الرحلة
        </button>
    </div>

    <div class="container hidden" id="dashboard-section">
        <h3>لوحة تحكم الرحلة 🚐</h3>

        <div class="trip-info">
            <div>
                <strong>الرحلة:</strong> <span id="routeTitle">--</span><br />
                <strong>الساعة:</strong> <span id="timeTitle">--</span>
            </div>
            <div>
                <strong>السيارة:</strong> <span id="vehicleTitle">ميكروباص تربو</span>
            </div>
        </div>

        <div class="legend">
            <div class="legend-item"><div class="box" style="background: var(--available)"></div>فاضي</div>
            <div class="legend-item"><div class="box" style="background: var(--danger)"></div>محجوز (على الطريق)</div>
            <div class="legend-item"><div class="box" style="background: var(--secondary)"></div>ركب خلاص</div>
        </div>

        <div class="car-layout" id="driverCarLayout"></div>

        <div id="passenger-detail-card">
            <h4 style="margin: 0; color: #333; border:none;">بيانات الراكب:</h4>
            <div id="p-info">اضغط على كرسي محجوز لعرض البيانات</div>
            <button class="btn-confirm" id="confirmBtn" onclick="confirmBoardingFromModal()">
                تأكيد صعود الراكب
            </button>
        </div>

        <div class="road-passengers-section">
            <h3>📍 الركاب على الطريق (في الانتظار)</h3>
            <div id="roadPassengersList"></div>
        </div>

        <button class="btn btn-end" onclick="finishTrip()">
            إنهاء الرحلة / وصلنا
        </button>
    </div>

    <script>
        // بيانات ركاب افتراضية (بعضهم ركب وبعضهم لسه)
        const tripData = {
            vehicleType: "ميكروباص تربو",
            passengers: {
                3: { name: "أحمد سيد", phone: "01012345678", bags: 2, pickup: "مترو المعادي", status: "booked" },
                5: { name: "سارة محمد", phone: "01288776655", bags: 0, pickup: "كارفور", status: "boarded" },
                8: { name: "محمود حسن", phone: "01155443322", bags: 1, pickup: "ميدان رمسيس", status: "booked" },
                12: { name: "طارق علي", phone: "01555667788", bags: 3, pickup: "الدمرداش", status: "booked" }
            },
        };

        let selectedSeatForAction = null;

        function startTrip() {
            const route = document.getElementById("routeSelect").value;
            const time = document.getElementById("departureTime").value;

            if (!time) { alert("يا كابتن حدد وقت التحرك عشان الركاب يعرفوا"); return; }

            document.getElementById("setup-section").classList.add("hidden");
            document.getElementById("dashboard-section").classList.remove("hidden");
            document.getElementById("routeTitle").innerText = route;
            document.getElementById("timeTitle").innerText = time;

            // تحديث الرسمة والقائمة
            updateDashboard();
        }

        // دالة مجمعة لتحديث كل حاجة (الرسمة + القائمة)
        function updateDashboard() {
            renderDriverLayout();
            renderRoadPassengers();
        }

        // رسم مقاعد السيارة
        function renderDriverLayout() {
            const layout = document.getElementById("driverCarLayout");
            layout.innerHTML = "";
            let seatNum = 1;

            const createSeatHTML = (num) => {
                const p = tripData.passengers[num];
                if (p) {
                    const statusClass = p.status === "boarded" ? "boarded" : "booked";
                    return `<div class="seat ${statusClass}" onclick="showPassenger('${num}')">
                                <span>${num}</span>
                                <span>${p.name.split(" ")[0]}</span>
                            </div>`;
                }
                return `<div class="seat available"><span>${num}</span><span style="font-size:0.5rem">فاضي</span></div>`;
            };

            if (tripData.vehicleType === "ميكروباص تربو") {
                layout.innerHTML += `<div class="seat-row"><div class="seat driver">D</div>${createSeatHTML(seatNum++)}${createSeatHTML(seatNum++)}</div><hr style="width:100%">`;
                for (let i = 0; i < 3; i++) {
                    layout.innerHTML += `<div class="seat-row">${createSeatHTML(seatNum++)}${createSeatHTML(seatNum++)}${createSeatHTML(seatNum++)}</div>`;
                }
                layout.innerHTML += `<div class="seat-row">${createSeatHTML(seatNum++)}${createSeatHTML(seatNum++)}${createSeatHTML(seatNum++)}${createSeatHTML(seatNum++)}</div>`;
            }
        }

        // عرض قائمة الركاب اللي على الطريق
        function renderRoadPassengers() {
            const listContainer = document.getElementById("roadPassengersList");
            listContainer.innerHTML = "";
            let waitingCount = 0;

            // نلف على كل الركاب ونشوف مين لسه ماركبش
            for (const [seatNum, p] of Object.entries(tripData.passengers)) {
                if (p.status === "booked") {
                    waitingCount++;
                    listContainer.innerHTML += `
                        <div class="passenger-list-item">
                            <div class="p-details">
                                <strong>${p.name} (كرسي رقم ${seatNum})</strong>
                                <span>📍 <b>المكان:</b> ${p.pickup}</span>
                                <span>💼 <b>الشنط:</b> ${p.bags}</span>
                                <span>📱 <b>الموبايل:</b> ${p.phone}</span>
                            </div>
                            <div class="p-actions">
                                <a href="tel:${p.phone}" class="btn-call">📞 اتصال</a>
                                <button class="btn-board" onclick="confirmBoardingDirectly('${seatNum}')">✅ ركب خلاص</button>
                            </div>
                        </div>
                    `;
                }
            }

            // لو مفيش حد مستني
            if (waitingCount === 0) {
                listContainer.innerHTML = `<div class="empty-road-msg">✅ مفيش حد مستني على الطريق، كمل طريقك بسلامة!</div>`;
            }
        }

        // إظهار بيانات الراكب عند الضغط على الكرسي
        function showPassenger(num) {
            const p = tripData.passengers[num];
            selectedSeatForAction = num;

            const card = document.getElementById("passenger-detail-card");
            const info = document.getElementById("p-info");
            const btn = document.getElementById("confirmBtn");

            card.style.display = "block";
            info.innerHTML = `
                <b>الاسم:</b> ${p.name} (كرسي ${num})<br>
                <b>تليفون:</b> <a href="tel:${p.phone}">${p.phone}</a><br>
                <b>المكان:</b> ${p.pickup}<br>
                <b>الشنط:</b> ${p.bags}
            `;

            btn.style.display = p.status === "boarded" ? "none" : "block";
        }

        // تأكيد الركوب من الكارت المنبثق (تحت الرسمة)
        function confirmBoardingFromModal() {
            if (selectedSeatForAction) {
                tripData.passengers[selectedSeatForAction].status = "boarded";
                document.getElementById("passenger-detail-card").style.display = "none";
                updateDashboard(); // تحديث الرسمة والقائمة
            }
        }

        // تأكيد الركوب مباشرة من القائمة اللي تحت
        function confirmBoardingDirectly(seatNum) {
            tripData.passengers[seatNum].status = "boarded";
            // لو كان الكارت مفتوح لنفس الراكب نقفله
            if (selectedSeatForAction === seatNum) {
                document.getElementById("passenger-detail-card").style.display = "none";
            }
            updateDashboard(); // تحديث الرسمة والقائمة
        }

        // إنهاء الرحلة
        function finishTrip() {
            if (confirm("هل وصلت للوجهة النهائية وتريد إنهاء الرحلة؟")) {
                location.reload(); 
            }
        }
    </script>
</body>
</html>