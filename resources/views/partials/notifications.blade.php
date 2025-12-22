<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعارات فورية</title>
    <style>
        #notifications {
            position: fixed; /* ثابت أعلى الصفحة */
            top: 10px; /* المسافة من الأعلى */
            left: 50%; /* المركز أفقيًا */
            transform: translateX(-50%); /* لجعل العنصر في المنتصف */
            background-color: #f8f9fa; /* لون خلفية فاتح */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* ظل */
            border-radius: 8px; /* زوايا دائرية */
            padding: 15px 20px; /* حشوة داخلية */
            z-index: 1000; /* يظهر فوق كل العناصر */
            text-align: center;
            display: none; /* مخفي افتراضيًا */
        }
        #notifications div {
            margin: 5px 0; /* مسافة بين الإشعارات */
        }
    </style>
</head>
<body>
    <div id="notifications"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // استماع للإشعارات من قناة Laravel Echo
            window.Echo.channel('unit')
                .listen('UnitEvent', (e) => {
                    const notifications = document.getElementById('notifications');
                    const notification = document.createElement('div');
                    notification.textContent = e.message; // نص الإشعار

                    // أضف الإشعار للصندوق
                    notifications.appendChild(notification);

                    // عرض الصندوق إذا لم يكن ظاهرًا
                    notifications.style.display = 'block';

                    // إخفاء الإشعار بعد 5 ثوانٍ
                    setTimeout(() => {
                        notification.remove();
                        if (notifications.children.length === 0) {
                            notifications.style.display = 'none';
                        }
                    }, 5000);
                });
        });
    </script>
</body>
</html>
