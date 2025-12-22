import './bootstrap';
import './echo';

import Alpine from 'alpinejs';

window.Alpine = Alpine;


// document.addEventListener('DOMContentLoaded', () => {
//     // جلب الإشعارات عند تحميل الصفحة
//     fetch('/notifications')
//         .then(response => response.json())
//         .then(data => {
//             const notificationList = document.getElementById('notification-list');
//             const notificationCount = document.getElementById('notification-count');

//             notificationCount.textContent = data.length;
//             notificationList.innerHTML = data.map(notification =>
//                 `<li>${notification.message}</li>`
//             ).join('');
//         });

//     // الاستماع للإشعارات الجديدة
//     window.Echo.channel('notifications')
//         .listen('NotificationEvent', (e) => {
//             console.log("📢 إشعار جديد:", e);
//             alert(`📢 إشعار جديد: ${e.message}`);

//             const notificationList = document.getElementById('notification-list');
//             const notificationCount = document.getElementById('notification-count');

//             // إضافة الإشعار الجديد في الأعلى
//             const li = document.createElement('li');
//             li.textContent = e.message;
//             notificationList.prepend(li);

//             // تحديث العداد
//             notificationCount.textContent = parseInt(notificationCount.textContent) + 1;
//         });
// });


//////////////////////////////////////////////
document.addEventListener('DOMContentLoaded', () => {
    // الاستماع للإشعارات الجديدة
    window.Echo.channel('notifications')
        .listen('NotificationEvent', (e) => {
            console.log("📢 إشعار جديد:", e);


            Toastify({
                text: `📢 ${e.sender}  ${e.message}`,
                duration: 8000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "linear-gradient(to right, #4b7bec, #2c3e50)",
            }).showToast();

            const notificationList = document.getElementById('notification-list');
            const notificationCount = document.getElementById('notification-count');

            const li = document.createElement('li');
            li.classList.add('notification-item', 'unread');
            li.textContent = e.message;

            notificationList.prepend(li);

            notificationCount.textContent = parseInt(notificationCount.textContent) + 1;
        });
});
////////////////
// document.addEventListener('DOMContentLoaded', () => {
//     // تأكد من أنك تستخدم القناة الصحيحة (يجب أن تطابق الاسم في الـ Event)
//     window.Echo.channel('notifications') // تغيير اسم القناة هنا
//         .listen('NotificationEvent', (e) => {
//             console.log("📢 إشعار جديد:", e);

//             // تأكد من إضافة مكتبة Toastify في الـ head
//             Toastify({
//                 text: `📢 ${e.message} (بواسطة: ${e.admin_name})`, // أضف اسم الأدمن
//                 duration: 5000,
//                 close: true,
//                 gravity: "top",
//                 position: "right",
//                 style: {
//                     background: "linear-gradient(to right, #4b7bec, #2c3e50)",
//                     'border-radius': '5px',
//                 }
//             }).showToast();

//             // تحديث القائمة
//             const notificationList = document.getElementById('notification-list');
//             const notificationCount = document.getElementById('notification-count');

//             const li = document.createElement('li');
//             li.className = 'notification-item unread';
//             li.innerHTML = `
//                 <div>${e.message}</div>
//                 <small>بواسطة: ${e.admin_name}</small>
//                 <small>${e.created_at}</small>
//             `;

//             notificationList.prepend(li);
//             notificationCount.textContent = parseInt(notificationCount.textContent) + 1;
//         });
// });



Alpine.start();
