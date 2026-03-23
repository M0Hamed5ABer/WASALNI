<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسجيل المواصلات العامة</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="container">
      <h2>تسجيل الدخول / إنشاء حساب</h2>

      <div class="role-toggle">
        <button
          type="button"
          class="role-btn active"
          id="btn-passenger"
          onclick="switchRole('passenger')"
        >
          راكب
        </button>
        <button
          type="button"
          class="role-btn"
          id="btn-driver"
          onclick="switchRole('driver')"
        >
          سائق
        </button>
      </div>
      <!----------------------------------- passenger form --------------------------------------------->
      <form
        id="passengerForm"
        onsubmit="submitPassenger(event)"
        style="display: block"
      >
        <div class="form-group">
          <label>الاسم الكامل</label>
          <input type="text" name="name" required placeholder="أدخل اسمك" />
        </div>
        <div class="form-group">
          <label>النوع</label>
          <select name="gender" required>
            <option value="male">ذكر</option>
            <option value="female">أنثى</option>
          </select>
        </div>
        <div class="form-group">
          <label>رقم الهاتف</label>
          <input
            type="tel"
            name="phone"
            id="pphone"
            placeholder="01X XXXX XXXX"
            required
          />
        </div>
        <!-- passenger type -->
        <div class="form-group">
          <label>نوع الراكب</label>
          <select
            name="passengerType"
            id="passengerType"
            onchange="toggleStudentField()"
            required
          >
            <option value="normal">شخص عادي</option>
            <option value="student">طالب</option>
          </select>
        </div>
        <div id="student-proof" style="display: none">
          <div class="form-group">
            <label>إثبات الطالب (كارنيه)</label>
            <input
              type="file"
              name="studentId"
              id="studentId"
              accept="image/*"
            />
          </div>
        </div>
        <!-- password -->
        <div class="form-group">
          <label>كلمة المرور</label>
          <div class="password-wrapper">
            <input
              type="password"
              id="pass-passenger"
              name="password"
              placeholder="********"
              required
            />
            <span
              class="toggle-password"
              onclick="togglePasswordVisibility('pass-passenger', this)"
              >👁️</span
            >
          </div>
        </div>
        <!-- password -->
        <div class="form-group">
          <label>تأكيد كلمة المرور</label>
          <div class="password-wrapper">
            <input
              type="password"
              id="confirm-pass-passenger"
              placeholder="********"
              required
            />
            <span
              class="toggle-password"
              onclick="togglePasswordVisibility('confirm-pass-passenger', this)"
              >👁️</span
            >
          </div>
          <p
            id="err-passenger"
            class="error-msg"
            style="color: red; display: none"
          >
            كلمة المرور غير متطابقة!
          </p>
        </div>
        <!-- terms -->
        <div class="form-group terms">
          <label class="checkbox-container">
            <input type="checkbox" id="terms-passenger" required />
            <span class="checkmark"></span>
            أوافق على <a href="#" target="_blank">الشروط والأحكام</a>
          </label>
        </div>
        <button type="submit" class="submit-btn">متابعة كراكب</button>
        <p style="margin-top: 15px; text-align: center;">
                  لدي حساب بالفعل  <a href="index.php">  تسجيل الدخول</a>
            </p>
      </form>
      <!----------------------------------- driver form --------------------------------------------->
      <form
        id="driverForm"
        onsubmit="submitDriver(event)"
        style="display: none"
      >
        <div class="form-group">
          <label>الاسم الكامل</label>
          <input type="text" name="name" required placeholder="أدخل اسمك" />
        </div>
        <div class="form-group" required>
          <label>النوع</label>
          <select name="gender">
            <option value="male">ذكر</option>
            <option value="female">أنثى</option>
          </select>
        </div>
        <div class="form-group">
          <label>رقم الهاتف</label>
          <input
            type="text"
            name="phone"
            id="dphone"
            placeholder="01X XXXX XXXX"
            required
          />
        </div>
        <div class="form-group">
          <label>الرقم القومي</label>
          <input
            type="text"
            name="nationalId"
            id="nationalId"
            maxlength="14"
            placeholder="xxxxx"
            required
          />
        </div>
        <div class="form-group">
          <label>خط السير</label>
          <div class="autocomplete">
            <input
              type="text"
              id="route"
              placeholder="رمسيس - المعادي"
              required
              autocomplete="off"
            />
            <input type="hidden" name="route_id" id="route_id" />
            <div id="routeSuggestions" class="suggestions-box"></div>
          </div>
        </div>

        <div class="form-group">
          <label>نوع السيارة</label>
          <select name="vehicleType" id="vehicleType" required>
            <option value="">اختر نوع السيارة</option>
            <option value="ميكروباص">ميكروباص</option>
            <option value="ميكروباص تربو">ميكروباص تربو</option>
            <option value="ميني باص">ميني باص</option>
          </select>
        </div>
        <div class="form-group">
          <label>رقم السيارة</label>
          <div class="plate-container">
            <input
              type="text"
              id="plateLetters"
              placeholder="أ ب ج"
              maxlength="5"
              required
            />
            <input
              type="text"
              id="plateNumbers"
              placeholder="1234"
              maxlength="4"
              required
            />
          </div>
        </div>
        <div class="form-group">
          <label>كلمة المرور</label>
          <div class="password-wrapper">
            <input
              type="password"
              id="pass-driver"
              name="password"
              required
              placeholder="********"
            />
            <span
              class="toggle-password"
              onclick="togglePasswordVisibility('pass-driver', this)"
              >👁️</span
            >
          </div>
        </div>
        <div class="form-group">
          <label>تأكيد كلمة المرور</label>
          <div class="password-wrapper">
            <input
              type="password"
              id="confirm-pass-driver"
              required
              placeholder="********"
            />
            <span
              class="toggle-password"
              onclick="togglePasswordVisibility('confirm-pass-driver', this)"
              >👁️</span
            >
          </div>
          <p
            id="err-driver"
            class="error-msg"
            style="color: red; display: none"
          >
            كلمة المرور غير متطابقة!
          </p>
        </div>
        <!-- terms -->
        <div class="form-group terms">
          <label class="checkbox-container">
            <input type="checkbox" id="terms-driver" required />
            <span class="checkmark"></span>
            أوافق على <a href="terms.html" target="_blank">الشروط والأحكام</a>
          </label>
        </div>

        <button type="submit" class="submit-btn">متابعة كسائق</button>
        <p style="margin-top: 15px; text-align: center;">
                  لدي حساب بالفعل  <a href="index.php">  تسجيل الدخول</a>
            </p>
      </form>
    </div>

    <script>
      // switchRole
      function switchRole(role) {
        document.getElementById("passengerForm").style.display =
          role === "passenger" ? "block" : "none";
        document.getElementById("driverForm").style.display =
          role === "driver" ? "block" : "none";
        document
          .getElementById("btn-passenger")
          .classList.toggle("active", role === "passenger");
        document
          .getElementById("btn-driver")
          .classList.toggle("active", role === "driver");
      }

      // suggitions
      const routeInput = document.getElementById("route");
      const suggestionBox = document.getElementById("routeSuggestions");
      const routeIdInput = document.getElementById("route_id");

      routeInput.addEventListener("input", async function () {
        const value = this.value.trim();

        suggestionBox.innerHTML = "";
        routeIdInput.value = ""; // مهم: نفضي الـ ID لو المستخدم كتب

        if (!value) {
          suggestionBox.style.display = "none";
          return;
        }

        try {
          const res = await fetch(
            `http://localhost/wasalni/api/get_routes.php?q=${value}`,
          );

          const data = await res.json();

          if (data.length === 0) {
            suggestionBox.style.display = "none";
            return;
          }

          data.forEach((route) => {
            const div = document.createElement("div");
            div.classList.add("suggestion-item");
            div.textContent = route.name;

            div.onclick = () => {
              routeInput.value = route.name;
              routeIdInput.value = route.id; // 👈 ده المهم
              suggestionBox.style.display = "none";
            };

            suggestionBox.appendChild(div);
          });

          suggestionBox.style.display = "block";
        } catch (err) {
          console.error(err);
        }
      });

      // passwoed
      function togglePasswordVisibility(inputId, icon) {
        const input = document.getElementById(inputId);
        input.type = input.type === "password" ? "text" : "password";
        icon.textContent = input.type === "password" ? "👁️" : "🙈";
      }

      function showPasswordError(errorId) {
        const err = document.getElementById(errorId);
        err.style.display = "block";
        setTimeout(() => (err.style.display = "none"), 3000);
      }
      // send data
      function sendData(formData) {
  fetch("http://localhost/wasalni/api/register.php", {
    method: "POST",
    body: formData,
  })
    .then(async (res) => {
      const text = await res.text(); // نستلم الرد كنص أولاً عشان نشوفه لو فيه غلط
      try {
        return JSON.parse(text); // نحاول نحوله لـ JSON
      } catch (err) {
        console.error("السيرفر بعت رد مش JSON:", text); // هيطبع لك هنا لو فيه Error من PHP
        throw new Error("رد السيرفر غير صالح");
      }
    })
    .then((res) => {
      if (res.status === "success") {
        alert("تم التسجيل بنجاح");
        window.location.href = formData.get("role") + ".html";
      } else {
        alert("خطأ: " + res.message);
      }
    })
    .catch((err) => {
      console.error(err);
      alert("فشل الاتصال بالسيرفر.. راجع الـ Console");
    });
  }
      // submitPassenger
      function submitPassenger(event) {
        event.preventDefault();

        if (!document.getElementById("terms-passenger").checked) {
          alert("يجب الموافقة على الشروط والأحكام");
          return;
        }

        if (
          document.getElementById("pass-passenger").value !==
          document.getElementById("confirm-pass-passenger").value
        ) {
          showPasswordError("err-passenger");
          return;
        }

        const formData = new FormData(event.target);
        formData.append("role", "passengers");
        sendData(formData);
      }
      // submitDriver
      function submitDriver(event) {
        event.preventDefault();

        if (!document.getElementById("terms-driver").checked) {
          alert("يجب الموافقة على الشروط والأحكام");
          return;
        }

        if (!document.getElementById("route_id").value) {
          alert("من فضلك اختر خط من القائمة");
          return;
        }
        if (
          document.getElementById("pass-driver").value !==
          document.getElementById("confirm-pass-driver").value
        ) {
          showPasswordError("err-driver");
          return;
        }

        const formData = new FormData(event.target);
        formData.append("role", "drivers");

        formData.append(
          "plate",
          document.getElementById("plateLetters").value +
            " " +
            document.getElementById("plateNumbers").value,
        );

        sendData(formData);
      }
      // if passenger is student
      function toggleStudentField() {
        const type = document.getElementById("passengerType").value;
        document.getElementById("student-proof").style.display =
          type === "student" ? "block" : "none";
      }

      // التحقق من وجود العناصر قبل إضافة الـ Listeners لمنع خطأ الـ Null
      document.addEventListener("DOMContentLoaded", () => {
        const vehicleInput = document.getElementById("vehicleType");
        if (vehicleInput) {
          vehicleInput.addEventListener("change", function () {
            const seats = { "ميني باص": 7, ميكروباص: 14, "ميكروباص تربو": 15 }[
              this.value
            ];
            console.log("المقاعد:", seats);
          });
        }
        // limits
        const pphone = document.getElementById("pphone");
        if (pphone) {
          pphone.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "").slice(0, 11);
          });
        }
        const dphone = document.getElementById("dphone");
        if (dphone) {
          dphone.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "").slice(0, 11);
          });
        }

        const nationalIdInput = document.getElementById("nationalId");
        if (nationalIdInput) {
          nationalIdInput.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "").slice(0, 14);
          });
        }
      });
    </script>
  </body>
</html>
