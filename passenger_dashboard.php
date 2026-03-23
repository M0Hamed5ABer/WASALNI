<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>حجز رحلة جديدة</title>
    <style>
      :root {
        --primary-color: #0066cc;
        --secondary-color: #28a745;
        --bg-color: #f4f7f6;
        --card-bg: #ffffff;
        --text-color: #333333;
        --border-radius: 12px;
        --seat-available: #e0e0e0;
        --seat-selected: #28a745;
        --seat-occupied: #dc3545;
        --seat-driver: #343a40;
      }

      * {
        box-sizing: border-box;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      }

      body {
        background-color: var(--bg-color);
        margin: 0;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
      }

      .container {
        background-color: var(--card-bg);
        width: 100%;
        max-width: 500px;
        padding: 30px 20px;
        border-radius: var(--border-radius);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
      }

      h2 {
        text-align: center;
        color: var(--text-color);
        margin-top: 0;
        margin-bottom: 25px;
        font-size: 1.5rem;
      }

      .form-group {
        margin-bottom: 15px;
        position: relative; /* ضروري عشان قائمة الاقتراحات تظهر تحته مباشرة */
      }

      .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-color);
        font-size: 0.9rem;
      }

      .form-group input,
      .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s;
      }

      .form-group input:focus,
      .form-group select:focus {
        outline: none;
        border-color: var(--primary-color);
      }

      /* تنسيق صندوق الاقتراحات */
      .suggestions-box {
        position: absolute;
        top: 100%;
        right: 0;
        left: 0;
        background: white;
        border: 1px solid #ccc;
        border-top: none;
        max-height: 150px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }

      .suggestion-item {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
      }

      .suggestion-item:hover {
        background-color: #f1f1f1;
      }

      .submit-btn {
        width: 100%;
        padding: 14px;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: bold;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.3s;
      }

      .submit-btn:hover {
        background-color: #005bb5;
      }

      /* تنسيق قائمة السائقين */
      #drivers-section {
        display: none;
        margin-top: 20px;
        border-top: 2px solid #eee;
        padding-top: 20px;
      }

      .driver-card {
        border: 1px solid #ccc;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .driver-card:hover,
      .driver-card.selected {
        border-color: var(--primary-color);
        background-color: #f0f7ff;
      }

      /* تنسيق رسم السيارة والمقاعد */
      #booking-section {
        display: none;
        margin-top: 20px;
        border-top: 2px solid #eee;
        padding-top: 20px;
      }

      .car-layout {
        background-color: #f8f9fa;
        border: 2px solid #ddd;
        border-radius: 20px 20px 10px 10px;
        padding: 20px;
        width: 250px;
        margin: 0 auto 20px auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        direction: ltr; /* الترتيب من اليسار لليمين عشان السواق على الشمال */
      }

      .seat-row {
        display: flex;
        justify-content: space-around;
        gap: 10px;
      }

      .seat {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        color: #333;
        cursor: pointer;
        transition: 0.2s;
        font-size: 0.9rem;
      }

      .seat.driver {
        background-color: var(--seat-driver);
        color: white;
        cursor: not-allowed;
      }

      .seat.available {
        background-color: var(--seat-available);
      }

      .seat.available:hover {
        background-color: #ccc;
      }

      .seat.occupied {
        background-color: var(--seat-occupied);
        color: white;
        cursor: not-allowed;
      }

      .seat.selected {
        background-color: var(--seat-selected);
        color: white;
      }

      .seat-legend {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 20px;
        font-size: 0.85rem;
      }

      .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
      }

      .legend-color {
        width: 15px;
        height: 15px;
        border-radius: 3px;
      }

      .summary-box {
        background-color: #e9ecef;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
      }

      .summary-text {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
        font-weight: bold;
      }
      hr {
        width: 100%;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2>حجز رحلة جديدة</h2>

      <form id="searchForm" onsubmit="searchDrivers(event)">
        <div class="form-group">
          <label for="routeSelect">خط السير</label>
          <select id="routeSelect" required>
            <option value="">اختر خط السير...</option>
            <option value="ramses-maadi">رمسيس - المعادي</option>
            <option value="giza-october">الجيزة - أكتوبر</option>
            <option value="nasr-tagamoa">مدينة نصر - التجمع</option>
          </select>
        </div>

        <div class="form-group">
          <label for="pickupPoint">مكان الركوب بالتحديد</label>
          <input
            type="text"
            id="pickupPoint"
            placeholder="ابحث أو اكتب مكان الركوب..."
            required
            autocomplete="off"
          />
          <div id="pickupSuggestions" class="suggestions-box"></div>
        </div>

        <div class="form-group">
          <label for="dropoffPoint">مكان النزول بالتحديد</label>
          <input
            type="text"
            id="dropoffPoint"
            placeholder="ابحث أو اكتب مكان النزول..."
            required
            autocomplete="off"
          />
          <div id="dropoffSuggestions" class="suggestions-box"></div>
        </div>

        <button type="submit" class="submit-btn" id="searchBtn">
          البحث عن سائقين
        </button>
      </form>

      <div id="drivers-section">
        <h3>السائقين المتاحين حالياً</h3>
        <div id="driversList"></div>
      </div>

      <div id="booking-section">
        <h3>اختر مقعدك</h3>

        <div class="seat-legend">
          <div class="legend-item">
            <div
              class="legend-color"
              style="background: var(--seat-available)"
            ></div>
            متاح
          </div>
          <div class="legend-item">
            <div
              class="legend-color"
              style="background: var(--seat-selected)"
            ></div>
            محدد
          </div>
          <div class="legend-item">
            <div
              class="legend-color"
              style="background: var(--seat-occupied)"
            ></div>
            مشغول
          </div>
        </div>

        <div class="car-layout" id="carLayout"></div>

        <div class="form-group">
          <label for="bagsCount">عدد الشنط (اختياري)</label>
          <input
            type="number"
            id="bagsCount"
            min="0"
            max="5"
            value="0"
            onchange="updateSummary()"
          />
        </div>

        <div class="summary-box">
          <div class="summary-text">
            <span>الوقت المقدر:</span> <span id="estTime">--</span>
          </div>
          <div class="summary-text">
            <span>إجمالي السعر:</span> <span id="totalPrice">0 جنيه</span>
          </div>
        </div>

        <button
          type="button"
          class="submit-btn"
          style="background-color: var(--secondary-color)"
          onclick="confirmBooking()"
        >
          تأكيد الحجز
        </button>
      </div>
    </div>

    <script>
      // ==========================================
      // تحميل الخطوط
      // ==========================================
      async function loadRoutes() {
        const res = await fetch("http://localhost/wasalni/api/get_routes.php");
        const routes = await res.json();

        const select = document.getElementById("routeSelect");

        routes.forEach((route) => {
          const option = document.createElement("option");
          option.value = route.id;
          option.textContent = route.name;
          select.appendChild(option);
        });
      }

      loadRoutes();

      // ==========================================
      // تحميل المحطات حسب الخط
      // ==========================================
      let commonLocations = [];

      document
        .getElementById("routeSelect")
        .addEventListener("change", async function () {
          const routeId = this.value;

          const res = await fetch(
            `http://localhost/wasalni/api/get_stations.php?route_id=${routeId}`,
          );
          const stations = await res.json();

          commonLocations = stations.map((s) => s.name);
        });

      // ==========================================
      // Autocomplete
      // ==========================================
      function setupAutocomplete(inputId, suggestionsId, otherInputId) {
        const input = document.getElementById(inputId);
        const suggestionsBox = document.getElementById(suggestionsId);

        input.addEventListener("input", function () {
          const value = this.value.trim();
          const otherValue = document.getElementById(otherInputId).value;

          suggestionsBox.innerHTML = "";

          if (!value) {
            suggestionsBox.style.display = "none";
            return;
          }

          const filtered = commonLocations.filter(
            (loc) => loc.includes(value) && loc !== otherValue,
          );

          if (filtered.length === 0) {
            suggestionsBox.style.display = "none";
            return;
          }

          filtered.forEach((loc) => {
            const div = document.createElement("div");
            div.className = "suggestion-item";
            div.textContent = loc;

            div.onclick = function () {
              input.value = loc;
              suggestionsBox.style.display = "none";

              if (inputId === "pickupPoint") {
                bookingData.pickupLocation = loc;
              } else {
                bookingData.dropoffLocation = loc;
              }
            };

            suggestionsBox.appendChild(div);
          });

          suggestionsBox.style.display = "block";
        });

        document.addEventListener("click", function (e) {
          if (!input.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.style.display = "none";
          }
        });
      }

      setupAutocomplete("pickupPoint", "pickupSuggestions", "dropoffPoint");
      setupAutocomplete("dropoffPoint", "dropoffSuggestions", "pickupPoint");

      // ==========================================
      // State
      // ==========================================
      let bookingData = {
        routeId: null,
        pickupLocation: "",
        dropoffLocation: "",
        driverId: null,
        driverName: "",
        vehicleType: "",
        selectedSeats: [],
        bagsCount: 0,
        totalPrice: 0,
        estimatedTime: "",
      };

      let currentDriverBasePrice = 0;

      // ==========================================
      // البحث عن السائقين (النسخة الصح)
      // ==========================================
      async function searchDrivers(event) {
        event.preventDefault();

        const routeId = document.getElementById("routeSelect").value;
        const pickup = document.getElementById("pickupPoint").value;
        const dropoff = document.getElementById("dropoffPoint").value;

        bookingData.routeId = routeId;
        bookingData.pickupLocation = pickup;
        bookingData.dropoffLocation = dropoff;

        const driversSection = document.getElementById("drivers-section");
        const driversList = document.getElementById("driversList");

        driversSection.style.display = "block";
        driversList.innerHTML = "جاري البحث...";

        try {
          const res = await fetch(
            `http://localhost/wasalni/api/get_drivers.php?route_id=${routeId}`,
          );

          const text = await res.text();
          console.log("FULL RESPONSE ↓↓↓");
          console.log(text);

          // وقف التنفيذ مؤقتاً
          return;

          // متشيلش دول دلوقتي
          // const drivers = JSON.parse(text);

          const drivers = JSON.parse(text);
          driversList.innerHTML = "";

          if (!drivers || drivers.length === 0) {
            driversList.innerHTML = "<p>لا يوجد سائقين حالياً 🚫</p>";
            return;
          }

          drivers.forEach((driver) => {
            const card = document.createElement("div");
            card.className = "driver-card";

            card.innerHTML = `
        <div>
          <strong>${driver.name}</strong><br>
          <small>${driver.vehicle_type}</small>
        </div>
        <div>
          <strong>${driver.price} ج</strong>
        </div>
      `;

            card.onclick = () =>
              selectDriver(
                {
                  id: driver.id,
                  name: driver.name,
                  vehicle: driver.vehicle_type,
                  time: "45 دقيقة",
                  price: driver.price,
                },
                card,
              );

            driversList.appendChild(card);
          });
        } catch (err) {
          driversList.innerHTML = "<p>حصل خطأ في تحميل السائقين ❌</p>";
          console.error(err);
        }
      }

      // ==========================================
      // اختيار السائق
      // ==========================================
      function selectDriver(driver, cardElement) {
        document
          .querySelectorAll(".driver-card")
          .forEach((c) => c.classList.remove("selected"));

        cardElement.classList.add("selected");

        bookingData.driverId = driver.id;
        bookingData.driverName = driver.name;
        bookingData.vehicleType = driver.vehicle;
        bookingData.estimatedTime = driver.time;
        bookingData.selectedSeats = [];

        currentDriverBasePrice = driver.price;

        document.getElementById("booking-section").style.display = "block";
        document.getElementById("estTime").innerText = driver.time;

        renderCarSeats(driver.vehicle);
        updateSummary();
      }

      // ==========================================
      // رسم المقاعد
      // ==========================================
      function renderCarSeats(vehicleType) {
        const carLayout = document.getElementById("carLayout");
        carLayout.innerHTML = "";

        const occupiedSeats = [2, 5];
        let seatNum = 1;

        const createSeat = (num) => {
          const status = occupiedSeats.includes(num) ? "occupied" : "available";
          return `<div class="seat ${status}" onclick="toggleSeat(this, ${num})">${num}</div>`;
        };

        if (vehicleType === "ميني باص") {
          carLayout.innerHTML += `<div class="seat-row"><div class="seat driver">D</div>${createSeat(seatNum++)}</div>`;
          carLayout.innerHTML += `<hr>`;
          carLayout.innerHTML += `<div class="seat-row">${createSeat(seatNum++)}${createSeat(seatNum++)}${createSeat(seatNum++)}</div>`;
          carLayout.innerHTML += `<div class="seat-row">${createSeat(seatNum++)}${createSeat(seatNum++)}${createSeat(seatNum++)}</div>`;
        } else {
          carLayout.innerHTML += `<div class="seat-row"><div class="seat driver">D</div>${createSeat(seatNum++)}${createSeat(seatNum++)}</div>`;
          carLayout.innerHTML += `<hr>`;

          for (let i = 0; i < 4; i++) {
            carLayout.innerHTML += `<div class="seat-row">${createSeat(seatNum++)}${createSeat(seatNum++)}${createSeat(seatNum++)}</div>`;
          }
        }
      }

      // ==========================================
      // اختيار الكراسي
      // ==========================================
      function toggleSeat(seatElement, seatNumber) {
        if (seatElement.classList.contains("occupied")) return;

        if (seatElement.classList.contains("selected")) {
          seatElement.classList.remove("selected");
          seatElement.classList.add("available");

          bookingData.selectedSeats = bookingData.selectedSeats.filter(
            (s) => s !== seatNumber,
          );
        } else {
          seatElement.classList.remove("available");
          seatElement.classList.add("selected");

          bookingData.selectedSeats.push(seatNumber);
        }

        updateSummary();
      }

      // ==========================================
      // الحساب
      // ==========================================
      function updateSummary() {
        const bags = parseInt(document.getElementById("bagsCount").value) || 0;

        bookingData.bagsCount = bags;
        bookingData.totalPrice =
          bookingData.selectedSeats.length * currentDriverBasePrice + bags * 10;

        document.getElementById("totalPrice").innerText =
          bookingData.totalPrice + " جنيه";
      }

      // ==========================================
      // تأكيد الحجز
      // ==========================================
      function confirmBooking() {
        if (bookingData.selectedSeats.length === 0) {
          alert("اختار مقعد الأول");
          return;
        }

        console.log("Booking Data:", bookingData);

        alert("تم الحجز بنجاح ✅");
      }
    </script>
  </body>
</html>
