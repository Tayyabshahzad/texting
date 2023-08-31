{{-- <div>
    <customer-dashboard :groups="{{ $groups }}" :user="{{ Auth::user() }}" :coupons="{{ Auth::user()->customerCoupons->where('type', 1) }}" :subscribers="{{ $subscribers }}" :details="{{ $customerdetails }}" :subscriber-stats='@json($subscriberstats)' :coupon-stats="{{ $couponstats }}" :redeemed-ratio='@json($redeemedratio)' :saved-newuser-coupon="{{ $savedNewuserCoupon }}" :saved-birthday-coupon="{{ $savedBirthdayCoupon }}" :sent-total="{{ $sentTotal }}" :current-plan="{{ $currentPlan }}" :total-subscribers="{{ $totalSubscribers }}" :monthly-subscribers="{{ $monthlySubscribers }}" :url='@json($liveurl)' :survey='@json($survey)' :survey-counts="{{ $surveyCounts }}">
    </customer-dashboard>
</div> --}}
@section('content')
    <div class="row td-overview">
        <h2 class="td-dashboard-title">Overview</h2>
        <div class="col-xl-4 my-3">
            <div class="d-flex align-items-center td-overview-boxes">
                <div>
                    <img class="img-fluid" src="./assets/images/coupon.png" alt="coupon" />
                </div>
                <div>
                    <h4 class="td-stats-title">Coupon Stats</h4>
                    <h3 class="td-stats-value"> {{ $sentTotal }} / {{ $currentPlan->max_smses }} </h3>
                </div>
            </div>
        </div>
        <div class="col-xl-4 my-3">
            <div class="d-flex align-items-center td-overview-boxes">
                <div>
                    <img class="img-fluid" src="./assets/images/subscriber.png" alt="subscriber" />
                </div>
                <div>
                    <h4 class="td-stats-title">Subscribers</h4>
                    <h3 class="td-stats-value"> {{ $totalSubscribers }} </h3>
                </div>
            </div>
        </div>
        <div class="col-xl-4 my-3">
            <div class="d-flex align-items-center td-overview-boxes">
                <div>
                    <img class="img-fluid" src="./assets/images/new-subscriber.png" alt="new subscriber" />
                </div>
                <div>
                    <h4 class="td-stats-title">New Subscribers</h4>
                    <h3 class="td-stats-value"> {{ $monthlySubscribers }} </h3>
                </div>
            </div>
        </div>
        <div class="col-xl-4 my-3">
            <div class="td-overview-boxes p-3 h-100">
                <h2 class="td-graph-title">Redeemed Coupons</h2>
                <canvas id="barChart" height="300"></canvas>
            </div>
        </div>
        <div class="col-xl-8 my-3">
            <div class="td-overview-boxes p-3">
                <h2 class="td-graph-title">Subscribers</h2>
                <canvas id="lineChart"></canvas>
            </div>
        </div>
        <div class="col-xl-4 my-3">
            <div class="td-overview-boxes p-3">
                <h2 class="td-graph-title">Lorum Ipsum</h2>
                <canvas id="doughnutChart1" height="50"></canvas>
            </div>
        </div>
        <div class="col-xl-4 my-3">
            <div class="td-overview-boxes p-3">
                <h2 class="td-graph-title">Lorum Ipsum</h2>
                <canvas id="doughnutChart2" height="50"></canvas>
            </div>
        </div>
        <div class="col-xl-4 my-3">
            <div class="td-overview-boxes p-3">
                <h2 class="td-graph-title">Lorum Ipsum</h2>
                <canvas id="doughnutChart3" height="50"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
    <script>
        var yearlySubscribers = @json($yearlySubscribers);
        var monthCounts = Array(12).fill(0);
        yearlySubscribers.forEach(entry => {
            var monthIndex = entry.month - 1;
            monthCounts[monthIndex] = entry.count;
        });
        var lineChartConfig = {
            type: "line",
            data: {
                labels: [
                    "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                ],
                datasets: [{
                    label: "",
                    data: monthCounts,
                    borderColor: "rgba(255, 159, 64, 1)",
                    borderWidth: 4,
                    fill: false,
                }],
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true,
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 50,
                            callback: function(value, index, values) {
                                return value % 50 === 0 ? value : "";
                            },
                        },
                    },
                },
            },
        };


        var ctx = document.getElementById('lineChart').getContext('2d');
        var myChart = new Chart(ctx, lineChartConfig);




    </script>
@endsection
