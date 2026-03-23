<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - وصلني</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <div class="container">
        <h2>تسجيل الدخول</h2>
        <form id="loginForm" onsubmit="handleLogin(event)">
            <div class="form-group">
                <label>رقم الهاتف</label>
                <input type="tel" name="phone" id="loginPhone" required placeholder="01X XXXX XXXX">
            </div>

            <div class="form-group">
                <label>كلمة المرور</label>
                <div class="password-wrapper">
                    <input type="password" name="password" id="loginPass" required placeholder="********">
                    <span class="toggle-password" onclick="togglePasswordVisibility('loginPass', this)">👁️</span>
                </div>
            </div>

            <div class="form-group">
                <label>دخول كـ</label>
                <select name="role" id="loginRole">
                    <option value="passenger">راكب</option>
                    <option value="driver">سائق</option>
                </select>
            </div>

            <button type="submit" class="submit-btn">دخول</button>
            <p style="margin-top: 15px; text-align: center;">
                ليس لديك حساب؟ <a href="passenger&driver_login.php">إنشاء حساب جديد</a>
            </p>
        </form>
    </div>

    <script>
        // دالة إظهار الباسورد (نفس اللي عملناها قبل كدة)
        function togglePasswordVisibility(inputId, icon) {
            const input = document.getElementById(inputId);
            input.type = input.type === "password" ? "text" : "password";
            icon.textContent = input.type === "password" ? "👁️" : "🙈";
        }

        function handleLogin(event) {
            event.preventDefault();
            const formData = new FormData(event.target);

            fetch("api/login_process.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                if (res.status === "success") {
                    // التوجيه بناءً على الدور (Role)
                    window.location.href = res.role + "_dashboard.php"; 
                } else {
                    alert("خطأ: " + res.message);
                }
            })
            .catch(() => alert("فشل الاتصال بالسيرفر"));
        }

        const phone = document.getElementById("loginPhone");
        if (phone) {
          phone.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "").slice(0, 11);
          });
        }
    </script>
</body>
</html>