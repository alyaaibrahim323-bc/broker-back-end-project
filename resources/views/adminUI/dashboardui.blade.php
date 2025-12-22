@extends('layouts.dashboardUI')

@section('title', 'Noya Dashborad')

@section('content')
<div style="display: flex; gap: 20px;">
    <!-- Main Content -->
    <div class="main-content" style="inline-size: 75%; background: white; border-radius: 30px; padding: 20px;">
        <div class="container-fluid">
            <!-- Top Stats -->
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-center custom-card">
                        <h5 class="card-title">Views</h5>
                        <p class="card-number">7,264</p>
                        <span class="card-percentage">+4.5%</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <h5>New Users</h5>
                        <p>{{ number_format($newUsersCount) }}</p>
                        <span class="{{ $percentageChange >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($percentageChange, 1) }}%
                            @if($percentageChange >= 0)
                                <i class="fas fa-arrow-up"></i>
                            @else
                                <i class="fas fa-arrow-down"></i>
                            @endif
                        </span>
                    </div>
                </div>
                <div class="col-md-3">
    <div class="card text-center">
        <h5>Active Users</h5>
        <p>{{ $activeUsers }}</p>
        <span class="{{ $changePercent >= 0 ? 'text-success' : 'text-danger' }}">
            {{ round($changePercent, 1) }}%
        </span>
    </div>
</div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <h5>Total Sales</h5>
                        <p> {{ $salesData['sales_count'] }}</p>
                        <span>: {{ $salesData['units_count'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="row mt-4">
            {{-- الشارت هنا فيه منها داتا حقيقه وفيه داتا فيك بمجرد ما نشغل الويب سايت نقدر ناخدالداتا الحقيقه  --}}
                <div class="col-md-8">
                    <div class="container ">
                        <div >
                            {{-- دى داتا حقيقه والفانكشن فى UIcontroller  --}}
                            <h6 >Total Users Over Time</h6>

                            <div class="chart-container">
                                <canvas id="lineChart"></canvas>
                            </div>
                        </div>
                       {{-- دى فيك داتا من فانكشن جوا UIcontroller --}}
                        <div class="legend">
                            <div class="bar-chart-container">
                                <h6 class="chart-title">Most Visited Locations</h6>                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    {{-- دى مجرد استايل بس معرفش بتعمل اى --}}

                    <div class="traffic-container">
                        <div class="traffic-header">
                            <h6>Traffic by Website</h6>
                        </div>
                        <div class="traffic-content">
                            <div class="website-list">
                                <div class="website-item">
                                    <span>Google</span>
                                    <div class="traffic-bar">
                                        <div class="bar dark"></div>
                                        <div class="bar light"></div>
                                    </div>
                                </div>
                                <div class="website-item">
                                    <span>YouTube</span>
                                    <div class="traffic-bar">
                                        <div class="bar dark"></div>
                                        <div class="bar light"></div>
                                    </div>
                                </div>
                                <div class="website-item">
                                    <span>Instagram</span>
                                    <div class="traffic-bar">
                                        <div class="bar dark short"></div>
                                        <div class="bar light"></div>
                                    </div>
                                </div>
                                <div class="website-item">
                                    <span>Pinterest</span>
                                    <div class="traffic-bar">
                                        <div class="bar dark long"></div>
                                        <div class="bar light"></div>
                                    </div>
                                </div>
                                <div class="website-item">
                                    <span>Facebook</span>
                                    <div class="traffic-bar">
                                        <div class="bar dark short"></div>
                                        <div class="bar light"></div>
                                    </div>
                                </div>
                                <div class="website-item">
                                    <span>Twitter</span>
                                    <div class="traffic-bar">
                                        <div class="bar dark"></div>
                                        <div class="bar light"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   {{-- دى فيك داتا من فانكشن جوا UIcontroller --}}
                    <div class="doughnut-chart-container">
                        <h6 class="chart-title">Most Visited Offers</h6>
                        <p class="chart-subtitle">July 2024</p>
                        <div class="chart-wrapper">
                            <div class="chart-area">
                                <canvas id="doughnutChart"></canvas>
                            </div>
                            <div class="chart-legend">
                                <ul>
                                    <li><span class="legend-dot black"></span> KingsWAY <span class="legend-value">52.1%</span></li>
                                    <li><span class="legend-dot blue"></span> People&Places <span class="legend-value">22.8%</span></li>
                                    <li><span class="legend-dot green"></span> Elysium <span class="legend-value">13.9%</span></li>
                                    <li><span class="legend-dot gray"></span> Other <span class="legend-value">11.2%</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications Panel -->
    <div class="notifications-panel">
        <div class="notifications-header">
           
            <h3>الإشعارات</h3>
            <select id="notificationFilter">
                <option value="all">all notification </option>
                <option value="unit">unit</option>
                <option value="developer">developer</option>
                <option value="compound">compound</option>
                <option value="user">user</option>
                <option value="offer">offer</option>
            </select>
        </div>
        <ul id="notification-list">
            @foreach($notifications as $notification)
            <li  class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}"
                data-id="{{ $notification->id }}"
                onclick="markNotificationAsRead(this)">

                <strong>
                    @if($notification->type == 'create')
                    @elseif($notification->type == 'update') update-
                    @elseif($notification->type == 'delete') delete-
                    @endif
                </strong>
                {{ $notification->message }}

                <small>{{ $notification->created_at->diffForHumans() }}</small>
            </li>

            @endforeach
        </ul>


    </div>
</div>
{{-- import للشارت  --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- doughnut واسكريبت لل bar شارت الفيك داتا --}}
<script>
    // doughnut Chart
       document.addEventListener("DOMContentLoaded", function () {
        const doughnutCtx = document.getElementById('doughnutChart');
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: ['KingsWAY', 'People&Places', 'Elysium', 'Other'],
                datasets: [{
                    data: [52.1, 22.8, 13.9, 11.2],
                    backgroundColor: ['#2E7D32', '#81C784', '#A5D6A7', '#C8E6C9'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '55%', // تصغير قطر الدائرة الداخلية
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true }
                }
            }
        });
    });


        // bar  Chart
        document.addEventListener("DOMContentLoaded", function () {
        const barCtx = document.getElementById('barChart');

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: @json($barData['labels']),
                datasets: [{
                    data: @json($barData['values']),
                    backgroundColor: ['#81C784', '#A5D6A7', '#2E7D32', '#C8E6C9'],
                    borderRadius: 20,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 13 }, color: '#4B5563' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#E5E7EB' },
                        ticks: { font: { size: 13 }, color: '#6B7280', stepSize: 10000 }
                    }
                },
                barPercentage: 0.5,
                categoryPercentage: 0.6
            }
        });
    });
</script>
{{-- اسكريبت للنتوفكيشن بار --}}
<script >
function markNotificationAsRead(element) {
    const notificationId = element.getAttribute('data-id');

    fetch(`/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            element.classList.add('read');
            element.classList.remove('unread');

            // تحديث العداد
            const countElement = document.getElementById('notification-count');
            let count = parseInt(countElement.textContent);
            if (!isNaN(count) && count > 0) {
                countElement.textContent = count - 1;
            }
        }
    });
}
// ؟؟؟
document.getElementById('notificationFilter').addEventListener('change', function() {
    let filterValue = this.value;
    let notifications = document.querySelectorAll('.notification-item');

    notifications.forEach(notification => {
        if (filterValue === "all") {
            notification.style.display = "block";
        } else if (notification.textContent.includes(filterValue)) {
            notification.style.display = "block";
        } else {
            notification.style.display = "none";
        }
    });
});
</script>
{{--  اسكريبت للاين شارت بلداتا الحقيقيه  --}}
<script>
    const ctx = document.getElementById('lineChart');
    const chartData = @json($chartData);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: 'Developers',
                    data: chartData.developers,
                    borderColor: '#2E7D32',
                    backgroundColor: 'rgba(46, 125, 50, 0.2)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#2E7D32',
                },
                {
                    label: 'Projects',
                    data: chartData.projects,
                    borderColor: '#81C784',
                    backgroundColor: 'rgba(129, 199, 132, 0.2)',
                    tension: 0.4,
                    fill: true,
                    borderDash: [5, 5],
                    pointBackgroundColor: '#81C784',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Developers & Projects Growth',
                    color: '#2E7D32', /* لون العنوان أبيض */
                    font: { size: 16 }
                }
            },
            scales: {
                x: {
                    ticks: { color: '#2E7D32' },
                    grid: { display: false }
                },
                y: {

                    ticks: { stepSize: 0, color: '#2E7D32' },
                    title: {
                        display: true,
                        text: 'Count',
                        color: '#2E7D32'
                    },
                    grid: { display: false }
                }
            }
        }
    });
</script>

<script>
// تحديث البيانات كل دقيقة
function fetchNewUsersData() {
    fetch('/dashboard/new-users')
        .then(response => response.json())
        .then(data => {
            document.getElementById('newUsersCount').textContent = data.count;
            const percentageElement = document.getElementById('percentageIncrease');
            percentageElement.textContent = `${data.percentage}% `;
            percentageElement.className = data.percentage >= 0 ? 'text-success' : 'text-danger';

            // إضافة الأيقونة المناسبة
            const icon = data.percentage >= 0 ?
                '<i class="fas fa-arrow-up"></i>' :
                '<i class="fas fa-arrow-down"></i>';

            percentageElement.innerHTML = `${data.percentage}% ${icon}`;
        });
}

// التشغيل الأولي
fetchNewUsersData();

// التحديث التلقائي كل 60 ثانية
setInterval(fetchNewUsersData, 60000);
</script>

<style>
  .notification-item.unread {
        background: #E8F5E9;
        border-left: 4px solid #2E7D32;
        box-shadow: 0 2px 8px rgba(46, 125, 50, 0.1);
    }

    .notification-item.read {
        background: #f5f5f5;
        border-left: 4px solid #9e9e9e;
        opacity: 0.8;
    }

    .notification-item:hover {
        transform: translateX(5px);
        background: #fafafa !important;
    }

    .notifications-panel {
       width: 350px;
       background: #F7F9FB;
        border-radius: 15px;
       padding: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
       font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
       position: relative;
       z-index: 1000;
   }

   .notifications-header {
       display: flex;
       align-items: center;
       gap: 10px;
       margin-bottom: 20px;
       padding-bottom: 15px;
       border-bottom: 1px solid #eee;
   }

   .notifications-header h3 {
       margin: 0;
       color: #2d3436;
       font-size: 1.2em;
   }

   #notification-icon {
       position: relative;
       cursor: pointer;
       text-decoration: none;
       color: #2E7D32;
       font-size: 1.5em;
       transition: transform 0.3s ease;
   }

   #notification-icon:hover {
       transform: scale(1.1);
   }

   #notification-count {
       position: absolute;
       top: -8px;
       right: -12px;
       background: #ff6b6b;
       color: white;
       padding: 2px 8px;
       border-radius: 10px;
       font-size: 12px;
       font-weight: bold;
       animation: pulse 1.5s infinite;
   }

   #notification-list {
       list-style: none;
       padding: 0;
       margin: 0;
       max-height: none;
       overflow-y: auto;
   }

   .notification-item {
       padding: 15px;
       margin-bottom: 10px;
       border-radius: 10px;
       transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
       cursor: pointer;
       display: flex;
       align-items: center;
       gap: 10px;
   }
   .notification-content p {
       margin: 0;
       color: #2d3436;
       font-weight: 500;
       font-size: 0.95em;
   }

   .notification-content small {
       color: #636e72;
       font-size: 0.8em;
       display: block;
       margin-top: 8px;
   }

   #notification-list::-webkit-scrollbar {
       width: 6px;
   }

   #notification-list::-webkit-scrollbar-track {
       background: #f1f1f1;
       border-radius: 10px;
   }

   #notification-list::-webkit-scrollbar-thumb {
       background: #81C784;
       border-radius: 10px;
   }

   #notification-list li:last-child {
       text-align: center;
       color: #636e72;
       padding: 20px;
       font-style: italic;
   }

   @keyframes pulse {
       0% { transform: scale(1); }
       50% { transform: scale(1.1); }
       100% { transform: scale(1); }
   }

   .fa-clock {
    color: #74b9ff;
    margin-right: 5px;
    }




    #notificationFilter {
    border-radius: 25px;
    border: 2px solid #2E7D32;
    box-shadow: 0px 4px 10px rgba(46, 125, 50, 0.3);
    padding:   3px 7px;
    background: white;
    color: #2d3436;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    right: -40px;
    }

    .chart-container {
        width: 100%;
        margin: auto;
        background:  #F7F9FB; /* خلفية متدرجة */
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    canvas {
        background-color: transparent !important;
    }

    .traffic-container {
    background: #F8FAFC;
    padding: 30px 20px; /* زودت الـ padding */
    border-radius: 10px;
    width: 280px;
    height: 390px; /* زودت الطول */
    font-family: Arial, sans-serif;
    margin-top: 50px; /* المسافة من الأعلى */
    display: flex;
    flex-direction: column;
    justify-content: center; /* لضبط العناصر في المنتصف */
}

.traffic-header h6 {
    Font family:Inter;
    font-size: 16px;
    font-weight: bold;
}

.website-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px; /* زودت المسافة بين العناصر */
    font-size: 13px;
}

.traffic-bar {
    display: flex;
    align-items: center;
    gap: 8px;
}

.bar {
    height: 4px;
    border-radius: 4px;
}

.dark {
    background: black;
    width: 30px;
}

.light {
    background: #D1D5DB;
    width: 40px;
}

.short {
    width: 20px;
}

.long {
    width: 50px;
}

.bar-chart-container {
    background: #F9FAFB;
    padding: 24px;
    border-radius: 16px;
    width: 100%;
    max-width: 800px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.06);
    display: flex;
    flex-direction: column; /* يخلي المحتوى رأسي */
    align-items: flex-start; /* يخلي العنوان والشارت بمحاذاة اليسار */
}

.chart-title {
    font-size: 18px;
    font-weight: bold;
    color: #1F2937;
    margin-bottom: 10px; /* مسافة بين العنوان والشارت */
}


.bar-chart-container h6 {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 14px;
    color: #1F2937;
}


.doughnut-chart-container {
    background: #F9FAFB;
    padding: 30px;
    border-radius: 16px;
    width: 100%;
    max-width: 800px; /* زودت العرض */
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.06);
    text-align: left;
    margin-top: 10px;
    height: 800;

}

.chart-title {
    font-size: 18px;
    font-weight: bold;
    color: #1F2937;
    margin-bottom: 5px;
}

.chart-subtitle {
    font-size: 14px;
    color: #6B7280;
    margin-bottom: 20px;
}

.chart-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 10px; /* المسافة من فوق */
}

.chart-area {
    width: 160px; /* تصغير الشارت */
    height: 160px;
}

.chart-legend ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.chart-legend li {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    color: #333;
    margin-bottom: 10px;
}

.legend-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
}

.black { background: #222; }
.blue { background: #BCE0FD; }
.green { background: #A7DFC0; }
.gray { background: #C8D7E5; }

.legend-value {
    font-weight: bold;
    margin-left: auto;
}

</style>
@endsection

